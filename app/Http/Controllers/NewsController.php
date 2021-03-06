<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

class NewsController extends Controller
{

    /**
     * NewsController constructor.
     */
    public function __construct()
    {
        $this->middleware('school');
    }

    public function indexMain()
    {
        return view('madaresona.MainNews.index');
    }

    public function newsMainDatatable(Request $request)
    {
        if ($request->ajax()) {
            $data = News::where('news_type', 2)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('active', function ($data) {
                    return $data->active == 0 ? 'InActive' : 'Active';
                })
                ->make(true);
        }
    }

    public function createMainNews()
    {
        $trueFalseArray = [0 => 'false', 1 => 'true'];
        return view('madaresona.MainNews.create', compact('trueFalseArray'));
    }

    public function storeMainNews(Request $request)
    {
        $validations = Validator::make($request->all(), [
            'title_ar' => 'required',
            'title_en' => 'required',
            'order' => 'required|numeric',
            'active_days' => 'required|numeric',
            'img' => 'required'
        ]);

        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        $userId = Auth::user()->id;

        if (isset($request->img)) {
            $image = $request->file('img');
            $imageNews = time() . '_news.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/Main News'), $imageNews);

            $img = Image::make(public_path('images/Main News/' . $imageNews));

            File::delete(public_path('images/Main News/' . $imageNews));
            $img->insert(public_path('logo.png'), 'top-right', 10, 10);
            $img->save(public_path('images/Main News/' . $imageNews));
        }

        News::create([
            'user_id' => $userId,
            'news_type' => 2,
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
            'text_ar' => $request->text_ar,
            'text_en' => $request->text_en,
            'img' => $imageNews,
            'active' => $request->active,
            'active_days' => $request->active_days,
            'order' => $request->order,
            'youtube' => $request->youtube,
        ]);

        return response()->json(['message' => 'Added successfully', 'status' => 200]);
    }

    public function editMainNews($id)
    {
        $trueFalseArray = [0 => 'false', 1 => 'true'];
        $news = News::where('id', $id)->first();
        return view('madaresona.MainNews.create', compact('news', 'id', 'trueFalseArray'));
    }

    public function updateMainNews(Request $request)
    {
        $validations = Validator::make($request->all(), [
            'title_ar' => 'required',
            'title_en' => 'required',
            'order' => 'required|numeric',
            'active_days' => 'required|numeric'
        ]);
        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        $schoolName = School::where('id', $request->school_id)->value('name_en');


        $news = News::where('id', $request->news_id)->first();
        $news->update([
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
            'text_ar' => $request->text_ar,
            'text_en' => $request->text_en,
            'active' => $request->active,
            'active_days' => $request->active_days,
            'order' => $request->order,
            'youtube' => $request->youtube,
        ]);

        if (isset($request->img) && $request->img != $news->img) {
            $image = $request->file('img');
            $imageNews = time() . '_news.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/Main News'), $imageNews);

            $img = Image::make(public_path('images/Main News/' . $imageNews));
            File::delete(public_path('images/Main News/' . $imageNews));
            $img->insert(public_path('logo.png'), 'top-right', 10, 10);
            $img->save(public_path('images/Main News/' . $imageNews));

            $news->update([
                'img' => $imageNews
            ]);
        }
        $news->save();

        return response()->json(['message' => 'Updated successfully', 'status' => 200]);
    }

    public function destroyMainNews($id)
    {
        $news = News::where('id', $id)->first();
        $file = 'images/Main News/' . $news->img;
        File::delete($file);
        $news->delete();
        return response()->json(['message' => 'Successfully deleted']);
    }

    //news School
    public function index($id)
    {
        $school_name = School::where('id', $id)->value('name_en');
        return view('madaresona.schools.news.index', compact('id', 'school_name'));
    }

    public function newsDatatble(Request $request)
    {
        if ($request->ajax()) {
            $userId = School::where('id', $request->school_id)->value('user_id');
            $data = News::where('user_id', $userId)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('active', function ($data) {
                    return $data->active == 0 ? 'InActive' : 'Active';
                })
                ->addColumn('school_name_en', function ($data) {
                    return School::where('user_id', $data->user_id)->value('name_en');
                })
                ->make(true);
        }
    }

    public function create($id)
    {
        $trueFalseArray = [0 => 'false', 1 => 'true'];
        return view('madaresona.schools.news.create', compact('id', 'trueFalseArray'));
    }

    public function edit($id)
    {
        $trueFalseArray = [0 => 'false', 1 => 'true'];
        $news = News::where('id', $id)->first();
        $schoolName = School::where('user_id', $news->user_id)->value('name_en');
        return view('madaresona.schools.news.create', compact('news', 'id', 'trueFalseArray', 'schoolName'));
    }

    public function store(Request $request)
    {
        $validations = Validator::make($request->all(), [
            'title_ar' => 'required',
            'title_en' => 'required',
            'img' => 'required',
            'active_days' => 'required'
        ]);

        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        $userId = School::where('id', $request->school_id)->value('user_id');
        $schoolName = School::where('id', $request->school_id)->value('name_en');

        if (isset($request->img)) {

            $image = $request->file('img');
            $imageNews = time() . '_news.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/' . $schoolName . '/news'), $imageNews);

            $img = Image::make(public_path('images/' . $schoolName . '/news/' . $imageNews));
            File::delete(public_path('images/' . $schoolName . '/news/' . $imageNews));
            $img->insert(public_path('logo.png'), 'top-right', 10, 10);
            $img->save(public_path('images/' . $schoolName . '/news/' . $imageNews));
        }

        News::create([
            'user_id' => $userId,
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
            'text_ar' => $request->text_ar,
            'text_en' => $request->text_en,
            'img' => $imageNews,
            'active' => $request->active,
            'active_days' => $request->active_days,
            'order' => $request->order,
            'youtube' => $request->youtube,
        ]);

        return response()->json(['message' => 'Added successfully', 'status' => 200]);
    }

    public function update(Request $request)
    {
        $validations = Validator::make($request->all(), [
            'title_ar' => 'required',
            'title_en' => 'required',
            'active_days' => 'required'
        ]);
        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        $schoolName = School::where('user_id', $request->school_id)->value('name_en');

        $news = News::where('id', $request->news_id)->first();
        $news->update([
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
            'text_ar' => $request->text_ar,
            'text_en' => $request->text_en,
            'active' => $request->active,
            'active_days' => $request->active_days,
            'order' => $request->order,
            'youtube' => $request->youtube,
        ]);

        if (isset($request->img) && $request->img != $news->img) {
            $image = $request->file('img');
            $imageNews = time() . '_news.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/' . $schoolName . '/news'), $imageNews);

            $img = Image::make(public_path('images/' . $schoolName . '/news/' . $imageNews));
            File::delete(public_path('images/' . $schoolName . '/news/' . $imageNews));
            $img->insert(public_path('logo.png'), 'top-right', 10, 10);
            $img->save(public_path('images/' . $schoolName . '/news/' . $imageNews));

            $news->update([
                'img' => $imageNews
            ]);
        }
        $news->save();

        return response()->json(['message' => 'Updated successfully', 'status' => 200]);
    }

    public function destroy($id)
    {
        $news = News::where('id', $id)->first();
        $schoolName = School::where('user_id', $news->user_id)->value('name_en');
        $file = 'images/' . $schoolName . '/news/' . $news->img;
        File::delete($file);
        $news->delete();
        return response()->json(['message' => 'Successfully deleted']);
    }
}
