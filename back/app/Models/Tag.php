<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tag extends Model
{
    protected $primaryKey = 'uuid';

    protected $fillable = [
        'name'
    ];

    protected $casts = [
        'uuid' => 'string'
    ];
}
