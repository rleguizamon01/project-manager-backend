<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_name', 
        'description',
        'manager_id',
        'assigned_id',
        'enabled',
    ];

    public function userManager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function userAssigned()
    {
        return $this->belongsTo(User::class, 'assigned_id');
    }
}
