<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = false;

    protected $table = 'users';

    protected $fillable = [
        'id', 
        'name', 
        'email',
        'created_at', 
        'updated_at', 
        'is_deleted'
    ];
}
