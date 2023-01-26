<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Purchase;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'kana',
        'tel',
        'email',
        'postcode',
        'address', 
        'birthday',
        'gender',
        'memo'
    ];

    // 検索機能
    public function scopeSearchCustomers($query, $input = null) {
        if(!empty($input)){
            if(Customer::where('kana', 'like', $input . '%' )
            ->orWhere('tel', 'like', $input . '%')->exists())
            {
                return $query->where('kana', 'like', $input . '%' )
                ->orWhere('tel', 'like', $input . '%'); 
            }
        } 
    }

    // 1対多：単一のモデルが1つ以上の子モデルの親である場合(1人のユーザーが複数の購買情報を持っている)
    public function purchases() {
        return $this->hasMany(Purchase::class);
    }
}
