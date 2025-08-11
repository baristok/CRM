<?php

namespace Modules\Notes\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Notes\Models\NoteBoards;
use Modules\Notes\Models\Notes;
use Illuminate\Support\Facades\Auth;
use Exception;
use Modules\Notes\Models\NotesTags;
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
            
        return view('notes::index', compact('boards', 'tags'));
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
    public function store(Request $request){}

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
    public function edit($id)
    {
        return view('notes::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

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

    public function updateNote(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'due_date' => 'nullable|date',
                'tags' => 'nullable|array',
                'progress' => 'nullable|integer|min:0|max:100',
            ]);

            $tags = $validated['tags'] ?? [];
            
            $note = Notes::findOrFail($id);
            $note->update([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'due_date' => $validated['due_date'] ?? null,
                // 'tags' => $tags,
                'progress' => $validated['progress'] ?? 0,
            ]);

            $note->tags()->sync($tags);

            if (request()->expectsJson()) {
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

    public function updatePosition(Request $request)
    {
        try {
            $validated = $request->validate([
                'items' => 'required|array',
                'items.*.id' => 'required|integer|exists:notes,id',
                'items.*.position' => 'required|integer|min:0',
                'items.*.board_id' => 'required|integer|exists:note_boards,id'
            ]);

            foreach ($validated['items'] as $item) {
                Notes::where('id', $item['id'])
                    ->where('user_id', Auth::user()->id) // Güvenlik kontrolü
                    ->update([
                        'position' => $item['position'],
                        'board_id' => $item['board_id']
                    ]);
            }

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pozisyonlar başarıyla güncellendi'
                ]);
            }

            return redirect()->route('notes.index')->with('success', 'Pozisyonlar güncellendi');
        } catch (Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pozisyon güncellenemedi: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Pozisyon güncellenemedi')->with('error_message', $e->getMessage());
        }
    }
}
