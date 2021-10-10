<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class provider_address extends Model
{
    use HasFactory;
    protected $fillable=['admin_id','provider_id','street','city','state','zip'];
}
