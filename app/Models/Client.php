<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    // protected $fillable = ['name','username', 'email', 'phone', 'country', 'avatar', 'status'];
    protected $guarded = ['id','created_at', 'updated_at'];

    // Relation with Task
    public function tasks() {
        return $this->hasMany(Task::class, 'client_id', 'id');
    }

    // Relation with Invoice
    public function invoices() {
        return $this->hasMany(Invoice::class, 'client_id', 'id');
    }

    // Relation with User
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
