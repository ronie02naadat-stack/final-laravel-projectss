<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherDashboardController extends Controller
{
    /**
     * Display the teacher dashboard
     */
    public function index()
    {
        $user = auth()->user();
        $response = response()->view('dashboards.teacher', ['user' => $user]);
        return $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
                        ->header('Pragma', 'no-cache')
                        ->header('Expires', '0');
    }
}
