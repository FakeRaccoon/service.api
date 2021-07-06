<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $casts = ['repair_process' => 'boolean'];

    protected $fillable = ['customer', 'item', 'status', 'receipt_date'];

    public function parts() {
        return $this->hasMany(Part::class);
    }
}