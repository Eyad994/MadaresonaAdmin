<?php

namespace App\Http\Controllers;


use App\Models\Suggestions;
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
        //
        return view('madaresona.suggestions.index');
    }
    public function suggestionsDatatable(Request $request)
    {
        if ($request->ajax()) {
            $data = Suggestions::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->format('d m Y - g:i A');
                })
                ->make(true);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Suggestions  $suggestions
     * @return \Illuminate\Http\Response
     */
    public function show(Suggestions $suggestions)

    {

        return view('madaresona.suggestions.show', compact('suggestions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Suggestions  $suggestions
     * @return \Illuminate\Http\Response
     */
    public function edit(Suggestions $suggestions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Suggestions  $suggestions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Suggestions $suggestions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Suggestions  $suggestions
     * @return \Illuminate\Http\Response
     */
    public function destroy(Suggestions $suggestions)
    {
        $suggestions->delete();
    }
}
