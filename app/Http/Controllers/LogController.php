<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class LogController extends Controller
{
    /**
     * Display application logs with parsing
     */
    public function index()
    {
        try {
            $logFile = storage_path('logs/laravel.log');
            
            if (!file_exists($logFile)) {
                return view('logs.index', ['logs' => [], 'message' => 'No log file found.']);
            }

            $logs = $this->parseLogs($logFile);

            return view('logs.index', compact('logs'));
        } catch (\Exception $e) {
            return view('logs.index', ['logs' => [], 'message' => 'Error reading logs.']);
        }
    }

    /**
     * Parse logs and extract specific information
     */
    private function parseLogs($logFile)
    {
        $rawLogs = file_get_contents($logFile);
        $parsedLogs = [];
        
        // Split by Laravel log separator
        $entries = explode("[", $rawLogs);
        
        foreach ($entries as $entry) {
            $entry = "[" . $entry;
            if (empty(trim($entry))) {
                continue;
            }

            // Extract timestamp
            preg_match('/\[(\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2})\]/', $entry, $timeMatches);
            $timestamp = $timeMatches[1] ?? date('Y-m-d H:i:s');

            // Extract log level
            preg_match('/\[(INFO|ERROR|WARNING|DEBUG|NOTICE)\]/', $entry, $levelMatches);
            $level = $levelMatches[1] ?? 'INFO';

            // Extract action type
            $action = 'Action';
            $type = '';
            $fullDetail = '';
            
            // STUDENT LOGS
            if (strpos($entry, 'Student created in model') !== false) {
                $action = 'Student Created in Database';
                $type = 'created';
                
                preg_match('/"student_id":(\d+)/', $entry, $idMatches);
                preg_match('/"email":"([^"]+)"/', $entry, $emailMatches);
                
                $studentId = $idMatches[1] ?? 'Unknown';
                $studentEmail = $emailMatches[1] ?? 'Unknown';
                $fullDetail = "A new student record has been created with ID #{$studentId} and email {$studentEmail}";
            } 
            elseif (strpos($entry, 'Student updated in model') !== false) {
                $action = 'Student Updated in Database';
                $type = 'updated';
                
                preg_match('/"student_id":(\d+)/', $entry, $idMatches);
                preg_match('/"email":"([^"]+)"/', $entry, $emailMatches);
                
                $studentId = $idMatches[1] ?? 'Unknown';
                $studentEmail = $emailMatches[1] ?? 'Unknown';
                $fullDetail = "Student #{$studentId} (Email: {$studentEmail}) has been updated with new information";
            } 
            elseif (strpos($entry, 'Student deleted in model') !== false) {
                $action = 'Student Deleted from Database';
                $type = 'deleted';
                
                preg_match('/"student_id":(\d+)/', $entry, $idMatches);
                preg_match('/"email":"([^"]+)"/', $entry, $emailMatches);
                
                $studentId = $idMatches[1] ?? 'Unknown';
                $studentEmail = $emailMatches[1] ?? 'Unknown';
                $fullDetail = "Student record #{$studentId} ({$studentEmail}) has been permanently deleted from the system";
            }
            elseif (strpos($entry, 'Student created successfully') !== false) {
                $action = 'Student Created via Form';
                $type = 'created';
                
                preg_match('/"student_id":(\d+)/', $entry, $idMatches);
                preg_match('/"student_email":"([^"]+)"/', $entry, $emailMatches);
                
                $studentId = $idMatches[1] ?? 'Unknown';
                $studentEmail = $emailMatches[1] ?? 'Unknown';
                $fullDetail = "New student created successfully: ID #{$studentId}, Email: {$studentEmail}";
            }
            elseif (strpos($entry, 'Student updated successfully') !== false) {
                $action = 'Student Updated via Form';
                $type = 'updated';
                
                preg_match('/"student_id":(\d+)/', $entry, $idMatches);
                preg_match('/"student_email":"([^"]+)"/', $entry, $emailMatches);
                
                $studentId = $idMatches[1] ?? 'Unknown';
                $studentEmail = $emailMatches[1] ?? 'Unknown';
                $fullDetail = "Student record updated: ID #{$studentId}, Updated email: {$studentEmail}";
            }
            elseif (strpos($entry, 'Student deleted successfully') !== false) {
                $action = 'Student Deleted via UI';
                $type = 'deleted';
                
                preg_match('/"student_id":(\d+)/', $entry, $idMatches);
                
                $studentId = $idMatches[1] ?? 'Unknown';
                $fullDetail = "Student record #{$studentId} has been successfully deleted";
            }
            elseif (strpos($entry, 'Student details viewed') !== false) {
                $action = 'Student Details Viewed';
                $type = 'viewed';
                
                preg_match('/"student_id":(\d+)/', $entry, $idMatches);
                preg_match('/"student_email":"([^"]+)"/', $entry, $emailMatches);
                
                $studentId = $idMatches[1] ?? 'Unknown';
                $studentEmail = $emailMatches[1] ?? 'Unknown';
                $fullDetail = "User viewed details of student #{$studentId} ({$studentEmail})";
            }
            elseif (strpos($entry, 'Student list retrieved') !== false) {
                $action = 'Student List Retrieved';
                $type = 'list';
                
                preg_match('/"count":(\d+)/', $entry, $countMatches);
                $count = $countMatches[1] ?? 'Unknown';
                $fullDetail = "Student list page loaded successfully with {$count} student(s) displayed";
            }
            elseif (strpos($entry, 'Student creation validation failed') !== false) {
                $action = 'Student Creation - Validation Error';
                $type = 'error';
                $fullDetail = "Attempted to create student but validation failed - form has errors";
            }
            elseif (strpos($entry, 'Student update validation failed') !== false) {
                $action = 'Student Update - Validation Error';
                $type = 'error';
                
                preg_match('/"student_id":(\d+)/', $entry, $idMatches);
                $studentId = $idMatches[1] ?? 'Unknown';
                $fullDetail = "Failed to update student #{$studentId} - validation errors detected";
            }
            
            // DEGREE LOGS
            elseif (strpos($entry, 'Degree created in model') !== false) {
                $action = 'Degree Created in Database';
                $type = 'created';
                
                preg_match('/"degree_id":(\d+)/', $entry, $idMatches);
                preg_match('/"title":"([^"]+)"/', $entry, $titleMatches);
                
                $degreeId = $idMatches[1] ?? 'Unknown';
                $degreeTitle = $titleMatches[1] ?? 'Unknown';
                $fullDetail = "A new degree program has been created with ID #{$degreeId} titled '{$degreeTitle}'";
            }
            elseif (strpos($entry, 'Degree updated in model') !== false) {
                $action = 'Degree Updated in Database';
                $type = 'updated';
                
                preg_match('/"degree_id":(\d+)/', $entry, $idMatches);
                preg_match('/"new_title":"([^"]+)"/', $entry, $newTitleMatches);
                preg_match('/"old_title":"([^"]+)"/', $entry, $oldTitleMatches);
                
                $degreeId = $idMatches[1] ?? 'Unknown';
                $oldTitle = $oldTitleMatches[1] ?? 'Unknown';
                $newTitle = $newTitleMatches[1] ?? 'Unknown';
                $fullDetail = "Degree #{$degreeId} has been updated from '{$oldTitle}' to '{$newTitle}'";
            }
            elseif (strpos($entry, 'Degree deleted in model') !== false) {
                $action = 'Degree Deleted from Database';
                $type = 'deleted';
                
                preg_match('/"degree_id":(\d+)/', $entry, $idMatches);
                preg_match('/"title":"([^"]+)"/', $entry, $titleMatches);
                
                $degreeId = $idMatches[1] ?? 'Unknown';
                $degreeTitle = $titleMatches[1] ?? 'Unknown';
                $fullDetail = "Degree #{$degreeId} ('{$degreeTitle}') has been permanently deleted from the system";
            }
            elseif (strpos($entry, 'Degree created successfully') !== false) {
                $action = 'Degree Created via Form';
                $type = 'created';
                
                preg_match('/"degree_id":(\d+)/', $entry, $idMatches);
                preg_match('/"degree_title":"([^"]+)"/', $entry, $titleMatches);
                
                $degreeId = $idMatches[1] ?? 'Unknown';
                $degreeTitle = $titleMatches[1] ?? 'Unknown';
                $fullDetail = "New degree program created: ID #{$degreeId}, Title: '{$degreeTitle}'";
            }
            elseif (strpos($entry, 'Degree updated successfully') !== false) {
                $action = 'Degree Updated via Form';
                $type = 'updated';
                
                preg_match('/"degree_id":(\d+)/', $entry, $idMatches);
                preg_match('/"new_title":"([^"]+)"/', $entry, $newTitleMatches);
                preg_match('/"old_title":"([^"]+)"/', $entry, $oldTitleMatches);
                
                $degreeId = $idMatches[1] ?? 'Unknown';
                $oldTitle = $oldTitleMatches[1] ?? 'Unknown';
                $newTitle = $newTitleMatches[1] ?? 'Unknown';
                $fullDetail = "Degree #{$degreeId} title changed from '{$oldTitle}' to '{$newTitle}'";
            }
            elseif (strpos($entry, 'Degree deleted successfully') !== false) {
                $action = 'Degree Deleted via UI';
                $type = 'deleted';
                
                preg_match('/"degree_id":(\d+)/', $entry, $idMatches);
                preg_match('/"degree_title":"([^"]+)"/', $entry, $titleMatches);
                
                $degreeId = $idMatches[1] ?? 'Unknown';
                $degreeTitle = $titleMatches[1] ?? 'Unknown';
                $fullDetail = "Degree #{$degreeId} ('{$degreeTitle}') successfully deleted";
            }
            elseif (strpos($entry, 'Attempted to delete degree') !== false) {
                $action = 'Degree Deletion Prevented';
                $type = 'warning';
                
                preg_match('/"degree_id":(\d+)/', $entry, $idMatches);
                preg_match('/"degree_title":"([^"]+)"/', $entry, $titleMatches);
                preg_match('/"student_count":(\d+)/', $entry, $countMatches);
                
                $degreeId = $idMatches[1] ?? 'Unknown';
                $degreeTitle = $titleMatches[1] ?? 'Unknown';
                $studentCount = $countMatches[1] ?? 'Unknown';
                $fullDetail = "Attempted to delete degree ID #{$degreeId} ('{$degreeTitle}'), but it cannot be deleted because {$studentCount} student(s) are enrolled";
            }
            elseif (strpos($entry, 'Degree list retrieved') !== false) {
                $action = 'Degree List Retrieved';
                $type = 'list';
                
                preg_match('/"count":(\d+)/', $entry, $countMatches);
                $count = $countMatches[1] ?? 'Unknown';
                $fullDetail = "Degree list page loaded successfully with {$count} degree(s) displayed";
            }
            elseif (strpos($entry, 'Degree creation validation failed') !== false) {
                $action = 'Degree Creation - Validation Error';
                $type = 'error';
                $fullDetail = "Attempted to create degree but validation failed - form has errors";
            }
            elseif (strpos($entry, 'Degree update validation failed') !== false) {
                $action = 'Degree Update - Validation Error';
                $type = 'error';
                
                preg_match('/"degree_id":(\d+)/', $entry, $idMatches);
                $degreeId = $idMatches[1] ?? 'Unknown';
                $fullDetail = "Failed to update degree #{$degreeId} - validation errors detected";
            }
            elseif (strpos($entry, 'ERROR') !== false || strpos($entry, 'Error') !== false) {
                $action = 'System Error';
                $type = 'error';
                $fullDetail = "A system error occurred during operation - check server logs for details";
            }

            $parsedLogs[] = [
                'timestamp' => $timestamp,
                'level' => $level,
                'action' => $action,
                'type' => $type,
                'details' => $fullDetail,
                'raw' => $entry,
            ];
        }

        // Return latest 200 logs first
        return array_slice(array_reverse($parsedLogs), 0, 200);
    }

    /**
     * Clear application logs
     */
    public function clear()
    {
        try {
            $logFile = storage_path('logs/laravel.log');
            
            if (file_exists($logFile)) {
                file_put_contents($logFile, '');
            }

            return redirect()->route('logs.index')->with('success', 'Logs cleared successfully.');
        } catch (\Exception $e) {
            return redirect()->route('logs.index')->with('error', 'Error clearing logs.');
        }
    }

    /**
     * Download logs
     */
    public function download()
    {
        $logFile = storage_path('logs/laravel.log');
        
        if (!file_exists($logFile)) {
            return redirect()->route('logs.index')->with('error', 'Log file not found.');
        }

        return response()->download($logFile, 'laravel-' . now()->format('Y-m-d-H-i-s') . '.log');
    }
}
