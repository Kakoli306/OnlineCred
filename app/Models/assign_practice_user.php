<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class assign_practice_user extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'user_type', 'practice_id'];
}
