<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    //
    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'is_active',
    ];

    public function student()
    {
        return $this->hasOne(Student::class, 'user_account_id');
    }
}
