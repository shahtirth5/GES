<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

use App\Course;
use App\Enrollment;
use App\Institute;
use App\Student;
use App\Subject;
use App\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmailVerificationMail;

Auth::routes();
Route::redirect('/register', '/login');
// Route::redirect('/password/reset', '/login');
Route::view('/institute-register', 'auth.institute-register');
Route::post('/institute-register-query', function (Request $request, Response $response) {
    $request->validate([
        'name' => 'required',
        'email' => 'required',
        'contact_no' => 'required|numeric',
        'address' => 'required',
        'city' => 'required',
        'password' => 'required|confirmed',
    ]);

    try {
        extract($request->input());
        $user = User::create([
            "name" => $name,
            "email" => $email,
            "contact_no" => $contact_no,
            "address" => $address,
            "city" => $city,
            "password" => Hash::make($password),
        ]);
        $user->assignRole('Institute');
        Institute::create([
            'institute_user_id' => $user->id,
            'institute_code' => substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 4)
        ]);
    } catch (Exception $e) {
    }
    return redirect('/login');
});

Route::view('/student-register', 'auth.student-register');
Route::post('/student-register-query', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required',
        'email' => 'required',
        'contact_no' => 'required|numeric',
        'address' => 'required',
        'city' => 'required',
        'password' => 'required|confirmed',
    ]);
    DB::beginTransaction();
    try {
        extract($request->input());
        $user = User::create([
            "name" => $name,
            "email" => $email,
            "contact_no" => $contact_no,
            "address" => $address,
            "city" => $city,
            "password" => Hash::make($password),
            "email_verification_key" => str_replace('/', '', Hash::make(Carbon\Carbon::now()->toDateTimeString() . $name))
        ]);
        $user->assignRole('Student');
        Student::create([
            'student_user_id' => $user->id,
            'student_account_completion' => 0,
        ]);

        // $to_name = $user->name;
        // $to_email = $user->email;
        // $data = array("name" => $user->name, "email_verification_key" => $user->email_verification_key, "app_url" => env('APP_URL'));
        // Mail::to($to_email)->send(new SendEmailVerificationMail($data));

        // $user->email_verified_at = \Carbon\Carbon::now();
        // $user->save();
    } catch (Exception $e) {
        DB::rollback();
        dd($e);
    }
    DB::commit();
    return redirect('/login')->with(
        [
            'type' => 'warning',
            'title' => 'Error',
            'message' => 'This Enrollment Has Been Blocked ! Try for some other courses or institutes OR Contact the institute'
        ]
    );
});
Route::get('/verify-email/{email_verification_key}', function (Request $request) {
    $key = $request->email_verification_key;
    $user = User::where('email_verification_key', '=', $key)->first();
    $user->email_verified_at = \Carbon\Carbon::now();
    $user->save();
    return redirect('/login');
});


Route::middleware(['auth'])->group(function () {

    /** GENERAL ROUTES*/

    Route::redirect('/', '/role-redirect');
    Route::redirect('/dashboard', '/role-redirect');
    Route::get('/role-redirect', 'RoleController@roleRedirect');

    Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

    /* --------------------------------------------------------------------
    |             Institute                                              |
    -------------------------------------------------------------------- */
    Route::group(['middleware' => ['role:Institute', 'instituteHasCourse']], function () {
        // The route below routes to institute dashboard
        Route::get('/institute/dashboard', function () {
            $institute_code = Institute::where('institute_id', UserService::getAuthInstituteId())->first('institute_code')->institute_code;
            return view('institutes.dashboard', compact('institute_code'));
        });

        // The route below routes to institute dashboard
        Route::get('/institute/enrollments/pending-student-enrollments', function () {
            return view('institutes.enrollments.pending-student-enrollments');
        });

        // The route below is for student pending enrollments datatable AJAX request
        Route::get('/institute/enrollments/get-enrollment-requests', 'EnrollmentController@getEnrollmentRequests');

        // The route below is for adding enrollments from student_id
        Route::get('/institute/enrollments/enroll/{student_id}/{course_id}', 'EnrollmentController@enroll');

        // The route below is for rejecting/deleting enrollment requests provided a status
        // Status Code -1 => Rejected
        // Status Code 0 => NA
        // Status Code 1 => Accepted
        // Status Code 2 => Enrolled and then removed
        // Status Code 3 => Blocked
        Route::get('/institute/enrollments/change-enrollment-status/{student_id}/{course_id}/{status}', 'EnrollmentController@changeEnrollmentStatus');

        // The route below is for showing existing enrolled students
        Route::get('/institute/enrollments/enrolled-students', function () {
            return view('institutes.enrollments.existing-enrollments');
        });

        // The route below is for existing enrollments datatable AJAX request
        Route::get('/institute/enrollments/get-existing-enrollments', 'EnrollmentController@existingEnrollments');

        // The route below is blocked enrollments
        Route::get('institute/enrollments/blocked-students', function () {
            return view('institutes.enrollments.blocked-student-enrollments');
        });

        // The route below is for existing enrollments datatable AJAX request
        Route::get('/institute/enrollments/get-blocked-enrollments', 'EnrollmentController@blockedEnrollments');

        // The route below is for adding questions page
        Route::get('/institute/questions/add-questions', 'QuestionController@addQuestionPage');

        // The route below to add question to the database
        Route::post('/institute/questions/add-question-query', 'QuestionController@addQuestion');

        //The route below is for existing questions page
        Route::get('/institute/questions/existing-questions', 'QuestionController@existingQuestionsPage');

        // The route below is for existing questions ajax request
        Route::get('/institute/questions/get-questions', 'QuestionController@getQuestions');

        Route::get('/institute/questions/get-questions-not-in-test/{test_id}/{subject_id}', 'QuestionController@getQuestionsBySubjectIdNotInTest');
        Route::get('/institute/questions/get-questions-in-test/{test_id}/{subject_id}', 'QuestionController@getQuestionsBySubjectIdInTest');

        Route::get('/test/{test_id}/{subject_id}', 'QuestionController@getQuestionsBySubjectIdNotInTest');

        // The route below is to edit an existing question
        Route::post('institute/questions/edit-question-query', 'QuestionController@editQuestion');

        // The route below is to delete an existing question
        Route::delete('institute/questions/delete-question/{question_id}', 'QuestionController@deleteQuestion');

        // The route below is for create test page
        Route::get('/institute/tests/create-test', 'TestController@createTestPage');

        // The route below is to insert basic Test data to database (Test Creation Step 1)
        Route::post('/institute/tests/create-test-query', 'TestController@createTestStepOne');

        // The route below is for the Test Creation Step 2 page
        Route::get('/institute/tests/test/{test_id}/add-questions', 'TestController@createTestQuestionPage');

        // The route below is for the ajax request to add questions to test
        Route::get('/institute/tests/addQuestionToTest/{test_id}/{question_id}', 'TestController@addQuestionToTest');
        // The route below is for the ajax request to remove questions from test
        Route::get('/institute/tests/removeQuestionFromTest/{test_id}/{question_id}', 'TestController@removeQuestionFromTest');

        // The route below is for existing test page
        Route::get('/institute/tests/existing-tests', function () {
            return view('institutes.tests.existing-tests');
        });

        // The route below gives a list of tests
        Route::get('/institute/tests/get-tests', 'TestController@getTests');

        // The Route below is for edit test page
        Route::get('/institute/tests/edit-test/{test_id}', 'TestController@editTestPage');

        // The Route Below Edits a test
        Route::post('/institute/tests/edit-test-query', 'TestController@editTest');

        // The Route below deletes a test
        Route::get('/institute/tests/delete-test/{test_id}', 'TestController@deleteTest');

        // The Route below results of a test
        Route::get('/institute/tests/results', 'TestController@resultsPage');

        //
        Route::get('/institute/tests/results-query/{test_id}', 'TestController@resultsQuery');

        //
        Route::get('/institute/tests/getSubmittedQuestions/{student_id}/{test_id}', 'TestController@getSubmittedQuestions');

        // The route below is for profile page
        Route::get('/institute/profile', function () {
            $institute = Auth::user();
            return view('institutes.profile', compact('institute'));
        });

        // THe route below is for edit test stage 1 page
        // Route::get('/institute/tests/edit-test/{test_id}', 'TestController@editTest');

        // institute/questions/add-questions
        //        institute/questions/existing-questions
        //    Route::get('/test', 'EnrollmentController@getEnrollmentRequests');
    });

    /* --------------------------------------------------------------------
    |            Student                                               |
    -------------------------------------------------------------------- */
    Route::group(['middleware' => ['role:Student']], function () {
        Route::get('{institute_name}/student/dashboard', 'StudentController@dashboard');
        Route::get('/student/dashboard', "StudentController@dashboard");
        Route::post('/student/request-enrollment', 'StudentController@requestEnrollment');

        // The route below is to validate the test link and Student ID
        Route::get('/{institute_id}/student/test/{test_id}', 'TestController@validateTest');

        // The route below is to Update the test_session Table
        Route::get('/student/test/{student_id}/{test_id}', 'TestController@updateTestSession');

        // The route below is to Update the test_selected_question Table
        Route::post('/student/test/updateTestSelectionQuestion', 'TestController@updateTestSelectionQuestion');

        // The route below is to end the test
        Route::post('/student/test/endTest', 'TestController@endTest');

        // The route below is for submitted tests page load
        Route::get('/{institute_name}/student/tests/submitted', 'StudentController@getSubmittedTestsPage');

        // The route below is for pending tests page
        Route::get('/{institute_name}/student/tests/pending', 'StudentController@getPendingTestsPage');
        //  The route below is for pending test query
        Route::get('/student/tests/pending-tests-query', 'StudentController@getPendingTestsQuery');

        // The route below is for ongoing tests
        Route::get('/{institute_name}/student/tests/ongoing', 'StudentController@getOngoingTestsPage');
        Route::get('/student/tests/ongoing-tests-query', 'StudentController@getOngoingTestsQuery');

        // The route below is to get all the completed tests
        Route::get('/submitted-test/get-completed-tests', 'StudentController@getSubmittedTests');

        // The route below is to get all the questions
        Route::get('/student/get-completed-tests/{test_id}/{test_session_id}', 'StudentController@getSubmittedQuestions');

        Route::get('/student/enrollment-request/', function (Request $request) {
            extract($request->input());
            foreach ($course_id as $course) {
                Enrollment::create([
                    "institute_id" => $institute_id,
                    "student_id" => \App\Services\UserService::getAuthStudentId(),
                    "course_id" => $course,
                    "enrollment_status" => "0",
                ]);
                return redirect()->back();
            }
        });

        Route::get('/student/profile', function () {
            $student = Auth::user();
            $courses = DB::table('enrollments')
                ->leftJoin('institutes', 'enrollments.institute_id', '=', 'institutes.institute_id')
                ->rightJoin('users', 'institutes.institute_user_id', '=', 'users.id')
                ->where('enrollments.student_id', '=', \App\Services\UserService::getAuthStudentId())
                ->where('enrollments.enrollment_status', '=', '1')
                ->rightJoin('courses', 'enrollments.course_id', '=', 'courses.course_id')
                ->get(['institutes.institute_id', 'users.name', 'courses.course_id', 'courses.course_name']);

            $institute_id = $courses[0]->institute_id;
            $course_ids = [];
            for ($i = 0; $i < sizeof($courses); $i++) {
                $course_ids[$i] = $courses[$i]->course_id;
            }

            $enroll_requests = DB::table('enrollments')
                ->where('institute_id', '=', $institute_id)
                ->where('student_id', '=', \App\Services\UserService::getAuthStudentId())
                ->whereIn('enrollment_status', ['0', '-1', '3'])
                ->get(['enrollments.course_id']);

            $enr_reqs = [];
            for ($i = 0; $i < sizeof($enroll_requests); $i++) {
                $enr_reqs[$i] = $enroll_requests[$i]->course_id;
            }

            $unenrolledCourses = DB::table('courses')
                ->rightJoin('course_student_counts', 'course_student_counts.course_id', '=', 'courses.course_id')
                ->whereNotIn('courses.course_id', $course_ids)
                ->whereNotIn('courses.course_id', $enr_reqs)
                ->where('course_student_counts.institute_id', '=', $institute_id)
                ->get(['courses.course_id', 'courses.course_name']);

            return view('students.profile', compact(['student', 'courses', 'unenrolledCourses']));
        });

        // Route::get('/test', 'StudentController@getSubmittedTests');

        //        Route::get('/test', 'StudentController@test');
    });

    /* --------------------------------------------------------------------
    |            Institute OR Student                                  |
    -------------------------------------------------------------------- */
    Route::group(['middleware' => ['role:Institute|Student']], function () {

        Route::get('/contact-admin', function () {
            return view('admins.contact-admin');
        });

        Route::get('get-institute/{institute_code}', function (Request $request) {
            $institute_code = $request->institute_code;
            $id = Institute::where('institute_code', $institute_code)->first();
            try {
                $institute_details = User::where('id', $id->institute_user_id)->first();
            } catch (Exception $e) {
                return -1;
            }
            $response = [
                "id" => $id->institute_id,
                "name" => $institute_details->name,
                "contact_no" => $institute_details->contact_no,
                "address" => $institute_details->address,
                "city" => $institute_details->city
            ];
            return $response;
        });

        Route::get('get-courses/{institute_id}', function (Request $request) {
            $institute_id = $request->institute_id;
            $courses = DB::table('courses')
                ->leftJoin('course_student_counts', 'course_student_counts.course_id', '=', 'courses.course_id')
                ->where('course_student_counts.institute_id', '=', $institute_id)
                ->get(['courses.course_id', 'courses.course_name', 'courses.course_description']);
            return json_encode($courses);
        });

        Route::get('get-chapters/{subject_id}', function (Request $request) {
            $subject_id = $request->subject_id;
            $chapters = Subject::where('subject_id', '=', $subject_id)->first()->chapters()->get();
            return json_encode($chapters);
        });

        Route::get('get-subjects/{course_id}', function (Request $request) {
            $course_id = $request->course_id;
            $subjects = Course::find($course_id)->subjects()->get(['subjects.subject_id', 'subjects.subject_name']);
            return json_encode($subjects);
        });
    });

    /* --------------------------------------------------------------------
|                    ADMIN ROUTES                                  |
-------------------------------------------------------------------- */
    Route::group(['middleware' => ['role:Admin']], function () {
        // The route below routes to admin dashboard
        Route::get('/admin/dashboard', function () {
            return view('admins.dashboard');
        });

        // The route below routes to initial add Course page
        Route::get('/admin/admin-courses/add-courses', 'AdminController@addCoursePage');

        // The route below routes to insert Courses
        Route::post('admin/admin-courses/add-course-query', 'AdminController@addCourse');

        // The route below routes to manage Courses
        Route::get('admin/admin-courses/manage-courses', function () {
            return view('admins.courses.manage-courses');
        });

        // The route below routes to get Courses
        Route::get('/admin/admin-courses/get-courses', 'AdminController@getCourses');

        // The route below routes to Delete Courses
        Route::get('admin/admin-courses/delete-course/{course_id}', 'AdminController@deleteCourse');

        // The route below routes to Get the info for edit course
        Route::get('admin/admin-courses/edit-courses/{course_id}', 'AdminController@editCourseInfo');

        // The route below routes to  edit course
        Route::post('admin/admin-courses/edit-course-query/{course_id}', 'AdminController@editCourse');

        // The route below routes to  initial add subject page
        Route::get('admin/admin-subjects/add-subjects', function () {
            return view('admins.subjects.add-subjects');
        });

        // The route below routes to insert subject
        Route::post('admin/admin-subjects/add-subjects-query', 'AdminController@addSubject');

        // The route below routes to  manage subject page
        Route::get('admin/admin-subjects/manage-subjects', function () {
            return view('admins.subjects.manage-subjects');
        });

        // The route below routes to  get subject list
        Route::get('/admin/admin-subjects/get-subjects', 'AdminController@getSubjects');

        // The route below routes to  delete subject
        Route::get('/admin/admin-subjects/delete-subject/{subject_id}', 'AdminController@deleteSubject');

        // The route below routes to  get subject info
        Route::get('/admin/admin-subjects/edit-subjects/{subject_id}', 'AdminController@editSubjectInfo');

        // The route below routes to  Edit Subject
        Route::post('/admin/admin-subjects/edit-subject-query/{subject_id}', 'AdminController@editSubject');

        // The route below routes to  initial Chapter page
        Route::get('admin/admin-chapters/add-chapters', function () {
            $subjects = DB::table('subjects')->get(['subject_id', 'subject_name']);
            return view('admins.chapters.add-chapters', ['subjects' => $subjects]);
        });

        // The route below routes to  add Chapter page
        Route::post('admin/admin-chapters/add-chapters-query', 'AdminController@addChapter');

        // The route below routes to initial manage Chapter page
        Route::get('admin/admin-chapters/manage-chapters', function () {
            return view('admins.chapters.manage-chapters');
        });

        // The route below routes to get Chapter list
        Route::get('/admin/admin-chapters/get-chapters', 'AdminController@getChapters');

        // The route below routes to delete Chapter
        Route::get('admin/admin-chapters/delete-chapter/{chapter_id}', 'AdminController@deleteChapter');

        // The route below routes to get Chapter Info
        Route::get('admin/admin-chapters/edit-chapter/{chapter_id}', 'AdminController@getChapterInfo');

        // The route below routes to Edir Chapter
        Route::post('admin/admin-chapters/edit-chapter-query/{chapter_id}', 'AdminController@editChapter');

        Route::get('admin/admin-institutes/institute-course-student-count', function () {
            return view('admins.institutes.institute_student_count');
        });
        Route::get('/admin/get-admin-course-student-counts/', 'AdminController@getCourseStudentCounts');
        Route::get('/admin/change-student-count/{institute_id}/{course_id}/{previous_count}/{new_count}', 'AdminController@changeStudentCount');

        Route::get('/test', 'AdminController@getCourseStudentCounts');
    });
});

//    /** ADMIN ROUTES*/
//    Route::group(['middleware'=> ['role:Admin']], function () {
//
//        /*Enquiry*/
//        Route::get('/enquiry/get-enquiry', 'EnquiryController@getEnquiry');
//        Route::resource('/enquiry', 'EnquiryController');
//
//        Route::get('/publications/get-publications', 'PublicationsController@getPublications');
//        Route::resource('/pub', 'PublicationsController');
//
//    });
// });