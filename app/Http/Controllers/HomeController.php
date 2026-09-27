<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $totalEvents = Event::count();
        $totalCertificates = Certificate::count();
        $recentEvents = Event::withCount('certificates')
            ->latest()
            ->take(5)
            ->get();
        $recentCertificates = Certificate::with('event')
            ->latest()
            ->take(5)
            ->get();

        return view('home', compact('totalEvents', 'totalCertificates', 'recentEvents', 'recentCertificates'));
    }
}
