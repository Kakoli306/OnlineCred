<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class assign_practice extends Model
{
    use HasFactory;
    protected $fillable=['admin_id','provider_id','practice_id'];
}
