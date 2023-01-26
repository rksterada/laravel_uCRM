<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\Subtotal;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;

    // scopeファイルで連結して、必要な列のみ抽出したテーブルを返す
    protected static function booted() 
    {
        static::addGlobalScope(new Subtotal); 
    }

    // 期間の絞り込み(nullの判定)
    public function scopeBetweenDate($query, $startDate = null, $endDate = null) {
        if(is_null($startDate) && is_null($endDate)) { 
            return $query; 
        } 

        if(!is_null($startDate) && is_null($endDate)) { 
            return $query->where('created_at', ">=", $startDate); 
        }

        if(is_null($startDate) && !is_null($endDate)) {
            $endDate1 = Carbon::parse($endDate)->addDays(1);
            return $query->where('created_at', '<=', $endDate1); 
        }

        if(!is_null($startDate) && !is_null($endDate)) {
            $endDate1 = Carbon::parse($endDate)->addDays(1);
            return $query->where('created_at', ">=", $startDate)
            ->where('created_at', '<=', $endDate1); 
        }
    }
}
