<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'faculty_id'
    ];

    protected $table = "department";

    public function fac()
    {
        return Faculty::find($this->faculty_id);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, "id");
    }

    public function user()
    {
        $this->hasMany(User::class);
    }
}
