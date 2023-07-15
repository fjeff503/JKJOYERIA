<?php

namespace App\Http\Controllers;

use App\Models\Fail;
use Illuminate\Http\Request;

class FailController extends Controller
{
    public function index()
    {
        $data = Fail::get();
        return view('admin.fail.index', compact('data'));
    }
}
