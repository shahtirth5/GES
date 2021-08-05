<?php

namespace App\Http\Controllers;

use App\Services\EnrollmentService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EnrollmentController extends Controller
{
    protected $enrollmentService;
    public function __construct(EnrollmentService $enrollmentService)
    {
        $this->enrollmentService = $enrollmentService;
    }

    // The function is for ajax datatable
    public function getEnrollmentRequests() {
        $result = $this->enrollmentService->getEnrollmentRequests(UserService::getAuthInstituteId(), ['users.id', 'students.student_id', 'name', 'address', 'city', 'email', 'contact_no', 'courses.course_id', 'course_name']);

        $datatable = DataTables::of($result)
            ->addColumn('enroll', function($enrollment){
                return '<button data-student-id="'.$enrollment->student_id.'" data-course-id="'.$enrollment->course_id.'" class="btn btn-success btn-sm fa fa-check enroll" data-toggle="modal" data-target="#enrollModal"></button>';
            })
            ->addColumn('delete', function($enrollment) {
                return '<button data-student-id="'.$enrollment->student_id.'" data-course-id="'.$enrollment->course_id.'" class="btn btn-danger btn-sm fa fa-times delete" data-toggle="modal" data-target="#deleteModal"></button>';
            })
            ->addColumn('block', function($enrollment) {
                return '<button data-student-id="'.$enrollment->student_id.'" data-course-id="'.$enrollment->course_id.'" class="btn btn-warning btn-sm fa fa-ban block" data-toggle="modal" data-target="#blockModal"></button>';
            })
            ->rawColumns(['enroll', 'delete', 'block'])
            ->make(true);

        return $datatable;
    }

    // The function is when the enroll check button is clicked
    public function enroll(Request $request) {
        $student_id = $request->student_id;
        $course_id = $request->course_id;
        if(!$this->enrollmentService->enroll(UserService::getAuthInstituteId(), $student_id, $course_id)) {
            return redirect()->back()->with(
                [
                    'type' => 'danger',
                    'title' => 'Failed to enroll student',
                    'message' => "There was some issue in adding the enrollment. Please Check Your Allowed Enrollment Count For The Course"
                ]
            );
        }
        return redirect()->back()->with(
            [
                'type' => 'success',
                'title' => 'Successful',
                'message' => "Student Enrolled Successfully"
            ]
        );
    }

    // The function is when the enroll cross button is clicked
    public function changeEnrollmentStatus(Request $request) {
            $student_id = $request->student_id;
            $course_id = $request->course_id;
            $status = $request->status;
            if(! $this->enrollmentService->changeEnrollmentStatus(UserService::getAuthInstituteId(), $student_id, $course_id, $status)) {
                $message = "";
                switch($status) {
                    case -1 : $message = 'Failed To Delete Enrollment';break;
                    case 0 : break; // never gonna happen
                    case 1: $message = 'There was some issue in adding the enrollment. Please Check Your Allowed Enrollment Count For The Course';break;
                    case 2: $message = 'Error in removing enrolled student'; break;
                    case 3: $message = 'There was some issue in blocking the enrollment'; break;
                    default : $message = 'There was some error';break;
                }
                return redirect()->back()->with(
                    [
                        'type' => 'danger',
                        'title' => 'Error',
                        'message' => $message
                    ]
                );
            }

            $message = "";
            switch($status) {
                case -1 : $message = 'Successfully Deleted Student Enrollment';break;
                case 0 : break; // never gonna happen
                case 1: $message = 'Successfully Enrolled Student';break;
                case 2: $message = 'Successfully Removed Enrolled Student'; break;
                case 3: $message = 'Successfully Blocked Student For This Course'; break;
                default : $message = 'Success';break;
            }
            return redirect()->back()->with(
                [
                    'type' => 'success',
                    'title' => 'Successful',
                    'message' => $message
                ]
            );
    }

        //
    public function existingEnrollments() {
        $result = $this->enrollmentService->getExistingEnrollments(UserService::getAuthInstituteId(), ['users.id', 'students.student_id', 'name', 'address', 'city', 'email', 'contact_no', 'courses.course_id', 'course_name']);

        $datatable = DataTables::of($result)
            ->addColumn('delete', function($enrollment) {
                return '<button data-student-id="'.$enrollment->student_id.'" data-course-id="'.$enrollment->course_id.'" class="btn btn-danger btn-sm fa fa-times delete" data-toggle="modal" data-target="#deleteModal"></button>';
            })
            ->rawColumns(['delete'])
            ->make(true);

        return $datatable;
    }

    //
    public function blockedEnrollments() {
        $result = $this->enrollmentService->getBlockedEnrollments(UserService::getAuthInstituteId(), ['users.id', 'students.student_id', 'name', 'address', 'city', 'email', 'contact_no', 'courses.course_id', 'course_name']);

        $datatable = DataTables::of($result)
            ->addColumn('unblock', function($enrollment) {
                return '<button data-student-id="'.$enrollment->student_id.'" data-course-id="'.$enrollment->course_id.'" class="btn btn-info btn-sm ni ni-lock-circle-open unblock" data-toggle="modal" data-target="#deleteModal"></button>';
            })
            ->rawColumns(['unblock'])
            ->make(true);

        return $datatable;
    }
}
