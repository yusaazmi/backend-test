<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    public function approver()
    {
        return $this->belongsTo(Approver::class,'approver_id');
    }
}
