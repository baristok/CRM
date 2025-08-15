<?php

namespace Modules\Notes\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Notes\Models\NoteBoards;
use Modules\Notes\Models\Notes;
use Illuminate\Support\Facades\Auth;
use Exception;
use Modules\Notes\Models\NotesTags;
use Modules\Notes\Models\NoteComment;

class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = NotesTags::all();
        $boards = NoteBoards::where('user_id', Auth::user()->id)
            ->where('type', 'private')
            ->with(['notes' => function ($q) {
                $q->where('user_id', Auth::user()->id);
                $q->orderBy('position', 'asc');
                $q->with('tags');
            }])
            ->get();


        $publicBoards = NoteBoards::where('type', 'public')
            ->orderBy('created_at', 'asc')
            ->with(['notes' => function ($q) {
                $q->orderBy('position', 'asc');
                $q->with('tags');
            }])
            ->get();

        return view('notes::index', compact('boards', 'tags', 'publicBoards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('notes::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storePublicBoard(Request $request)
    {
        if (Auth::user()->hasPermissionTo('public-notes')) {
            try {
                $validated = $request->validate([
                    'name' => 'required|string|max:255',
                ]);

                $board = NoteBoards::create([
                    'name' => $validated['name'],
                    'type' => 'public',
                    'user_id' => Auth::user()->id,
                ]);

                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Board başarıyla oluşturuldu',
                        'board' => $board
                    ]);
                }

                return redirect()->route('notes.index')->with('success', 'Board başarıyla oluşturuldu');
            } catch (Exception $e) {
                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Board oluşturulamadı: ' . $e->getMessage()
                    ], 500);
                }
                return redirect()->back()->with('error', 'Board oluşturulamadı')->with('error_message', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'Yetkiniz yok');
        }
    }

    public function storePrivateBoard(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $board = NoteBoards::create([
                'name' => $validated['name'],
                'user_id' => Auth::user()->id,
                'type' => 'private',
            ]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Board başarıyla oluşturuldu',
                    'board' => $board
                ]);
            }

            return redirect()->route('notes.index')->with('success', 'Board başarıyla oluşturuldu');
        } catch (Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Board oluşturulamadı: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Board oluşturulamadı')->with('error_message', $e->getMessage());
        }
    }
    public function storePublicTask(Request $request)
    {
        if (Auth::user()->hasPermissionTo('public-notes')) {
        try {
            // dd($request->all());
            $validated = $request->validate([
                'board_id' => 'required|exists:note_boards,id',
                'user_id' => 'required|exists:users,id',
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'due_date' => 'nullable|date',
                'tags' => 'nullable|array',
                'progress' => 'nullable|integer|min:0|max:100',
            ]);
            $tags = $validated['tags'] ?? [];
            $maxPosition = Notes::where('board_id', $validated['board_id'])->max('position') ?? 0;
            $task = Notes::create([
                'board_id' => $validated['board_id'],
                'user_id' => $validated['user_id'],
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'due_date' => $validated['due_date'] ?? null,
                'progress' => $validated['progress'] ?? 0,
                'position' => $maxPosition + 1,
            ]);
            $task->tags()->attach($tags);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Task başarıyla oluşturuldu',
                    'task' => $task
                ]);
            }
            return redirect()->route('notes.index')->with('success', 'Task başarıyla oluşturuldu');
        } catch (Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Task oluşturulamadı: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Task oluşturulamadı')->with('error_message', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'Yetkiniz yok');
        }
    }

    public function storePrivateTask(Request $request)
    {
        try {
            $validated = $request->validate([
                'board_id' => 'required|exists:note_boards,id',
                'user_id' => 'required|exists:users,id',
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'due_date' => 'nullable|date',
                'tags' => 'nullable|array',
                'progress' => 'nullable|integer|min:0|max:100',
            ]);
            // Store tags as array (JSON) to match DB column type and model cast
            $tags = $validated['tags'] ?? [];

            // En yüksek position'ı bul ve +1 ekle
            $maxPosition = Notes::where('board_id', $validated['board_id'])->max('position') ?? 0;

            $task = Notes::create([
                'board_id' => $validated['board_id'],
                'user_id' => $validated['user_id'],
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'due_date' => $validated['due_date'] ?? null,
                // 'tags' => $tags,
                'progress' => $validated['progress'] ?? 0,
                'position' => $maxPosition + 1,
            ]);

            $task->tags()->attach($tags);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Task başarıyla oluşturuldu',
                    'task' => $task
                ]);
            }

            return redirect()->route('notes.index')->with('success', 'Task başarıyla oluşturuldu');
        } catch (Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Task oluşturulamadı: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Task oluşturulamadı')->with('error_message', $e->getMessage());
        }
    }


    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('notes::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notes $note)
    {
        // Route Model Binding sayesinde $note zaten bulundu.
        $note->load('tags'); // İlişkili etiketleri yükle

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json($note);
        }

        // Bu view normalde tam sayfa düzenleme için kullanılır,
        // modal kullandığımız için bu kısım şu an aktif olmayabilir.
        return view('notes::edit', compact('note'));
    }
    public function deletePublicNote($id)
    {
        if (Auth::user()->hasPermissionTo('public-notes')) {
        try {
            $note = Notes::findOrFail($id);
            $note->delete();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Not başarıyla silindi'
                ]);
            }

            return redirect()->route('notes.index')->with('success', 'Not başarıyla silindi');
        } catch (Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not silinemedi: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Not silinemedi')->with('error_message', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'Yetkiniz yok');
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notes $note)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'due_date' => 'nullable|date',
                'tags' => 'nullable|array',
                'progress' => 'nullable|integer|min:0|max:100',
            ]);

            // Kullanıcının sadece kendi notunu güncelleyebildiğinden emin ol (isteğe bağlı güvenlik kontrolü)
            if ($note->user_id !== Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Yetkisiz işlem'], 403);
            }

            $note->update($validated);

            if ($request->has('tags')) {
                $note->tags()->sync($request->input('tags'));
            } else {
                // Eğer tags boş gelirse, tüm ilişkili etiketleri kaldır
                $note->tags()->detach();
            }

            if ($request->wantsJson() || $request->ajax()) {
                // Güncellenmiş notu ilişkili etiketlerle birlikte döndür
                $note->load('tags');
                return response()->json([
                    'success' => true,
                    'message' => 'Not başarıyla güncellendi',
                    'note' => $note
                ]);
            }

            return redirect()->route('notes.index')->with('success', 'Not başarıyla güncellendi');
        } catch (Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not güncellenemedi: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Not güncellenemedi')->with('error_message', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}

    public function updatePrivateBoard(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $board = NoteBoards::findOrFail($id);
            $board->update($validated);
            if ($request->has('tags')) {
                $board->tags()->sync($request->input('tags'));
            }


            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Board başarıyla güncellendi',
                    'board' => $board
                ]);
            }

            return redirect()->route('notes.index')->with('success', 'Board başarıyla güncellendi');
        } catch (Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Board güncellenemedi: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Board güncellenemedi')->with('error_message', $e->getMessage());
        }
    }

    public function updatePublicBoard(Request $request, $id)
    {
        if (Auth::user()->hasPermissionTo('public-notes')) {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $board = NoteBoards::findOrFail($id);
            $board->update($validated);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Board başarıyla güncellendi',
                    'board' => $board
                ]);
            }

            return redirect()->route('notes.index')->with('success', 'Board başarıyla güncellendi');
        } catch (Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Board güncellenemedi: ' . $e->getMessage()
                ], 500);
            }
                return redirect()->back()->with('error', 'Board güncellenemedi')->with('error_message', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'Yetkiniz yok');
        }
    }
    public function deletePublicBoard($id)
    {
        if (Auth::user()->hasPermissionTo('public-notes')) {
        try {
            $board = NoteBoards::findOrFail($id);
            $board->delete();
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Board başarıyla silindi'
                ]);
            }
            return redirect()->route('notes.index')->with('success', 'Board başarıyla silindi');
        } catch (Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Board silinemedi: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Board silinemedi')->with('error_message', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'Yetkiniz yok');
        }
    }
    public function deleteBoard($id)
    {
        try {
            $board = NoteBoards::findOrFail($id);
            $board->delete();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Board başarıyla silindi'
                ]);
            }

            return redirect()->route('notes.index')->with('success', 'Board başarıyla silindi');
        } catch (Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Board silinemedi: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Board silinemedi')->with('error_message', $e->getMessage());
        }
    }

    public function deleteNote($id)
    {
        try {
            $note = Notes::findOrFail($id);
            $note->delete();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Not başarıyla silindi'
                ]);
            }

            return redirect()->route('notes.index')->with('success', 'Not başarıyla silindi');
        } catch (Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not silinemedi: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Not silinemedi')->with('error_message', $e->getMessage());
        }
    }

    public function noteDetails($uuid)
{
    $note = Notes::where('uuid', $uuid)
        ->with(['board', 'user', 'tags', 'comments.user'])
        ->firstOrFail();

    $isPrivate = $note->board->type === 'private';

    if ($isPrivate && Auth::id() !== $note->user_id) {
        return redirect()->back()->with('error', 'Yetkiniz yok');
    }

    $noteNo = strtoupper(substr(md5($note->id . $note->created_at . $note->title), 0, 8));

    return view('notes::note-details', compact('note', 'noteNo', 'isPrivate'));
}

    public function storeComment(Request $request)
    {
        $validated = $request->validate([
            'note_id' => 'required|exists:notes,id',
            'comment' => 'required|string',
        ]);
        $comment = NoteComment::create([
            'note_id' => $validated['note_id'],
            'user_id' => Auth::user()->id,
            'comment' => $validated['comment'],
        ]);
        return redirect()->back()->with('success', 'Yorum başarıyla oluşturuldu');
    }
    public function deleteComment($id)
    {
        $comment = NoteComment::findOrFail($id);
        $comment->delete();
        return redirect()->back()->with('success', 'Yorum başarıyla silindi');
    }



}
