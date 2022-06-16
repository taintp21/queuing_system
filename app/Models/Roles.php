<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $fillable = [
        'role_name', 'description', 'role_delegation', 'created_at', 'updated_at'
    ];

    public function setCategoryAttribute($value)
    {
        $this->attributes['role_delegation'] = json_encode($value);
    }

    public function getCategoryAttribute($value)
    {
        return $this->attributes['role_delegation'] = json_decode($value);
    }

    public function users(){
        return $this->hasMany(User::class, 'id');
    }
}
