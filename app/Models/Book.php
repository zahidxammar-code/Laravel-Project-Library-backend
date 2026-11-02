<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'genre', 'stock'];

    public function loanItems()
    {
        return $this->hasMany(LoanItem::class);
    }
}