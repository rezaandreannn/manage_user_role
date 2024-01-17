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
            ->select(
                'tk.ticket_number as docket',
                'tk.customer',
                'jh.name as mutu',
                'tk.load_qty as qty',
                'tk.delivered_qty',
                'tk.ordered_qty',
                'tk.created_at',
                'tk.jo_number as ref1',
                'tk.sklp_number as ref2',
                'bl.code as bp_name'
            )
            ->join('bp_location as bl', 'bl.id', '=', 'tk.id_batchingplant')
            ->join('bp_jobmix_header as jh', 'jh.id', '=', 'tk.id_jobmix_header')
            ->where('tk.id_jobmix_header', '>', 0)
            ->where('tk.ticket_number', '!=', null)
            ->get();
        // dd($produksi);
        return view('module.bp.produksi', compact('produksi'));
    }

    public function customer(array $customer = null, array $id_batchingplant = null, $startdate = null, $enddate = null)
    {

        // Sample
        $customer = ['PT.ADHI KARYA'];
        $id_batchingplant = [3];


        $Dcustomer = DB::connection('second_db')
            ->table('bp_tickets')
            ->distinct()
            ->select('customer')
            ->where('id_jobmix_header', '>', 0)
            ->whereNotNull('ticket_number');
        !empty($id_batchingplant) ? $Dcustomer->whereIn('id_batchingplant', $id_batchingplant) : null;
        $Dcustomer = $Dcustomer->get();

        $Ddetail = DB::connection('second_db')
            ->table('bp_tickets')
            ->select(
                'bp_tickets.customer as customer',
                DB::raw("sum(bp_tickets.load_qty) as akumulasi"),
                'bp_jobmix_header.name as mutu',
                'bp_jobmix_header.consistency as slump',
                'bp_location.name as bpname',
                'bp_location.code as bpcode',
            )
            ->join('bp_jobmix_header', function ($join) {
                $join->on('bp_jobmix_header.id', '=', 'bp_tickets.id_jobmix_header')
                    ->where('bp_tickets.id_jobmix_header', '>', 0);
            })
            ->join('bp_location', 'bp_location.id', '=', 'bp_tickets.id_batchingplant');
        !empty($customer) ?  $Ddetail->whereIn('bp_tickets.customer', $customer) : null;
        !empty($id_batchingplant) ?  $Ddetail->whereIn('bp_tickets.id_batchingplant', $id_batchingplant) : null;
        $Ddetail = $Ddetail->groupBy('bp_jobmix_header.name', 'bp_tickets.customer', 'bp_jobmix_header.consistency', 'bp_location.name', 'bp_location.code')->get();

        $Dmaterial =  DB::connection('second_db')
            ->table('bp_batch_detail')
            ->select(
                'bp_materials.name as material_name',
                'bp_materials.code as material_code',
                'bp_materials.satuan as satuan',
                DB::raw("sum(bp_batch_detail.net_target) as target"),
                DB::raw("sum(bp_batch_detail.net_actual) as actual")
            )
            ->join('bp_materials', function ($join) {
                $join->on('bp_materials.id', '=', 'bp_batch_detail.id_materials')
                    ->where('bp_batch_detail.id_materials', '>', 0);
            })
            ->join('bp_batch_header', 'bp_batch_header.id', '=', 'bp_batch_detail.id_batch_header')
            ->join('bp_tickets', function ($join) {
                $join->on('bp_tickets.id', '=', 'bp_batch_header.id_tickets')
                    ->whereNotNull('bp_tickets.ticket_number')
                    ->where('bp_tickets.id_jobmix_header', '>', 0);
            })
            ->where('bp_batch_detail.delete_flag', '=', 0);
        !empty($startdate) && !empty($enddate) ? $Dmaterial->where('bt.created_at', '>=', $startdate)->where('bt.created_at', '<', $enddate) : null;
        !empty($customer) ?  $Dmaterial->whereIn('bp_tickets.customer', $customer) : null;


        $Dmaterial = $Dmaterial->groupBy('bp_materials.name', 'bp_materials.code', 'bp_materials.satuan')->get();
        // dd($Dcustomer, $Ddetail, $Dmaterial);
        return view('module.bp.prodcust', compact('Dcustomer', 'Ddetail', 'Dmaterial'));
    }
}
