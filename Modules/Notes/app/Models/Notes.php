<?php

namespace Modules\Notes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Modules\Notes\Models\NoteBoards;
use Illuminate\Support\Str;
// use Modules\Notes\Database\Factories\NotesFactory;
use Modules\Notes\Models\NotesTags;
use Modules\Notes\Models\NoteComment;

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
    ];

    protected $casts = [
        // 'tags' => 'array',
        'due_date' => 'date',
    ];
    // protected static function newFactory(): NotesFactory
    // {
    //     // return NotesFactory::new();
    // }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid();
            }
        });
    }

    public function getPriorityLabelAttribute()
    {
        return match ($this->priority) {
            'low' => __('notes.low'),
            'medium' => __('notes.medium'),
            'high' => __('notes.high'),
            'critical' => __('notes.critical'),
        };
    }

    public function getPriorityBadgeClassAttribute()
{
    return match ($this->priority) {
        'low' => 'bg-success-subtle text-success',
        'medium' => 'bg-warning-subtle text-warning', 
        'high' => 'bg-danger-subtle text-danger',
        'critical' => 'badge-gradient-danger',
        default => 'bg-secondary-subtle text-secondary'
    };
}

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

    public function comments()
    {
        return $this->hasMany(NoteComment::class, 'note_id');
    }

    public function attachments()
    {
        return $this->hasMany(NotesAttachment::class, 'note_id');
    }

    public function toSearchableArray() : array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
        ];
    }
}
