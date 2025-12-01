<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RutinaCompletion extends Model
{
    use HasFactory;

    protected $table = 'rutina_completions';

    protected $fillable = [
        'rutina_id',
        'user_id',
        'date',
    ];

    public function rutina()
    {
        return $this->belongsTo(Rutina::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
