<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubOrgAgenteModel extends Model
{
    use HasFactory;
    protected $table='tb_suborg_agente';
    protected $primaryKey = 'idSubOrg_Agente';
    
}
