<?php

namespace Modules\Notes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Modules\Notes\Models\Notes;
// use Modules\Notes\Database\Factories\NoteBoardsFactory;

class NoteBoards extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'user_id',
        'type',
    ];


    // protected static function newFactory(): NoteBoardsFactory
    // {
    //     // return NoteBoardsFactory::new();
    // }

    public function notes()
    {
        return $this->hasMany(Notes::class, 'board_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
