<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sections extends Model
{
    use HasFactory;
    protected $fillable = [
        'section_name',
        'description',
        'created_by',
    ];
    protected $table = 'sections';
    public function products()
    {
        return $this->hasMany(Products::class,'section_id','id');
    }
}
