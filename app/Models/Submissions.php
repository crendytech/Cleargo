<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submissions extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'clearance_id',
        'submission',
        'status',
        'approved_by',
    ];

    public function user()
    {
        return User::where('id', '=', $this->user_id)->first();
    }


}
