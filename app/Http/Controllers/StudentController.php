<?php

namespace App\Http\Controllers;

use App\Institute;
use App\Services\EnrollmentService;
use App\Services\StudentService;
use App\Services\UserService;
use App\Services\TestService;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;
use Carbon\Carbon;

class StudentController extends Controller
{
    protected $studentService;
    protected $enrollmentService;
    protected $testService;
    public function __construct(StudentService $studentService, EnrollmentService $enrollmentService, TestService $testService)
    {
        $this->studentService = $studentService;
        $this->enrollmentService = $enrollmentService;
        $this->testService = $testService;
    }


    public function dashboard(Request $request) {
        if(!$this->studentService->isAccountCompleted()) {
            $account_info = $this->studentService->getUserStudentAndEnrollmentInfo();
            return view('students.account-completion', compact('account_info'));
        }
        // Checking enrollment by Institute Name
        $student_id = UserService::getAuthStudentId();
        $institute_name = str_replace("_", " ", $request->institute_name);
        $user = User::where('name', '=', $institute_name)->first(["id"]);
        if($user != null) {
            $institute_user_id = $user->id;
            $institute = Institute::where('institute_user_id', '=', $institute_user_id)->first(["institute_id"]);
            if($institute != null) {
                $institute_id = $institute->institute_id;
                if(!$this->enrollmentService->checkEnrollment($student_id, $institute_id)) {
                    return abort(404);
                }
            } else {
                return abort(404);
            }
        } else {
            return abort(404);
        }
        //-----------------------------------------

        return view('students.dashboard')->with(["institute_name" => $request->institute_name]);
    }

    public function requestEnrollment(Request $request) {
        $student_id = UserService::getAuthStudentId();
        $institute_id = $request->input('institute_id');
        $course_id = $request->input('course_id');
        try {
            $result = $this->enrollmentService->makeEnrollmentRequest($institute_id, $student_id, $course_id);
            if($result == true) {
                return redirect()->back()->with(
                        [
                            'type' => 'success',
                            'title' => 'Successful',
                            'message' => 'Your Enrollment Request Has Been Sent !'
                        ]
                );
            } else {
                return redirect()->back()->with(
                        [
                            'type' => 'warning',
                            'title' => 'Error',
                            'message' => 'This Enrollment Has Been Blocked ! Try for some other courses or institutes OR Contact the institute'
                        ]
                );
            }
        } catch (Exception $e) {
            return redirect()->back()->with(
                [
                    'type' => 'danger',
                    'title' => 'Error',
                    'message' => 'Error in Adding Enrollment Request ! Please check your internet connection or try again after sometime'
                ]
            );
        }
    }

    public function test() {
        dd($this->enrollmentService->makeEnrollmentRequest(1,1,1));
    }

    // Dhruvit
    public function getSubmittedTests()
    {
        $student_id = DB::table('students')->where('student_user_id' , Auth::id())->get()->first()->student_id;
        $tests = DB::table('test_sessions')
            ->where('test_sessions.student_id' , $student_id)
            ->rightJoin('tests' , 'test_sessions.test_id' , '=' , 'tests.test_id')
            ->rightJoin('test_results' , 'tests.test_id' , '=' , 'test_results.test_id')
            ->get(['tests.test_id' , 'test_name' , 'test_description' , 'test_session_id' , 'max_marks' , 'marks_scored']);
        $datatable = DataTables::of($tests)
            ->addColumn('view', function($test){
                return '<button data-test-session-id = "'.$test->test_session_id.'" data-test-id="'.$test->test_id.'" class="btn btn-success btn-sm fa fa-eye view" data-toggle="modal" "></button>';
            })
            ->rawColumns(['view'])
            ->make(true);
        return $datatable;
    }

    public function getSubmittedTestsPage(Request $request) {
        // Checking enrollment by Institute Name
        $student_id = UserService::getAuthStudentId();
        $institute_name = str_replace("_", " ", $request->institute_name);
        $user = User::where('name', '=', $institute_name)->first(["id"]);
        if($user != null) {
            $institute_user_id = $user->id;
            $institute = Institute::where('institute_user_id', '=', $institute_user_id)->first(["institute_id"]);
            if($institute != null) {
                $institute_id = $institute->institute_id;
                if(!$this->enrollmentService->checkEnrollment($student_id, $institute_id)) {
                    return abort(404);
                }
            } else {
                return abort(404);
            }
        } else {
            return abort(404);
        }
        //-----------------------------------------

        return view('students.tests.submitted-tests')->with(["institute_name" => $request->institute_name]);
    }

    public function getSubmittedQuestions(Request $request)
    {
        $questions = $this->testService->getQuestionWithStatus($request->test_id , $request->test_session_id);
        return view('students.tests.submitted-questions' )->with([
            'questions' => $questions,
        ]);
    }

    public function getPendingTestsPage(Request $request)
    {
        // Checking enrollment by Institute Name
        $student_id = UserService::getAuthStudentId();
        $institute_name = str_replace("_", " ", $request->institute_name);
        $user = User::where('name', '=', $institute_name)->first(["id"]);
        if($user != null) {
            $institute_user_id = $user->id;
            $institute = Institute::where('institute_user_id', '=', $institute_user_id)->first(["institute_id"]);
            if($institute != null) {
                $institute_id = $institute->institute_id;
                if(!$this->enrollmentService->checkEnrollment($student_id, $institute_id)) {
                    return abort(404);
                }
            } else {
                return abort(404);
            }
        } else {
            return abort(404);
        }
        //-----------------------------------------
        return view('students.tests.pending-tests')->with(["institute_name" => $request->institute_name]);
    }

    public function getPendingTestsQuery(Request $request) {
        $student_id = UserService::getAuthStudentId();
        $institute_id = DB::table('enrollments')
                                    ->where('student_id', '=', $student_id)
                                    ->where('enrollment_status', '=', '1')
                                    ->first(['institute_id'])
                                    ->institute_id;
        // Courses
        $courses = DB::table('enrollments')
                    ->where('student_id', '=', $student_id)
                    ->where('institute_id', '=', $institute_id)
                    ->where('enrollment_status', '=', '1')
                    ->get(['course_id']);
        $course_ids = [];
        for($i = 0; $i < sizeof($courses); $i++) {
            $course_ids[$i] = $courses[$i]->course_id;
        }
        //-----------

        $result = DB::table('tests')
                    ->whereIn('tests.course_id', $course_ids)
                    ->where('tests.institute_id', '=', $institute_id)
                    ->where('tests.test_start_time', '>=', Carbon::now())
                    ->get();

        foreach($result as $i) {
            $i->test_duration /=60;
        }
        $datatable = DataTables::of($result)
            ->addColumn('test_link', function($test){
                return '<button data-test-id="'.$test->test_id.'" class="btn btn-success btn-sm fa fa-eye view" data-toggle="modal"></button>';
            })
            ->rawColumns(['test_link'])
            ->make(true);

        return $datatable;
    }


    public function getOngoingTestsPage(Request $request)
    {
        // Checking enrollment by Institute Name
        $student_id = UserService::getAuthStudentId();
        $institute_name = str_replace("_", " ", $request->institute_name);
        $user = User::where('name', '=', $institute_name)->first(["id"]);
        if($user != null) {
            $institute_user_id = $user->id;
            $institute = Institute::where('institute_user_id', '=', $institute_user_id)->first(["institute_id"]);
            if($institute != null) {
                $institute_id = $institute->institute_id;
                if(!$this->enrollmentService->checkEnrollment($student_id, $institute_id)) {
                    return abort(404);
                }
            } else {
                return abort(404);
            }
        } else {
            return abort(404);
        }
        //-----------------------------------------

        return view('students.tests.ongoing-tests')->with(["institute_name" => $request->institute_name]);
    }

    public function getOngoingTestsQuery(Request $request) {
        $student_id = UserService::getAuthStudentId();
        $institute_id = DB::table('enrollments')
                                    ->where('student_id', '=', $student_id)
                                    ->where('enrollment_status', '=', '1')
                                    ->first(['institute_id'])->institute_id;
        // Institute Name
        $institute_user_id = DB::table('institutes')
                                    ->where('institute_id', '=', $institute_id)
                                    ->first(['institute_user_id'])->institute_user_id;
        $institute_name = DB::table('users')
                                ->where('id', '=', $institute_user_id)
                                ->first(['name'])->name;
        $institute_name = preg_replace('/\s+/', '_', $institute_name);



        // Courses
        $courses = DB::table('enrollments')
                    ->where('student_id', '=', $student_id)
                    ->where('institute_id', '=', $institute_id)
                    ->where('enrollment_status', '=', '1')
                    ->get(['course_id']);
        $course_ids = [];
        for($i = 0; $i < sizeof($courses); $i++) {
            $course_ids[$i] = $courses[$i]->course_id;
        }
        //-----------

        $result = DB::table('tests')
                    ->whereIn('tests.course_id', $course_ids)
                    ->where('tests.institute_id', '=', $institute_id)
                    ->where('tests.test_start_time', '<=', Carbon::now())
                    ->where('tests.test_end_time', '>=', Carbon::now())
                    ->get();

        foreach($result as $i) {
            $i->test_duration /=60;
        }
        $datatable = DataTables::of($result)
            ->addColumn('test_link', function($test) use($institute_name){
                return '<a href="/'.$institute_name.'/student/test/'.$test->test_id.'">'.env('APP_URL').'/'.$institute_name.'/student/test/'.$test->test_id.'</a>';
            })
            ->rawColumns(['test_link'])
            ->make(true);

        return $datatable;
    }

}
