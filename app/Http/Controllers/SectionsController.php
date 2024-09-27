<?php

namespace App\Http\Controllers;

use App\Models\Sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Sections::all();
        return view('Dashboard.sections.sections', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // check if exist
        $section_exists = Sections::where('section_name', $request->section_name)->exists();

        if ($section_exists) {
            return redirect()->route('sections.index')->with('error', 'اسم القسم موجود  بالفعل لا يمكن تكرارة');
        }
        // Validate the request data.
        $vlidation = $request->validate([
            'section_name' => ['required', 'unique:sections', 'string', 'max:255'],
        ], [
            'section_name.required' => 'لا يمكن ترك حقل اسم القسم فارغا يرجي ادخال الاسم ',
            // 'section_name.unique' => 'اسم القسم موجود  بالفعل لا يمكن تكرارة',
        ]);

        $user = Auth::user()->name;
        // Create a new section it to the database.
        $sections = Sections::create([
            'section_name' => $request->section_name,
            'created_by' => $user,
        ]);
        return redirect()->route('sections.index')->with('success', 'تم انشاء القسم بنجاح');
        // other way
        // $section= new Sections();
        // $section->section_name = $request->section_name;
        // $section->description = $request->description;
        // $section->created_by = $user;
        // $section->save();
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // تحقق من وجود القسم بنفس الاسم، مع استثناء الـ ID الحالي
        $section_exists = Sections::where('section_name', $request->section_name)
            ->where('id', '!=', $id)  // استثناء القسم الحالي
            ->exists();

        if ($section_exists) {
            return redirect()->route('sections.index')->with('error', 'اسم القسم موجود بالفعل لا يمكن تكراره');
        }

        // قواعد التحقق
        $validation = $request->validate([
            'section_name' => ['required', 'string', 'max:255', 'unique:sections,section_name,' . $id],
        ], [
            'section_name.required' => 'لا يمكن ترك حقل اسم القسم فارغا يرجي ادخال الاسم',
        ]);

        // جلب القسم وتحديثه
        $section = Sections::findOrFail($id);
        $section->update($request->all());

        return redirect()->route('sections.index')->with('success', 'تم تعديل القسم بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $section = Sections::findOrFail($id);
        $section->delete();
        return redirect()->route('sections.index')->with('success', 'تم حذف القسم بنجاح');
    }
}
