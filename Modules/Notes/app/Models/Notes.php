<?php

namespace Modules\Notes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Modules\Notes\Models\NoteBoards;
// use Modules\Notes\Database\Factories\NotesFactory;
use Modules\Notes\Models\NotesTags;

class Notes extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'board_id',
        'title',
        'description',
        'progress',
        'priority',
        'due_date',
        'image',
        // 'tags',
        'user_id',
        'position',
        // 'slug',
    ];

    protected $casts = [
        // 'tags' => 'array',
        'due_date' => 'date',
    ];
    // protected static function newFactory(): NotesFactory
    // {
    //     // return NotesFactory::new();
    // }

    public function board()
    {
        return $this->belongsTo(NoteBoards::class, 'board_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(NotesTags::class, 'tags_notes', 'note_id', 'tag_id');
    }
}
