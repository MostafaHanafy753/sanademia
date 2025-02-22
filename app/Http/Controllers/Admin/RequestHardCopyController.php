<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RequestHardCopy;

class RequestHardCopyController extends Controller
{
    public function index(Request $request)
    { 
        $RequestHardCopies = RequestHardCopy::orderBy("id","desc")->get();
        return view('admin.request_hard_copies.index', compact('RequestHardCopies'));
    }
}
