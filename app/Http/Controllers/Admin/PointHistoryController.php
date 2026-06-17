<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PointHistory;

class PointHistoryController extends Controller
{
    public function index()
    {
        $histories = PointHistory::with(['user', 'creator'])
            ->latest()
            ->paginate(15);

        return view('admin.point-histories.index', compact('histories'));
    }
}
