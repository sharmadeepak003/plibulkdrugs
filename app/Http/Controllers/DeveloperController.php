<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeveloperController extends Controller
{
    public function getErrorLogs()
    {
        $logFile = storage_path('logs\laravel.log');

        $logLines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        $productionPattern = '/^\[([^\]]+)\] Production.ERROR:/';
        $localPattern = '/^\[([^\]]+)\] local.ERROR:/';

        $productionErrors = [];
        $localErrors = [];

        foreach ($logLines as $line) {
            if (preg_match($localPattern, $line, $matches)) {
                $localErrors[] = [
                    'timestamp' => $matches[1],
                    'message' => substr($line, strpos($line, 'local.ERROR:') + 13),
                    'errorType' => 'local.ERROR'
                ];
            }
            elseif (preg_match($productionPattern, $line, $matches)) {
                $productionErrors[] = [
                    'timestamp' => $matches[1],
                    'message' => substr($line, strpos($line, 'Production.ERROR:') + 12),
                    'errorType' => 'Production.ERROR'
                ];
            }
        }

        $allLogErrors = array_merge($productionErrors, $localErrors);

        return view('admin.exception-list', compact('allLogErrors'));
    }
}
