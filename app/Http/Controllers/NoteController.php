<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Note;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = Note::where('user_id', auth()->user()->id)
            ->where('archived', 0)->latest()->get();

        return view('dashboard', compact('notes'));
    }
    function changeAppearance(Request $request)
    {

        $note = Note::where('user_id', auth()->user()->id)
            ->where('id', $request->id)
            ->first();
        $note->update([
            'color_name' => $request->color,
            'appearance_type' => $request->type,
            'image_path' => $request->image
        ]);

        return response()->json(['messsage' => 'success'], 200);
    }
    function archived()
    {
        $notes = Note::where('user_id', auth()->user()->id)
            ->where('archived', 1)->latest()->get();
        return view('archived', compact('notes'));

    }
    function putArchived($id)
    {
        $note = Note::where('user_id', auth()->user()->id)
            ->where('id', $id)
            ->first();
        $note->update([
            'archived' => $note->archived == 1 ? 0 : 1

        ]);

        return redirect()->back();

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Note::create([
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'content' => $request->content
        ]);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $note = Note::findOrFail($id);
        $note->update([
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'content' => $request->content
        ]);
        return redirect()->back();

    }
    function trash()
    {
        $notes = Note::where('user_id', auth()->user()->id)
            ->onlyTrashed()->latest()->get();
        return view('profile.trash-bin', compact('notes'));

    }

    function trashRestore($id)
    {
        $note = Note::where('user_id', auth()->user()->id)
            ->onlyTrashed()
            ->where('id', $id)
            ->firstOrfail();
        $note->restore();
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $note = Note::withTrashed()->findOrFail($id);
        if ($request->permanent_delete == 0) {

            $note->delete();
        } else {

            $note->forceDelete();
        }

        return redirect()->back();
    }
}
