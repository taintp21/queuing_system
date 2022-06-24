<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devices extends Model
{
    use HasFactory;
    protected $table = 'devices';
    protected $primaryKey = 'id';
    protected $fillable = [
        'device_code', 'device_name', 'ip_address', 'status', 'connection'
    ];
}
