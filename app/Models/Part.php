<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Part extends Model
{
    use HasFactory;

    public static function partIndex()
    {
        $part = DB::table('parts')
        ->select('parts.id', 'parts.name', DB::raw('SUM(qty) as qty'))
        ->groupBy('name')
        ->orderBy('id')
        ->get();

        return $part;
    }

    protected $casts = ['selected' => 'boolean'];

    protected $fillable = ['form_id', 'name', 'qty', 'selected'];
}
