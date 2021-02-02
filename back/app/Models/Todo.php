<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Todo extends Model
{
    public $incrementing = false;

    protected $primaryKey = 'uuid';

    protected $hidden = ['pivot'];

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
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany {
        return $this->belongsToMany(Tag::class, 'todo_tags');
    }
}
