<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ResourceLibraryController extends Controller
{
    public function index()
    {
        return view('admin.corporate-tools.resource-library');
    }
}
