<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApprovisionnementController extends Controller
{
    public function index()
    {
        return view('admin.approvisionnement');
    }
}