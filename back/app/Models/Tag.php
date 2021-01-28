<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $primaryKey = 'uuid';

    protected $fillable = [
        'name',
        'color'
    ];

    protected $casts = [
        'uuid' => 'string'
    ];

    public $incrementing = false;

    /**
     * Retorna todas as tags relacionadas a Tag
     *
     * @return BelongsToMany
     */
    public function todos(): BelongsToMany
    {
        return $this->belongsToMany(Todo::class, 'todo_tags');
    }
}
