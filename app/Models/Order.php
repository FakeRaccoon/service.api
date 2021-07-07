<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $casts = ['repair_process' => 'boolean'];

    protected $fillable = ['customer', 'item', 'status', 'receipt_date'];

    public function orders()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function payment()
    {
        return $this->hasOne(Payment::class)->select(array('id', 'repair_fee', 'dp', 'type'));
    }
    public function customer()
    {
        return $this->hasOne(Customer::class)->select(array('id', 'name', 'address', 'contact'));
    }
}
