<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    protected $hidden = ['order_id', 'parts_id', 'total', 'created_at' ,'updated_at'];

    public function part()
    {
        return $this->belongsTo(Part::class, 'parts_id', 'id');
    }
}
