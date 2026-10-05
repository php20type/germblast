<?php

namespace App\Http\Controllers\Admin\Operations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SitProgressController extends Controller
{
    public function index()
    {
        return view('admin.operations.sit-progress.index');
    }
}
