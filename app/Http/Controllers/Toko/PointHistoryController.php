<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use App\Models\PointHistory;

class PointHistoryController extends Controller
{
    public function index()
    {
        $histories = PointHistory::with('creator')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(15);

        return view('toko.point-histories.index', compact('histories'));
    }
}
