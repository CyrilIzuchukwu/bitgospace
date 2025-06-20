<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    //
    public function pdf()
    {
        return view('user.pdf.index');
    }
}
