<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        "order_id",
        "amount",
        "attachment",
        "received_date",
        "description",
        "created_by",
        "updated_by",
    ];

    protected $casts = [
        "received_date" => "date",
        "amount" => "decimal:2",
    ];

    // Relationship with order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relationship with creator
    public function creator()
    {
        return $this->belongsTo(User::class, "created_by");
    }

    // Relationship with updater
    public function updater()
    {
        return $this->belongsTo(User::class, "updated_by");
    }
}
