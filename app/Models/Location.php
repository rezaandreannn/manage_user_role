<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Location extends Model
{
    use HasFactory;
    private $db,$db2;
    protected $escapeWhenCastingToString = true;
    public function __construct(){
        $this->db1 = DB::connection('mysql');
        $this->db2 = DB::connection('second_db');
    }

    public function getTableName($id_module){
        
        return $result;
    }

}
