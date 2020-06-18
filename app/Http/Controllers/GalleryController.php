<?php

namespace App\Http\Controllers;

use App\Models\GallarySchool;
use App\School;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{
    public function gallery($id)
    {
        $gallery = GallarySchool::where('school_id', $id)->get();
        $schoolName = School::where('id', $id)->value('name_en');
        return view('madaresona.schools.gallery.create', compact('gallery', 'id', 'schoolName'));
    }

    public function store(Request $request)
    {
        $schoolName = School::where('id', $request->school_id)->value('name_en');
        $validations = Validator::make($request->all(), [
            'galleries' => 'required'
        ]);
        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        foreach ($request->galleries as $gallery) {
            $image = $gallery;
            $imageGallery = time() . '_gallery.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/' . $schoolName . '/gallery'), $imageGallery);

            GallarySchool::create([
                'school_id' => $request->school_id,
                'img' => $imageGallery
            ]);

        }
        return response()->json(['message' => 'Successfully added galleries', 'status' => 200]);
    }

    public function destroy($id)
    {
        $gallery = GallarySchool::with('school:id,name_en')->where('id', $id)->first();
        $file = 'images/'.$gallery->school->name_en.'/gallery/'.$gallery->img;
        File::delete($file);
        $gallery->delete();
        return response()->json(['message' => 'Successfully deleted']);
    }
}