<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Item;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'status',
    ];

    // １対多（逆）
    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    // 多対多
    public function items() {
        return $this->belongsToMany(Item::class)
        ->withPivot('quantity');
    }
}
