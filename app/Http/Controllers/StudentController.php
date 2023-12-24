<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentResult;
use App\Models\Subject;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use File;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data['students']=Student::withSum('result', 'achieve_number')->paginate(10);
        return view('student.show', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['subjects']=Subject::get();
        return view('student.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ],[
            'name.required' => 'Student Name is required'
        ]);

        $save_url = 'img/student/blank.jpg';

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image',
            ], [
                'image.image' => 'please provide a valid image that with .jpg , .png, .gif, .jpeg extension ',
            ]);


            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(100, 100)->save('img/student/' . $name_gen);
            $save_url = 'img/student/' . $name_gen;
        }

        $student = new Student();
        $student->name = $request->name;
        $student->image = $save_url;
        $student->save();

        if ($student){

            foreach ($request->addmore as $result){

                $sResult= new StudentResult();
                $sResult->student_id=$student->id;
                $sResult->subject_id = $result['subject_id'];
                $sResult->achieve_number = $result['achieve_number'];
                $sResult->save();
            }

        }

        session()->flash('success', 'Student and result submited successfully');
        return redirect()->route('students.index');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit($studentId)
    {
        $data['subjects']=Subject::get();
        $data['student']=Student::with(['result'])->find($studentId);
        return view('student.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required',
        ],[
            'name.required' => 'Student Name is required'
        ]);

        $student= Student::find($id);
        $student->name = $request->name;
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image',
            ], [
                'image.image' => 'please provide a valid image that with .jpg , .png, .gif, .jpeg extension ',
            ]);

            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(100, 100)->save('img/student/' . $name_gen);
            $save_url = 'img/student/' . $name_gen;
            $file=$request->file('image');
            if ($student->image!='img/student/blank.jpg' &&  File::exists(public_path($student->image))) {
                File::delete(public_path($student->image));
            }
            $student->image=$save_url;
        }
        $student->save();

        $resultId=[];

        foreach ($request->addmore as $item){
            if (isset($item['result_id'])) {
                $sResult=StudentResult::find($item['result_id']);
            }
            else { 
                $sResult= new StudentResult();
                 
            }
            $sResult->student_id=$student->id;
            $sResult->subject_id = $item['subject_id'];
            $sResult->achieve_number = $item['achieve_number'];
            $sResult->save();

            array_push($resultId, $sResult->id);

        }


        StudentResult::where('student_id',$student->id)->whereNotIn('id',$resultId)->delete();

        session()->flash('success', 'Student and result updated successfully');
        return redirect()->route('students.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $student=  Student::find($id);
        if ($student->image!='img/student/blank.jpg' &&  File::exists(public_path($student->image))) {
                File::delete(public_path($student->image));
            }
            $student->delete();
        StudentResult::where('student_id', $id)->delete();
    }
}
