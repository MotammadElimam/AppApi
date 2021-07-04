<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory;
      
    protected $table = "order_status";
    
    const WITHDRAW = 'WITHDRAW';
    const DEPOSIT = 'DEPOSIT';


     protected $fillable = [
       'price',
       'type'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
   
    

}
