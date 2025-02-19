<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    public $table = 'rooms';
    protected $fillable = ['id', 'name', 'code'];

    public function messages(): HasMany {
        return $this->hasMany(Message::class);
    }

    public function users(): HasMany {
        return $this->hasMany(User::class);
    }
}
