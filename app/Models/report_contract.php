<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class report_contract extends Model
{
    use HasFactory;

    protected $fillable = ['report_id', 'contract_id'];
}
