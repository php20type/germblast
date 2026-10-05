<?php

namespace App\Http\Controllers\Admin\Operations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SitProgramController extends Controller
{
    public function index()
    {
        $technicians = \App\Models\User::role('technician')->where('active', 1)->orderBy('name')->get();
        return view('admin.operations.sit-program.index', compact('technicians'));
    }
}
