<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ActivityComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IcimatrixController extends Controller
{
    public function index()
    {
        return view('admin.icimatrix.index');
    }
}
