<?php

namespace App\Http\Controllers\Module\Truckscale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class MaterialController extends Controller
{
    private $db;

    public function __construct(){
        $this->db = DB::connection('second_db');
    }

    public function index(){
        
        return view('module.ts.material');
    }
}
