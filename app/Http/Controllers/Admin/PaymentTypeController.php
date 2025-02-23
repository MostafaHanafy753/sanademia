<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentType;
use App\Models\PaymentTypeStep;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentTypeController extends Controller
{
    /**
     * Display a listing of payment types.
     */
    public function index()
    {
        $paymentTypes = PaymentType::with('steps')->get();
        return view('admin.payment_types.index', compact('paymentTypes'));
    }

    /**
     * Store a newly created payment type.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:payment_types,name',
            'description' => 'nullable|string',
            'status'      => 'required',
            'image'       => 'required ',
            'steps'       => 'required|array|min:2|max:5',
            'steps.*.title'       => 'required|string|max:255',
            'steps.*.is_required' => 'nullable|boolean',
            'steps.*.is_fixed'    => 'nullable|boolean',
            'steps.*.input_type'  => ['required', Rule::in(['text', 'number', 'select', 'checkbox', 'radio'])],
            'steps.*.default_value' => 'nullable|string',
        ]);

        // Handle Image Upload

        // Create Payment Type
        $paymentType = PaymentType::create([
            'name'        => $request->name,
            'description' => $request->description,
            'status'      => $request->status,
         ]);
         $imageName = rand(1111,9999) . time().'.'.$request->image->extension();

         $request->image->move(public_path('images/payment-types'), $imageName);
         if ($imageName) {
            $paymentType->image = $imageName;
            $paymentType->save();
        }
        // Create Steps
        foreach ($request->steps as $index => $step) {
            PaymentTypeStep::create([
                'payment_type_id' => $paymentType->id,
                'title'           => $step['title'],
                'is_required'     => $step['is_required'] ?? true,
                'is_fixed'        => $step['is_fixed'] ?? false,
                'input_type'      => $step['input_type'],
                'default_value'   => $step['default_value'] ?? null,
                'order'           => $index + 1,
            ]);
        }

        return redirect()->back()->with('success', 'Payment type created successfully!');
    }

    /**
     * Update the specified payment type.
     */
    public function update(Request $request,  $paymentType_id)
    {
        $paymentType = PaymentType::findOrfail($paymentType_id);
        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => 'nullable|string',
            'status'      => 'required',
            'image'       => 'nullable',
            'steps'       => 'required|array|min:2|max:5',
            'steps.*.title'       => 'required|string|max:255',
            'steps.*.is_required' => 'boolean',
            'steps.*.is_fixed'    => 'boolean',
            'steps.*.input_type'  => ['required', Rule::in(['text', 'number', 'select', 'checkbox', 'radio'])],
            'steps.*.default_value' => 'nullable|string',
        ]);
        // Handle Image Upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('payment_types', 'public');
            $paymentType->image = $path;
        }

        // Update Payment Type
        $paymentType->update([
            'name'        => $request->name,
            'description' => $request->description,
            'status'      => $request->status,
        ]);

        // Update Steps (Delete old steps and re-add)
        $paymentType->steps()->delete();
        foreach ($request->steps as $index => $step) {
            PaymentTypeStep::create([
                'payment_type_id' => $paymentType->id,
                'title'           => $step['title'],
                'is_required'     => $step['is_required'] ?? true,
                'is_fixed'        => $step['is_fixed'] ?? false,
                'input_type'      => $step['input_type'],
                'default_value'   => $step['default_value'] ?? null,
                'order'           => $index + 1,
            ]);
        }

        return redirect()->back()->with('success', 'Payment type updated successfully!');
    } // app/Http/Controllers/PaymentTypeController.php
    public function edit($id)
    {
        $paymentType = PaymentType::with('steps')->findOrFail($id);
        return view('admin.payment-types.edit-form', compact('paymentType'))->render();
    }

    /**
     * Remove the specified payment type.
     */public function destroy($id)
{
    $paymentType = PaymentType::find($id);

    // dd(  $paymentType);
    if (!$paymentType) {
        return response()->json(['success' => false, 'message' => 'Payment method not found.']);
    }

    // Delete the image if it exists
    if ($paymentType->image && file_exists(public_path('images/payment-types/' . $paymentType->image))) {
        unlink(public_path('images/payment-types/' . $paymentType->image));
    }

    // Delete the payment method
    $paymentType->delete();

    return response()->json(['success' => true, 'message' => 'Payment method deleted successfully.']);
}

}
