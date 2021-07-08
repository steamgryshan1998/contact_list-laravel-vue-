<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'address',
        'updated_at',
    ];

    public function lists()
    {
        return $this->hasMany(Contact::class);
    }
}
