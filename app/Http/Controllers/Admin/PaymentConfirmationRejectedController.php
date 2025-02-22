<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentConfirmationRejectedController extends Controller
{
    public function index()
    {
        return view('admin.payment_confirmations_rejected.index');
    }
}
