<?php

namespace App\Http\Controllers;

use App\Services\EnrollmentService;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    protected $enrollmentService;
    protected $studentService;
    public function __construct(EnrollmentService $enrollmentService, StudentService $studentService)
    {
        $this->enrollmentService = $enrollmentService;
        $this->studentService = $studentService;
    }

    public function roleRedirect(Request $request) {
        $user = Auth::user();
        $role = $user->roles()->pluck('name')[0];
        switch ($role) {
            case 'Institute':
                return redirect('/institute/dashboard');

            case 'Student':
                $user = $this->studentService->getEnrolledInstituteUserDetails();
                if($user != null) {
                    $institute_user_name = $user->name;
                    $institute_user_name = str_replace(" ", "_", $institute_user_name);
                    return redirect("$institute_user_name/student/dashboard");
                } else {
                    return redirect("/student/dashboard");
                }

            case 'Admin':
                return redirect('/admin/dashboard');

            default:
                Auth::logout();
                return redirect('/login');
        }
    }
}
