<?php

namespace App\Http\Controllers;


use App\Models\Suggestion;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SuggestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('madaresona.suggestions.index');
    }

    public function suggestionsDatatable(Request $request)
    {
        if ($request->ajax()) {
            $data = Suggestion::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->format('d m Y - g:i A');
                })
                ->make(true);

        }
    }

    public function edit($id)
    {
        $suggestions = Suggestion::where('id', $id)->first();
        return view('madaresona.suggestions.show', compact('suggestions'));
    }

    public function destroy($id)
    {
        Suggestion::where('id', $id)->delete();
        return response()->json(['message' => 'Successfully deleted']);
    }

}
