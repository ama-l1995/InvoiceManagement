<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number', 'client_id', 'client_name', 'client_address', 'invoice_date', 'due_date', 'items', 'total_amount'
    ];

    protected $casts = [
        'items' => 'array',
        'invoice_date' => 'date',
        'due_date' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function calculateTotalAmount()
    {
        $total = 0;

        foreach ($this->items as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return $total;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($invoice) {
            $invoice->invoice_number = 'INV-' . strtoupper(uniqid());
        });

        static::saving(function ($invoice) {
            $invoice->total_amount = $invoice->calculateTotalAmount();
        });
    }
    
}
