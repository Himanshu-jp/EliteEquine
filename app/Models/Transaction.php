<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function planData()
    {
        return $this->hasOne(SubscriptionPlan::class, 'id','plan_id');
    }
     public function addonData()
    {
        return $this->hasMany(TransactionAddon::class);
    }
}
