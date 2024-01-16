<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentAddRequest;
use App\Http\Requests\StudentEditRequest;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class StudentController extends Controller
{
    private $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    public function index()
    {
        return view('backend.pages.student.index');
    }

    public function fetchData()
    {
        return $this->studentService->fetchData();
    }

    public function create()
    {
        return \view('backend.pages.student.create');
    }

    public function store(StudentAddRequest $request)
    {
        try {
            $student = $this->studentService->create($request->validated());
            if(!$student)
                return redirect('student')->with('error', 'Failed to add student');
            return redirect('/student')->with('success', 'Student added successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function edit($id)
    {
        $student = $this->studentService->getStudentData($id);
        if($student && !is_null($student->deleted_at))
            return redirect()->back()->with('error', 'Invalid student');
        return \view('backend.pages.student.edit',compact('student'));
    }

    public function update(StudentEditRequest $request)
    {
        try {
            $student = $this->studentService->update($request->validated());
            if(!$student)
                return redirect('student')->with('error', 'Failed to update student');
            return redirect('/student')->with('success', 'Student updated successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $this->studentService->delete($id);
            return redirect()->back()->with('success', 'Student deleted');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }




}
