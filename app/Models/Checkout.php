<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Checkout extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'camp_id', 'card_number', 'expired', 'cvc', 'is_paid'];

    public function setExpiredAttributes($value)
    {
        $this->attributes['expired'] = date('Y-m', strtotime($value));
    }

    /**
     * Get the user that owns the Checkout
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Camp(): BelongsTo
    {
        return $this->belongsTo(camps::class);
    }
}
