<?php

namespace Modules\Notes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Notes\Database\Factories\NotesTagsFactory;
use Modules\Notes\Models\Notes;

class NotesTags extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
    ];

    protected static function newFactory(): NotesTagsFactory
    {
        return NotesTagsFactory::new();
    }

    public function notes()
    {
        return $this->belongsToMany(Notes::class, 'tags_notes', 'tag_id', 'note_id');
    }
}
