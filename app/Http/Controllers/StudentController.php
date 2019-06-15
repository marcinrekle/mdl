<?php

namespace App\Http\Controllers;

use App\Student;
use App\User;
use App\Field;
use Illuminate\Http\Request;
use Auth;

class StudentController extends Controller
{
    /**
     * Display a student dash.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $student = Auth::user()->load(['payments','hours.drive.user']);
        $student['hoursSorted'] = $student->hours->sortByDesc('drive.date')->values()->all();
        $costNames = Field::where("name","like",'%cost%')->orderBy('name')->get();
        //$student['hours2'] = $student->hours->sortByDesc('drive.date')->values()->all();
        return response()->json(['student' => $student, 'hours' => $student->hours,'costNames' => $costNames],200);
        //return view('student.index', ['students' => $students]);
    }
}
