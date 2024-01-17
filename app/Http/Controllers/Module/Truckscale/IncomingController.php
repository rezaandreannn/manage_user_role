<?php

namespace App\Http\Controllers\Module\Truckscale;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IncomingController extends Controller
{
    private $db;

    public function __construct(){
        $this->db = DB::connection('second_db');
    }

    public function index(){
        $Ddetail = $this->db->table('ts_transactions')->where('id_truckscale','=',1)->get();

        // dd($Ddetail);

        return view('module.ts.incoming', compact('Ddetail'));
    }
}
