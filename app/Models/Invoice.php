<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = ['id','created_at', 'updated_at'];

    // Relation with Client
    public function client() {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
}
