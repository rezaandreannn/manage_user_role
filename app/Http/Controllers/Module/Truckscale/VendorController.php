<?php

namespace App\Http\Controllers\Module\Truckscale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class VendorController extends Controller
{

    private $db;

    public function __construct(){
        $this->db = DB::connection('second_db');
    }

    public function index($id_truckscale=null, $material=null){

        $Dmaterial = $this->db->table('ts_transactions')
            ->distinct()
            ->select('ts_transactions.material_name')
            ->join('ts_location','ts_location.id','=','ts_transactions.id_truckscale')
            ->where('ts_transactions.gross', '>',0)
            ->where('ts_transactions.gross_real', '>',0)
            ->where('ts_transactions.netto', '>',0)
            ->whereNotNull('ts_transactions.date_keluar');
        !empty($id_location) ? $Dmaterial->where('ts_location.master_id_location','=', $id_location) : null;
        // !empty($id_truckscale) ? $Dmaterial->where('ts_transactions.id_truckscale','=', $id_truckscale) : null;
        $Dmaterial = $Dmaterial->get();

        $Ddetail = $this->db->table('ts_transactions')
        ->select('ts_transactions.vendor_name',
                 'ts_transactions.material_code', 
                 'ts_transactions.material_name', 
                 DB::raw("sum(ts_transactions.netto) as akumulasi"), 
                 DB::raw("sum(ts_transactions.kadar_air_kg) as kadar_air_kg"), 
                 'ts_transactions.type_satuan')
        ->join('ts_location','ts_location.id','=','ts_transactions.id_truckscale')
        ->where('ts_transactions.gross', '>',0)
        ->where('ts_transactions.gross_real', '>',0)
        ->where('ts_transactions.netto', '>',0)
        ->whereNotNull('ts_transactions.date_keluar');
        // !empty($id_location) ? $Ddetail->where('ts_location.master_id_location','=', $id_location) : null;
        !empty($id_location) ? $Ddetail->where('ts_location.master_id_location','=', $id_location) : null;
        !empty($material) ? $Ddetail->where('ts_transactions.material_name','=', $material) : null;
        $Ddetail = $Ddetail->groupBy('ts_transactions.vendor_name','ts_transactions.material_code','ts_transactions.type_satuan')->get();

        $Dtransaction = $this->db->table('ts_transactions')
                ->select('no_polisi', 
                    'no_nota as docket', 
                    'no_surat_jalan as surat_jalan', 
                    'date_masuk as date_masuk', 
                    'gross_real', 
                    'gross', 
                    'tare', 
                    'kadar_air_persen', 
                    'kadar_air_kg', 
                    'type_satuan as satuan', 
                    'netto')
                ->where('gross','>',0)
                ->where('gross_real','>',0)
                ->where('netto','>',0)
                ->whereNotNull('date_keluar')
                ->where('vendor_name','=','CV. AGUNG SEMBADA')->get();
        // dd($Dmaterial, $Ddetail);
        return view('module.ts.vendor', compact('Ddetail', 'Dmaterial', 'Dtransaction'));
    }
}
