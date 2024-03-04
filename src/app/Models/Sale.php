<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\SoftDeletes;


class Sale extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'amount',
    ];

    public static $rulesStore = [
        'products.*.id' => 'required|integer',
        'products.*.amount' => 'required|integer',
    ];

    public function salesProducts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SalesProduct::class, 'sale_id');
    }
}
