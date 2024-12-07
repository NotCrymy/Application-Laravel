<?php

namespace App\Http\Controllers;

use App\Models\Log;

class LogController extends Controller
{
    public function index()
{
    $logs = Log::with('user')->latest()->paginate(10); // 10 logs par page
    return view('logs.index', compact('logs'));
}
}