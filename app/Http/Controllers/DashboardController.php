<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function dashboard() : View
    {
        $tickets = new Ticket();
        return view('admin.dashboard', compact('tickets'));
    }
}
