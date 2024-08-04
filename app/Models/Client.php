<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($client) {
            $client->invoices()->delete();
        });
    }
}
