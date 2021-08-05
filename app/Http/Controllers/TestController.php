<?php

namespace App\Http\Controllers;

use App\Course;
use App\Services\TestService;
use App\Services\UserService;
use App\Test;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class TestController extends Controller
{
    protected $testService;
    public function __construct(TestService $testService)
    {
        $this->testService = $testService;
    }

    public function createTestPage()
    {
        $institute_id = UserService::getAuthInstituteId();
        $courses = DB::table('course_student_counts')
            ->rightJoin('institutes', 'institutes.institute_id', '=', 'course_student_counts.institute_id')
            ->leftJoin('courses', 'courses.course_id', '=', 'course_student_counts.course_id')
            ->where('institutes.institute_id', '=', $institute_id)
            ->get('courses.*');
        return view('institutes.tests.create-test-step-one', compact('courses'));
    }

    public function createTestStepOne(Request $request)
    {
        $institute_id = UserService::getAuthInstituteId();
        $validate = $request->validate([
            'test_name' => 'required',
            'test_description' => 'required',
            'course_id' => 'required|numeric',
            'test_start_time' => 'required|date_format:Y-m-d H:i:s',
            'test_end_time' => 'required|date_format:Y-m-d H:i:s',
            'test_duration_min' => 'required|numeric',
            'positive_marking' => 'required|numeric',
            'neutral_marking' => 'required|numeric',
            'negative_marking' => 'required|numeric',
        ]);
        extract($request->input());
        $test_duration = $test_duration_min * 60;
        try {
            $test = $this->testService->createTest($test_name, $test_description, $course_id, $test_start_time, $test_end_time, $test_duration, $institute_id, $positive_marking, $neutral_marking, $negative_marking);
        } catch (Exception $e) {
            return redirect()->back()->with(
                [
                    'type' => 'danger',
                    'title' => 'Failed To Go To Step 2',
                    'message' => 'Please Try Again After Sometime',
                ]
            );
        }

        return redirect('/institute/tests/test/' . $test->test_id . '/add-questions');
    }

    public function createTestQuestionPage(Request $request)
    {
        $test_id = $request->test_id;
        $test = Test::where('test_id', '=', $test_id)->first();
        $institute_id = UserService::getAuthInstituteId();
        if($test->institute_id != $institute_id) {
            return redirect()->back();
        }
        $course = $test->course()->first();
        $subjects = $course->subjects()->get(['course_subject_pivot.subject_id', 'subject_name']);
        return view('institutes.tests.create-test-step-two')->with(compact('test', 'subjects'));
    }

    public function getTests(Request $request)
    {
        $institute_id = UserService::getAuthInstituteId();
        $result = $this->testService->getTests($institute_id, ['test_id', 'test_name', 'test_description']);
        $datatable = DataTables::of($result)
            ->addColumn('edit', function ($test) {
                return '<a href="/institute/tests/edit-test/' . $test->test_id . '" class="btn btn-sm btn-info">Edit</a>';
            })
            ->addColumn('delete', function ($test) {
                return '<button data-test-id="' . $test->test_id . '" class="btn btn-danger btn-sm fa fa-times delete" data-toggle="modal" data-target="#deleteModal"></button>';
            })
            ->addColumn('notify', function ($test) {
                return '<button data-test-id="' . $test->test_id . '" class="btn btn-primary btn-sm fa fa-times notify" data-toggle="modal" data-target="#notifyModal"></button>';
            })
            ->rawColumns(['edit', 'delete', 'notify'])
            ->make(true);
        return $datatable;
    }

    public function deleteTest(Request $request)
    {
        $institute_id = UserService::getAuthInstituteId();
        $test_id = $request->test_id;
        $result = $this->testService->deleteTest($institute_id, $test_id);
        switch ($result) {
            case -1:
                return redirect()->back()->with(
                    [
                        'type' => 'warning',
                        'title' => 'The test might have already been deleted',
                        'message' => '',
                    ]
                );

            case 0:
                return redirect()->back()->with(
                    [
                        'type' => 'danger',
                        'title' => 'Test Won\'t be deleted',
                        'message' => 'There is some test data found. Can\'t delete tests',
                    ]
                );

            case 1;
                return redirect()->back()->with(
                    [
                        'type' => 'success',
                        'title' => 'Deleted Successfully',
                        'message' => 'The Test Is Deleted Successfully',
                    ]
                );
        }

    }

    public function addQuestionToTest(Request $request)
    {
        try {
            $test_id = $request->test_id;
            $question_id = $request->question_id;
            $this->testService->addQuestionToTest($test_id, $question_id);
        } catch (Exception $e) {
            return 'fail';
        }
        return 'ok';
    }

    public function removeQuestionFromTest(Request $request)
    {
        try {
            $test_id = $request->test_id;
            $question_id = $request->question_id;
            $this->testService->removeQuestionFromTest($test_id, $question_id);
        } catch (Exception $e) {
            return 'fail';
        }
        return 'ok';
    }

    public function editTestPage(Request $request)
    {
        $test_id = $request->test_id;
        $test = Test::where('test_id', '=', $test_id)->first();
        $institute_id = $test->institute_id;
        $selected_course = $test->course()->first();
        $test_start_time = Carbon::parse($test->test_start_time);
        $test_end_time = Carbon::parse($test->test_end_time);
        $currentTime = Carbon::now();
        $disabled = false;
        if ($currentTime > $test_start_time and $currentTime < $test_end_time) {
            $disabled = true;
        }
        return view('institutes.tests.edit-test')->with(compact(['test', 'selected_course', 'disabled']));
    }

    public function editTest(Request $request)
    {
        $institute_id = UserService::getAuthInstituteId();
        $validate = $request->validate([
            'test_id' => 'required',
            'test_name' => 'required',
            'test_description' => 'required',
            'test_start_time' => 'required|date_format:Y-m-d H:i:s',
            'test_end_time' => 'required|date_format:Y-m-d H:i:s',
            'test_duration_min' => 'required|numeric',
            'positive_marking' => 'required|numeric',
            'neutral_marking' => 'required|numeric',
            'negative_marking' => 'required|numeric',
        ]);

        extract($request->input());
        $test_duration = $test_duration_min * 60;
        try {
            $test = $this->testService->editTest($test_id, $test_name, $test_description, $test_start_time, $test_end_time, $test_duration, $positive_marking, $neutral_marking, $negative_marking);
        } catch (Exception $e) {
            return redirect()->back()->with(
                [
                    'type' => 'danger',
                    'title' => 'Failed To Go To Step 2',
                    'message' => 'Please Try Again After Sometime',
                ]
            );
        }

        return redirect('/institute/tests/test/' . $test_id . '/add-questions')->with(
            [
                'type' => 'success',
                'title' => 'Successfully Edited Test',
                'message' => "If Test Details were Same then it is As It Is and If Changed it is Saved as Changed.",
            ]
        );
    }

    // Student section
    public function validateTest(Request $request)
    {
        $test_id = $request->test_id;
        // $student = DB::table('students')->where('student_user_id' , $id)->get();
        // $student_id = $student[0]->student_id;
        $course = Test::where('test_id', '=', $test_id)->first()->course()->first();
        $institute = Test::where('test_id', '=', $test_id)->first()->institute()->first();
        $student_id = UserService::getAuthStudentId();
        $enrollmentStatus = DB::table('enrollments')
            ->where('student_id', '=', $student_id)
            ->where('institute_id', '=', $institute->institute_id)
            ->where('course_id', '=', $course->course_id)
            ->first(['enrollment_status']);
        if ($enrollmentStatus == null) {
            $isEnrolled = 0;
        } else {
            $isEnrolled = $enrollmentStatus->enrollment_status;
        }

        if ($isEnrolled) {

            $test = DB::table('tests')->where('test_id', $request->test_id)->get()->first();
            if ($test != null) {
                $test_start_time = Carbon::parse($test->test_start_time);
                $test_end_time = Carbon::parse($test->test_end_time);
                $currentTime = Carbon::now();
                if ($currentTime > $test_start_time and $currentTime < $test_end_time) {
                    $flag = $this->testService->insertTestSession($test_id, $student_id);
                    if ($flag) {
                        $timeLeft = $this->testService->getTimeLeft($student_id, $test_id);
                        $test_session_id = $this->testService->insertTestSelectedOptions($student_id, $test_id);
                        $questions = $this->testService->getQuestionWithStatus($test_id, $test_session_id);
                        return view('students.test-page', ['message' => 'success', 'questions' => $questions])->with(
                            [
                                'test_id' => $test_id,
                                'student_id' => $student_id,
                                'timeLeft' => $timeLeft,
                                'test_session_id' => $test_session_id,
                            ]);
                    } else {
                        return view('students.test-page', ['message' => 'Fail4'])->with(
                            [
                                'test_id' => $test_id,
                                'student_id' => $student_id,
                                'timeLeft' => '',
                                'test_session_id' => '',
                            ]);
                    }
                } else {
                    return view('students.test-page', ['message' => 'Fail1'])->with(
                        [
                            'test_id' => $test_id,
                            'student_id' => $student_id,
                            'timeLeft' => '',
                            'test_session_id' => '',
                        ]);
                }
            } else {
                return view('students.test-page', ['message' => 'Fail2'])->with(
                    [
                        'test_id' => $test_id,
                        'student_id' => $student_id,
                        'timeLeft' => '',
                        'test_session_id' => '',
                    ]);
            }
        } else {
            return view('students.test-page', ['message' => 'Fail3'])->with(
                [
                    'test_id' => $test_id,
                    'student_id' => $student_id,
                    'timeLeft' => '',
                    'test_session_id' => '',
                ]);
        }
    }

    public function updateTestSession(Request $request)
    {
        $this->testService->updateTestSession($request->student_id, $request->test_id);
    }

    public function updateTestSelectionQuestion(Request $request)
    {
        extract($request->input());
        $this->testService->updateTestSelectedQuestion($test_session_id, $question_id, $optionSelected, $status);
    }

    public function endTest(Request $request)
    {
        DB::table('test_sessions')
            ->where('test_session_id' , $request->test_session_id)
            ->update(['session_status' =>'-1']);
        $test_session  = DB::table('test_sessions')
            ->where('test_session_id' , $request->test_session_id)
            ->get(['student_id' , 'test_id'])
            ->first();
        $test_id = $test_session->test_id;
        $student_id = $test_session->student_id;
        $this->testService->calculate_result($test_id , $student_id , $request->test_session_id);
        return response('Test Ended Successfully', 200);
    }


    // Results
    public function resultsPage(Request $request) {
        $institute_id = UserService::getAuthInstituteId();
        $tests = Test::where('institute_id', '=', $institute_id)
                    ->where('test_end_time', '<=', Carbon::now())
                    ->orderByDesc('created_at')
                    ->get();
        return view('institutes.tests.results', compact('tests'));
    }

    public function resultsQuery(Request $request) {
        $institute_id = UserService::getAuthInstituteId();
        $test_id = $request->test_id;
        $results = DB::table('test_results')
                    ->leftJoin('students', 'students.student_id', '=', 'test_results.student_id')
                    ->rightJoin('users', 'users.id', '=', 'students.student_user_id')
                    ->rightJoin('tests', 'tests.test_id', '=', 'test_results.test_id')
                    ->where('test_results.test_id', '=', $test_id)
                    ->where('tests.institute_id', '=', $institute_id)
                    ->get(['students.student_id', 'test_results.test_id', 'users.name', 'test_results.marks_scored', 'test_results.max_marks']);

        $datatable = DataTables::of($results)
            ->addColumn('view', function ($result) {
                return '<a href="/institute/tests/getSubmittedQuestions/' . $result->student_id . '/'.$result->test_id.'" class="btn btn-sm btn-info"><span><i class="fa fa-eye"></i></span></a>';
            })
            ->rawColumns(['view'])
            ->make(true);
        return $datatable;
    }

    public function getSubmittedQuestions(Request $request) {
        $student_id = $request->student_id;
        $test_id = $request->test_id;

        $test_session_id = DB::table('test_sessions')
                            ->where('student_id', '=', $student_id)
                            ->where('test_id', '=', $test_id)
                            ->first(['test_session_id'])
                            ->test_session_id;

        $questions = $this->testService->getQuestionWithStatus($test_id , $test_session_id);
        return view('institutes.tests.submitted-questions' )->with([
            'questions' => $questions,
        ]);

    }
}
