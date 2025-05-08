<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Item extends Model
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
    public function itemType()
    {
        return $this->belongsTo(ItemType::class);
    }
    public function itemGroup()
    {
        return $this->belongsTo(ItemGroup::class);
    }
    public function itemAccountGroup()
    {
        return $this->belongsTo(ItemAccountGroup::class);
    }
    public function itemUnit()
    {
        return $this->belongsTo(ItemUnit::class);
    }
}
