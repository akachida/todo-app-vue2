<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    public $incrementing = false;

    protected $primaryKey = 'uuid';

    protected $hidden = ['pivot'];

    protected $fillable = [
        'name',
        'color'
    ];

    protected $casts = [
        'uuid' => 'string'
    ];


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
