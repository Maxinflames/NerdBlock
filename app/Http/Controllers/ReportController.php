<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\genre;
use App\client;
use App\subscription;
use Session;
use Carbon\Carbon;

class ReportController extends Controller
{
    //
    public function index()
    {
        return view('report.index');
    }

}
