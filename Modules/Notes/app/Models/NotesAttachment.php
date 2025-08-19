<?php

namespace Modules\Notes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
// use Modules\Notes\Database\Factories\NotesAttachmentFactory;

class NotesAttachment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'uuid',
        'note_id',
        'original_name',
        'file_name',
        'path',
        'size',
    ];

    // protected static function newFactory(): NotesAttachmentFactory
    // {
    //     // return NotesAttachmentFactory::new();
    // }

    public function note()
    {
        return $this->belongsTo(Notes::class, 'note_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }
}
