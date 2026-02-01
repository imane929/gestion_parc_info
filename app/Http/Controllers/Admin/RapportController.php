<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipement;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Affectation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\RapportExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class RapportController extends Controller
{
    public function index()
    {
        return view('admin.rapports.index');
    }
    
    public function generate(Request $request)
    {
        $request->validate([
            'type' => 'required|in:equipements,utilisateurs,tickets,affectations',
            'format' => 'required|in:pdf,excel,csv',
            'periode' => 'required|in:today,week,month,year,all',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);
        
        $data = $this->getReportData($request);
        
        if ($request->format === 'pdf') {
            return $this->generatePdf($data, $request);
        } elseif ($request->format === 'excel') {
            return $this->generateExcel($data, $request);
        } else {
            return $this->generateCsv($data, $request);
        }
    }
    
    private function getReportData($request)
    {
        $periode = $request->periode;
        $type = $request->type;
        
        switch ($type) {
            case 'equipements':
                $query = Equipement::query();
                break;
            case 'utilisateurs':
                $query = User::query();
                break;
            case 'tickets':
                $query = Ticket::with(['equipement', 'technicien']);
                break;
            case 'affectations':
                $query = Affectation::with(['equipement', 'user']);
                break;
            default:
                $query = null;
        }
        
        if ($query) {
            $query = $this->applyDateFilter($query, $periode, $request);
        }
        
        return $query ? $query->get() : [];
    }
    
    private function applyDateFilter($query, $periode, $request)
    {
        $carbon = Carbon::now();
        
        switch ($periode) {
            case 'today':
                return $query->whereDate('created_at', $carbon);
            case 'week':
                return $query->whereBetween('created_at', [$carbon->startOfWeek(), $carbon->endOfWeek()]);
            case 'month':
                return $query->whereMonth('created_at', $carbon->month)
                    ->whereYear('created_at', $carbon->year);
            case 'year':
                return $query->whereYear('created_at', $carbon->year);
            case 'all':
                return $query;
            default:
                if ($request->start_date && $request->end_date) {
                    return $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
                }
                return $query;
        }
    }
    
    private function generatePdf($data, $request)
    {
        $pdf = Pdf::loadView('admin.rapports.pdf', [
            'data' => $data,
            'type' => $request->type,
            'periode' => $request->periode,
            'date' => Carbon::now()->format('d/m/Y H:i'),
            'pdf' => null // This will be set by DomPDF
        ]);
        
        $filename = 'rapport-' . $request->type . '-' . Carbon::now()->format('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }
    
    private function generateExcel($data, $request)
    {
        $export = new RapportExport($data, $request->type, $request->periode);
        $filename = 'rapport-' . $request->type . '-' . Carbon::now()->format('Y-m-d') . '.xlsx';
        
        return Excel::download($export, $filename);
    }
    
    private function generateCsv($data, $request)
    {
        $export = new RapportExport($data, $request->type, $request->periode);
        $filename = 'rapport-' . $request->type . '-' . Carbon::now()->format('Y-m-d') . '.csv';
        
        return Excel::download($export, $filename, \Maatwebsite\Excel\Excel::CSV, [
            'Content-Type' => 'text/csv',
        ]);
    }
}