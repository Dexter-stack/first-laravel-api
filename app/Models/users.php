<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class users extends Model
{
    use HasFactory,HasApiTokens;
    public $table = "users";
}
