<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = ['amount','status_id'];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function approval()
    {
        return $this->hasMany(Approval::class,'expense_id')->with('approver');
    }
}
