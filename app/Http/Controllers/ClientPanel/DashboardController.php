<?php

namespace App\Http\Controllers\ClientPanel;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('client.client-panel.index');
    }
}
