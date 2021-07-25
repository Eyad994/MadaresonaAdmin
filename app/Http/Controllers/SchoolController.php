<?php

namespace App\Http\Controllers;

use App\Mail\MailtrapExample;
use App\Models\City;
use App\Models\Finance;
use App\Models\Region;
use App\Models\SchoolType;
use App\Models\Status;
use App\Models\School;
use App\Traits\SMS;
use App\User;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class SchoolController extends Controller
{
    use SMS;

    /**
     * SchoolController constructor.
     */
    public function __construct()
    {
        $this->middleware('school');
    }

    public function index()
    {
        $schoolsStatus = Status::all();
        return view('madaresona.schools.index', compact('schoolsStatus'));
    }

    public function schoolsDatable(Request $request)
    {
        if ($request->ajax()) {
            $data = School::latest();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('special', function ($data) {
                    return $data->special == 0 ? 'General' : 'Special';
                })
                ->editColumn('active', function ($data) {
                    return $data->active == 0 ? 'InActive' : 'Active';
                })
                ->addColumn('sn', function ($data) {
                    $finance = Finance::where('user_id', $data->user_id)->orderBy('end_date', 'desc')->first();
                    if ($finance != null)
                        return $finance->uuid;
                    else
                        return null;
                })
                ->make(true);
        }
    }

    /*public function show($id)
    {
        $school = School::where('id', $id)->first();
        return view('madaresona.schools.school', compact('school'));
    }*/

    public function create()
    {
        $schoolsType = SchoolType::all();
        $cities = City::all();
        $regions = Region::all();
        $genderArray = [0 => 'Female', 1 => 'Male', 2 => 'Mixed'];
        $schoolsStatus = Status::all();
        $lastSchoolOrder = School::orderBy('id', 'desc')->value('school_order');
        if ($lastSchoolOrder == '') {
            $lastSchoolOrder = 0;
        }
        return view('madaresona.schools.addSchool', compact('schoolsType', 'cities', 'regions', 'schoolsStatus', 'lastSchoolOrder', 'genderArray'));
    }

    public function edit($id)
    {
        $trueFalseArray = [0 => 'false', 1 => 'true'];
        $genderArray = [0 => 'Female', 1 => 'Male', 2 => 'Mixed'];
        $school = School::with('city')->where('id', $id)->first();
        $genderSchool = explode(',', $school->gender);
        $schoolTypesExploded = explode(',', $school->type);
        $schoolsType = SchoolType::all();
        $cities = City::all();
        $regions = Region::all();
        $schoolsStatus = Status::all();
        $lastSchoolOrder = School::orderBy('id', 'desc')->value('school_order');
        if (request()->ajax()) {
            return view('madaresona.schools.addSchool', compact('schoolsType', 'cities', 'regions', 'schoolsStatus', 'lastSchoolOrder',
                'school', 'trueFalseArray', 'schoolTypesExploded', 'genderArray', 'genderSchool'));
        }
        return view('madaresona.schools.editSchool', compact('schoolsType', 'cities', 'regions', 'schoolsStatus', 'lastSchoolOrder',
            'school', 'trueFalseArray', 'schoolTypesExploded', 'genderArray', 'genderSchool'));
    }

    public function store(Request $request)
    {
        $validations = Validator::make($request->all(), [
            'name_ar' => 'required',
            'name_en' => 'required|unique:schools',
            'gender' => 'required',
            'start' => 'date|required',
            'end' => 'date|required',
            'phone' => 'required|numeric',
            'subscribe_price' => 'numeric|required',
            'status' => 'required'
        ]);

        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        if (isset($request->logo)) {
            $image = $request->file('logo');
            $logo = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/' . $request->name_en), $logo);
        }

        if (isset($request->brochure)) {
            $image = $request->file('brochure');
            $brochure = time() . '_brochure.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/' . $request->name_en), $brochure);
        }

        $school = School::create([
            'type' => implode(',', $request->type),
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'school_order' => $request->school_order,
            'email_school' => $request->email_school,
            'phone' => $request->phone,
            'fax' => $request->fax,
            'website' => $request->website,
            'principle_title_ar' => $request->principle_title_ar,
            'principle_title_en' => $request->principle_title_en,
            'principle_ar' => $request->principle_ar,
            'principle_en' => $request->principle_en,
            'school_details_ar' => $request->school_details_ar,
            'school_details_en' => $request->school_details_en,
            'zip_code' => $request->zip_code,
            'po_box' => $request->po_box,
            'school_logo' => isset($logo) ? $logo : null,
            'country' => 1,
            'city_id' => $request->city_id,
            'region_id' => $request->region_id,
            'status' => $request->status,
            'school_brochure' => isset($brochure) ? $brochure : null,
            'facebook_link' => $request->facebook_link,
            'twitter_link' => $request->twitter_link,
            'instagram_link' => $request->instagram_link,
            'linkedin_link' => $request->linkedin_link,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'curriculum_ls_local' => $request->curriculum_ls_local,
            'curriculum_ls_public' => $request->curriculum_ls_public,
            'discounts_superior' => $request->discounts_superior,
            'discounts_quran' => $request->discounts_quran,
            'discounts_sport' => $request->discounts_sport,
            'discounts_brothers' => $request->discounts_brothers,
            'gender' => implode(',', $request->gender),
            'madaresona_discounts' => $request->madaresona_discounts,
            'contact_person_name' => $request->contact_person_name,
            'contact_person_phone' => $request->contact_person_phone,
            'contact_person_email' => $request->contact_person_email,

        ]);

        if ($school) {
            $config = [
                'table' => 'finances',
                'length' => 13,
                'field' => 'uuid',
                'prefix' => 'MJ-M' . date('Y') . '-'
            ];

            $uid = IdGenerator::generate($config);

            $password = mt_rand(100000, 999999);

            $user = User::create([
                'name' => $request->user_name,
                'email' => $request->email_school,
                'password' => Hash::make($password),
                'type' => 5
            ]);

            $school->update(['user_id' => $user->id]);

            $startDate = Carbon::parse($request->start)->format('Y/m/d');
            $endDate = Carbon::parse($request->end)->format('Y/m/d');

            Finance::create([
                'user_id' => $school->user_id,
                'uuid' => $uid,
                'balance' => $request->subscribe_price,
                'type' => $request->subscribe_type,
                'is_tax' => $request->tax,
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]);

            /* Mail::to('newuser@example.com')->send(new MailtrapExample($password));*/

        }

        return response()->json(['message' => 'Added successfully', 'status' => 200]);

    }

    public function update(Request $request)
    {
        if (request()->ajax()) {
            $validations = Validator::make($request->all(), [
                'name_ar' => 'required',
                'name_en' => 'required|unique:schools,name_en,' . $request->id,
                'gender' => 'required',
                'phone' => 'required|numeric',
                'status' => 'required'
            ]);

            if ($validations->fails()) {
                return response()->json(['errors' => $validations->errors(), 'status' => 422]);
            }

            $school = School::where('id', $request->id)->first();
            $school->update([
                'type' => implode(',', $request->type),
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'school_order' => $request->school_order,
                'email_school' => $request->email_school,
                'phone' => $request->phone,
                'fax' => $request->fax,
                'website' => $request->website,
                'principle_title_ar' => $request->principle_title_ar,
                'principle_title_en' => $request->principle_title_en,
                'principle_ar' => $request->principle_ar,
                'principle_en' => $request->principle_en,
                'school_details_ar' => $request->school_details_ar,
                'school_details_en' => $request->school_details_en,
                'zip_code' => $request->zip_code,
                'po_box' => $request->po_box,
                'country' => 1,
                'special' => $request->special,
                'active' => $request->active,
                'city_id' => $request->city_id,
                'region_id' => $request->region_id,
                'status' => $request->status,
                'facebook_link' => $request->facebook_link,
                'twitter_link' => $request->twitter_link,
                'instagram_link' => $request->instagram_link,
                'linkedin_link' => $request->linkedin_link,
                'lat' => $request->lat,
                'lng' => $request->lng,
                'curriculum_ls_local' => $request->curriculum_ls_local,
                'curriculum_ls_public' => $request->curriculum_ls_public,
                'discounts_superior' => $request->discounts_superior,
                'discounts_quran' => $request->discounts_quran,
                'discounts_sport' => $request->discounts_sport,
                'discounts_brothers' => $request->discounts_brothers,
                'gender' => implode(',', $request->gender),
                'madaresona_discounts' => $request->madaresona_discounts,
                'contact_person_name' => $request->contact_person_name,
                'contact_person_phone' => $request->contact_person_phone,
                'contact_person_email' => $request->contact_person_email,
            ]);
            if (isset($request->logo) && $request->logo != $school->school_logo) {
                $image = $request->file('logo');
                $logo = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/' . $request->name_en), $logo);

                $school->update([
                    'school_logo' => $logo
                ]);

            }
            if (isset($request->brochure) && $request->brochure != $school->school_brochure) {
                $image = $request->file('brochure');
                $brochure = time() . '_brochure.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/' . $request->name_en), $brochure);
                $school->update([
                    'school_brochure' => $brochure
                ]);
            }

            return response()->json(['message' => 'Updated successfully', 'status' => 200]);
        } else {
            $request->validate([
                'name_ar' => 'required',
                'name_en' => 'required|unique:schools,name_en,' . $request->id,
                'gender' => 'required',
                'phone' => 'required|numeric',
            ]);
            $school = School::where('id', $request->id)->first();
            $school->update([
                'type' => implode(',', $request->type),
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'school_order' => $request->school_order,
                'email_school' => $request->email_school,
                'phone' => $request->phone,
                'fax' => $request->fax,
                'website' => $request->website,
                'principle_title_ar' => $request->principle_title_ar,
                'principle_title_en' => $request->principle_title_en,
                'principle_ar' => $request->principle_ar,
                'principle_en' => $request->principle_en,
                'school_details_ar' => $request->school_details_ar,
                'school_details_en' => $request->school_details_en,
                'zip_code' => $request->zip_code,
                'po_box' => $request->po_box,
                'country' => 1,
                'special' => $request->special,
                'active' => $request->active,
                'city_id' => $request->city_id,
                'region_id' => $request->region_id,
                'status' => $request->status,
                'facebook_link' => $request->facebook_link,
                'twitter_link' => $request->twitter_link,
                'instagram_link' => $request->instagram_link,
                'linkedin_link' => $request->linkedin_link,
                'lat' => $request->lat,
                'lng' => $request->lng,
                'curriculum_ls_local' => $request->curriculum_ls_local,
                'curriculum_ls_public' => $request->curriculum_ls_public,
                'discounts_superior' => $request->discounts_superior,
                'discounts_quran' => $request->discounts_quran,
                'discounts_sport' => $request->discounts_sport,
                'discounts_brothers' => $request->discounts_brothers,
                'gender' => implode(',', $request->gender),
                'madaresona_discounts' => $request->madaresona_discounts,
                'contact_person_name' => $request->contact_person_name,
                'contact_person_phone' => $request->contact_person_phone,
                'contact_person_email' => $request->contact_person_email,
            ]);
            if (isset($request->logo) && $request->logo != $school->school_logo) {
                $image = $request->file('logo');
                $logo = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/' . $request->name_en), $logo);

                $school->update([
                    'school_logo' => $logo
                ]);

            }
            if (isset($request->brochure) && $request->brochure != $school->school_brochure) {
                $image = $request->file('brochure');
                $brochure = time() . '_brochure.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/' . $request->name_en), $brochure);
                $school->update([
                    'school_brochure' => $brochure
                ]);
            }

            return response()->json(['message' => 'Updated successfully', 'status' => 200]);
        }

    }

    public function regions($id)
    {
        $regions = Region::where('city_id', $id)->get();
        return $regions;
    }

    public function destroy($id)
    {
        $school = School::where('id', $id)->first();
        $school->delete();
    }
}
