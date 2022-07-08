<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiveNum extends Model
{
    use HasFactory;

    protected $table = 'give_num';
    protected $primaryKey = 'id';
    protected $dates = [
        'created_at',
        'updated_at',
        'expired_date',
    ];
    protected $fillable = [
        'order',
        'name',
        'phone',
        'email',
        'services_id',
        'expired_date',
        'status',
        'supply',
    ];

    public function services()
    {
        return $this->belongsTo(Services::class, 'services_id', 'id');
    }
}
