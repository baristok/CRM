<?php

namespace Modules\Notes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Notes\Database\Factories\NoteCommentFactory;
use App\Models\User;
use Modules\Notes\Models\Notes;

class NoteComment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'note_id',
        'user_id',
        'comment',
    ];

    // protected static function newFactory(): NoteCommentFactory
    // {
    //     // return NoteCommentFactory::new();
    // }


    public function note()
    {
        return $this->belongsTo(Notes::class, 'note_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
