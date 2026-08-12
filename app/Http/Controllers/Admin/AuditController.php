<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    public function index()
    {
        return view('admin.operations.audits');
    }

    public function show($id)
    {
        return view('admin.operations.audit-detail', ['id' => $id]);
    }
}
