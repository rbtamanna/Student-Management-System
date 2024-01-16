<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileEditRequest;
use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }
    public function index()
    {
       return view('backend.pages.dashboard');
    }
    public function getProfileInfo()
    {
        return $this->dashboardService->getProfileInfo();
    }

    public function getProfile()
    {
        $user = $this->dashboardService->getProfile();
        return view('backend.pages.profile', compact('user'));
    }

    public function editProfile()
    {
        $student = $this->dashboardService->getStudentProfile();
        if($student && !is_null($student->deleted_at))
            return redirect()->back()->with('error', 'Invalid student');
        return \view('backend.pages.student.editProfile',compact('student'));
    }

    public function updateProfile(ProfileEditRequest $request)
    {
        try {
            $student = $this->dashboardService->updateProfile($request->validated());
            if(!$student)
                return redirect('user/profile')->with('error', 'Failed to update profile');
            return redirect('/user/profile')->with('Profile', 'Student updated successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
