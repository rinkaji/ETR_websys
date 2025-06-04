<?php

namespace App\Http\Controllers;

use App\Models\Supply;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AdminOverallStockCardController extends Controller
{
    public function showOverallStockCard()
    {
        $supplies = Supply::where('type', 'Office Supplies')->get();
        $janitorialSupplies = Supply::where('type', 'Janitorial Supplies')->get();
        $medicalSupplies = Supply::where('type', 'Medical Supplies')->get();
        return view('admin.overallStockCard', compact('supplies', 'janitorialSupplies', 'medicalSupplies'));
    }

    public function downloadInventoryReport()
    {
        $supplies = Supply::where('type', 'Office Supplies')->get();
        $janitorialSupplies = Supply::where('type', 'Janitorial Supplies')->get();
        $medicalSupplies = Supply::where('type', 'Medical Supplies')->get();

        $pdf = Pdf::loadView('admin.overallStockCard', compact('supplies', 'janitorialSupplies', 'medicalSupplies'))->setPaper('A4', 'landscape');

        return $pdf->download('January_Inventory_2025.pdf');
    }
}
