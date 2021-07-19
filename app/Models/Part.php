<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Part extends Model
{
    use HasFactory;

    protected $casts = ['selected' => 'boolean'];

    protected $fillable = ['form_id', 'name', 'qty', 'selected'];
}
