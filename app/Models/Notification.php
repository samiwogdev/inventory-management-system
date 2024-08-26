<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

        // Specify the fields that are mass assignable
        protected $fillable = [
            'user_id', 
            'type', 
            'data', 
            'read'
        ];
}
