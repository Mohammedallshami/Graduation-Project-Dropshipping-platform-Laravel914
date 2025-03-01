<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;

    protected $table = 'order details';

    protected $fillable = ['order_details_id', 'order_id', 'pro_id', 'quantity', 'total_cost',
        'sub_weight', 'created_at', 'updated_at'];
    
        public function product()
        {
            return $this->belongsTo(Product::class, 'pro_id', 'id');
        }
    
        public function order()
        {
            return $this->belongsTo(Order::class, 'order_id', 'order_id');
        }
}
