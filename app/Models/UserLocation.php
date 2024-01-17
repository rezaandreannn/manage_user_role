<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserLocation extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'model_has_permissions';

    protected $guarded = [];
}
