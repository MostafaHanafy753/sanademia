<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use Illuminate\Http\Request;

class testController extends Controller
{
    public function statements( )
    {
                 return view('admin.teachers.statements');
    }
    public function userstatements( )
    {
                 return view('admin.users.statements');
    }
    // public function payment( )
    // {
    //          $paymentTypes = PaymentType::with('steps')->get();
    //         return view('admin.payment_types.index', compact('paymentTypes'));
    //      }
 }

 