<?php

namespace App\Http\Controllers\Module\BatchingPlant;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProduksiController extends Controller
{
    public function index()
    {
        $produksi = DB::connection('second_db')
            ->table('bp_tickets as tk')
            ->select('tk.ticket_number as docket', 'tk.customer', 'jh.name as mutu', 'tk.load_qty as qty', 'tk.delivered_qty', 'tk.ordered_qty', 'tk.created_at', 'tk.jo_number as ref1', 'tk.sklp_number as ref2', 'bl.code as bp_name')
            ->join('bp_location as bl', 'bl.id', '=', 'tk.id_batchingplant')
            ->join('bp_jobmix_header as jh', 'jh.id', '=', 'tk.id_jobmix_header')
            ->where('tk.id_jobmix_header', '>', 0)
            ->get();
        // dd($produksi);
        return view('module.bp.produksi', compact('produksi'));
    }
}
