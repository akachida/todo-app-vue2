<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Todo extends Model
{
    protected $primaryKey = 'uuid';

    protected $fillable = [
        'title',
        'description'
    ];

    protected $casts = [
        'uuid' => 'string'
    ];

    /**
     * Retorna todas as tags relacionadas ao Todo
     *
     * @return HasMany
     */
    public function tags(): HasMany {
        return $this->hasMany(Tag::class, 'todo_uuid');
    }
}
