<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    
}

User::create([
    'name' => 'Test User',
    'email' => 'test@example.com',
    'password' => bcrypt('password'), // Replace 'password' with your desired password
    'role' => 'admin', // Adjust the role as needed
]);