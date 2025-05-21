<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tickets;
use App\Models\History;

class AdminController extends Controller
{
    public function index() {
    $totalTickets = Tickets::count();
    
    $activeTickets = Tickets::where('expired', '>=', now())->count();
    $expiredTickets = Tickets::where('expired', '<', now())->count();
    
    $soldTickets = History::distinct('id')->count();
    $unsoldTickets = $totalTickets - $soldTickets;
    
    $pendingPayments = History::where('status', 'pending')->count();

    return view('admin.dashboard', compact(
       'totalTickets',
            'activeTickets',  
            'expiredTickets', 
            'soldTickets',
            'unsoldTickets',
            'pendingPayments'
    ));
}
}
