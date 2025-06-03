<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminOverallStockCardController extends Controller
{
    public function showOverallStockCard()
    {
        return view('admin.overallStockCard');
    }
}
