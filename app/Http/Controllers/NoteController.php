<?php

namespace App\Http\Controllers;
use App\Models\Note;
use App\School;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class NoteController extends Controller
{
    public function index($id)
    {
       $school_name= School::where('id', $id)->value('name_en');
        return view('madaresona.schools.note.index', compact('id','school_name'));
    }

    public function noteDatatble(Request $request)
    {
        if ($request->ajax()) {
            $user_id= School::where('id', $request->school_id)->value('user_id');
            $data = Note::where('user_id', $user_id)->where('note_type',1)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('added_by', function ($data){
                    return User::where('id', $data->added_by)->value('name');
                })
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->format('d m Y - g:i A');
                })
                ->make(true);
        }

    }

    public function create($id)
    {
        return view('madaresona.schools.note.create', compact('id'));
    }

    public function edit($id)
    {
        $note = Note::where('id', $id)->first();
        return view('madaresona.schools.note.create', compact('note','id'));
    }

    public function store(Request $request)
    {
        $validations = Validator::make($request->all(), [
            'note_text' => 'required',
        ]);
        if ($validations->fails()){
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }
        $user_id= School::where('id', $request->school_id)->value('user_id');
        Note::create([
            'user_id' => $user_id,
            'note_type' => 1,
            'note' => $request->note_text,
            'added_by' => auth()->user()->id,
        ]);

        return response()->json(['message' => 'Added successfully', 'status' => 200]);
    }

    public function update(Request $request)
    {
        $validations = Validator::make($request->all(), [
            'note_text' => 'required',

        ]);
        if ($validations->fails()){
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        Note::where('id', $request->school_id)->update([
            'note' => $request->note_text,
        ]);

        return response()->json(['message' => 'Updated successfully', 'status' => 200]);
    }
    public function destroy($id)
    {
        Note::where('id', $id)->delete();
        return response()->json(['message' => 'Successfully deleted']);
    }

}
