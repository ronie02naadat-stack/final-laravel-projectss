<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentDashboardController extends Controller
{
    /**
     * Display the student dashboard
     */
    public function index()
    {
        $user = auth()->user();
        $response = response()->view('dashboards.student', ['user' => $user]);
        return $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
                        ->header('Pragma', 'no-cache')
                        ->header('Expires', '0');
    }
}
