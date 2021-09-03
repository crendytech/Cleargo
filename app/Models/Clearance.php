<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clearance extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "type",
        "description",
        "managed_by"
    ];

    protected $table = "clearance";

    public function manager(){
        $name = "";
        if($this->type == "general" || $this->type == "departmental")
        {
            if($this->managed_by == 0)
            {
                $name = "Administrator";
            }else
            {
                $name = Department::find($this->managed_by)->name." Department";
            }
        }else
        {
            $name = "Faculty of ".Faculty::find($this->managed_by)->name;
        }
        return $name;
    }

    public function submission()
    {
        return Submissions::where([
            ['clearance_id', '=', $this->id],
            ['user_id', '=', \Auth::user()->id],
        ])->first();

    }
}
