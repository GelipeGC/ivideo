<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserUsageController extends Controller
{
    public function getStorageUsage(Request $request)
    {
        return [
            'data' => [
                'usage' => $request->user()->usage()
            ]
        ];
    }
}
