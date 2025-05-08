<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StockIssue extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];
    
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function stockIssueItems()
    {
        return $this->hasMany(StockIssueItem::class);
    }
}
