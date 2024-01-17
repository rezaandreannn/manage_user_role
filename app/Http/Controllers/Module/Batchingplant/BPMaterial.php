<?php

namespace App\Http\Controllers\Module\Batchingplant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;


class BPMaterial extends Controller
{
    public function __construct(){
        $this->db =  DB::connection('second_db');
    }
    
    public function index(){
        $result = $this->db->table('bp_tickets')
            ->select(
                DB::raw("sum(bp_batch_detail.net_target) as target"), 
                DB::raw("sum(bp_batch_detail.net_actual) as actual"), 
                'bp_materials.name as material_name', 
                'bp_materials.code as material_code', 
                'bp_materials.satuan as satuan', 
                'bp_location.code as bpcode')
        ->join('bp_batch_header','bp_batch_header.id_tickets','=','bp_tickets.id')
        ->join('bp_batch_detail','bp_batch_header.id','=','bp_batch_detail.id_batch_header')
        ->join('bp_materials',function($join) {
            $join->on('bp_materials.id','=','bp_batch_detail.id_materials')
            ->where('bp_batch_detail.id_materials','>',0);
        })
        ->join('bp_location','bp_location.id','=','bp_tickets.id_batchingplant')
        ->whereNotNull('bp_tickets.ticket_number')
        ->where('bp_batch_header.batch_start','>=','2024-01-01 00:00')
        ->where('bp_batch_header.batch_end','<','2024-01-06 14:24')
        ->groupBy('bp_materials.name','bp_materials.code','bp_location.code','bp_materials.satuan')
        ->get();
        
        // dd($result);
        return view('module.bp.material', compact('result'));
    }
}
