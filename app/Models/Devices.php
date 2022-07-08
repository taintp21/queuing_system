<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Devices extends Model
{
    use HasFactory;
    protected $table = 'devices';
    protected $primaryKey = 'id';
    protected $fillable = [
        'device_code', 'device_name', 'device_type', 'ip_address', 'username', 'password', 'status', 'connection', 'description'
    ];
}
