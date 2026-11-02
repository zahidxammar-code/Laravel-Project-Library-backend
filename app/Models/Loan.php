<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = ['borrower_name', 'phone', 'due_date'];

    public function items()
    {
        return $this->hasMany(LoanItem::class);
    }
}