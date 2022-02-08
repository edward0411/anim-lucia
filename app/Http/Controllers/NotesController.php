<?php

namespace App\Http\Controllers;
use \App\Models\Note;
use Storage;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    //
    public function index(){
        $notes = Note::all();
    
        $public_path = public_path();
        return view('notes.index', compact('notes','public_path'));
    }
    public function destroy($id){
        Note::findOrFail($id)->delete();    
        return redirect()->back();
    }
    public function store(request $request){
        $note =  new Note();
        $note->title = $request->title;
        $note->content = $request->content;


        $file = $request->file('document');
        $nombre = $file->getClientOriginalName();
        Storage::disk('local')->put($nombre,  \File::get($file));
 

        $note->document = $nombre;
        $note->save();
        $notes = Note::all();
        $public_path = public_path();
        return view('notes.index', compact('notes','public_path'));
    }


        
}
