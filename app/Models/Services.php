<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;
    protected $table = 'services';
    protected $primaryKey = 'id';
    protected $fillable = [
        'service_code', 'service_name', 'description', 'status', '', 'number_from', 'number_to', 'prefix', 'surfix'
    ];

    public function give_num()
    {
        return $this->hasMany(GiveNum::class, 'services_id', 'id');
    }
}
