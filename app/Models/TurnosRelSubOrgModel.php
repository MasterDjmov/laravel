<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurnosRelSubOrgModel extends Model
{
    use HasFactory;
    protected $table='tb_turnos_suborg';
    protected $primaryKey = 'idTurnos_SubOrg';
}
