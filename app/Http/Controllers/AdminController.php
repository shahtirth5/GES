<?php

namespace App\Http\Controllers;

use App\Services\AdminServices;
use App\Services\ChapterService;
use App\Services\CourseService;
use App\Services\SubjectService;
use App\CourseStudentCount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Matrix\Exception;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    protected $adminService, $subjectService, $courseService, $chapterService;
    public function __construct(AdminServices $adminService, SubjectService $subjectService, CourseService $courseService, ChapterService $chapterService)
    {
        $this->adminService = $adminService;
        $this->subjectService = $subjectService;
        $this->courseService = $courseService;
        $this->chapterService = $chapterService;
    }

    public function addCoursePage()
    {
        $subjects = $this->subjectService->getAllSubjects(['subject_id', 'subject_name']);
        $institutes = DB::table('users')
            ->rightJoin('institutes', 'institutes.institute_user_id', '=', 'users.id')
            ->get(['name', 'institute_id']);

        return view('admins.courses.add-courses', compact('subjects', 'institutes'));
    }

    public function addCourse(Request $request)
    {
        $validate = $request->validate([
            'course_name' => 'required',
            'course_description' => 'required',
            'institute_id' => 'required',
            'subject_id' => 'required',
        ]);
        extract($request->input());
        
        try {
            $this->courseService->addCourse($course_name, $course_description, $subject_id, $institute_id);
        } catch (Exception $e) {
            return redirect()->back()->with(
                [
                    'type' => 'danger',
                    'title' => 'Failed to add course',
                    'message' => 'There was some error in adding course, please try again later',
                ]
            );
        }

        return redirect()->back()->with(
            [
                'type' => 'success',
                'title' => 'Success',
                'message' => 'Course Added Successfully',
            ]
        );

    }

    public function getCourses()
    {
        $result = $this->courseService->getCourses(['course_id', 'course_name', 'course_description']);
        $datatable = DataTables::of($result)
            ->addColumn('editSubjects_Institutes', function ($courses) {
                return '<button data-course-id="' . $courses->course_id . ' " class="btn btn-success btn-sm fa fa-edit editSubjects_Institutes" data-toggle="modal" data-target="#editSubjects_Institutes_Modal"></button>';
            })
            ->addColumn('delete', function ($courses) {
                return '<button data-course-id="' . $courses->course_id . ' " class="btn btn-danger btn-sm fa fa-trash deleteCourse" data-toggle="modal" data-target="#deleteCourse_Modal"></button>';
            })
            ->rawColumns(['editSubjects_Institutes', 'delete'])
            ->make(true);

        return $datatable;
    }

    public function deleteCourse(Request $request)
    {
        $complete_delete = true;
        try {
            $this->courseService->deleteCourse($request->course_id, $complete_delete);
        } catch (Exception $e) {
            return redirect()->back()->with(
                [
                    'type' => 'danger',
                    'title' => 'Failed to delete course',
                    'message' => 'There was some error in deleting course, please try again later',
                ]
            );
        }

        return redirect()->back()->with(
            [
                'type' => 'success',
                'title' => 'Success',
                'message' => 'Course Deleted Successfully',
            ]
        );
    }

    // TODO: Could be done using Model Functions and add institute service (if needed)
    public function editCourseInfo(Request $request)
    {
        $course_id = $request->course_id;
        $courses = DB::table('courses')->where('course_id', $course_id)->get();
        $subjects_selected = DB::table('courses')
            ->rightJoin('course_subject_pivot', 'courses.course_id', '=', 'course_subject_pivot.course_id')
            ->rightJoin('subjects', 'course_subject_pivot.subject_id', '=', 'subjects.subject_id')
            ->where('course_subject_pivot.course_id', '=', $course_id)
            ->get(['subjects.subject_id', 'subject_name', 'course_name', 'course_description']);

        $institutes_selected = DB::table('course_student_counts')
            ->rightJoin('institutes', 'course_student_counts.institute_id', '=', 'institutes.institute_id')
            ->rightJoin('users', 'institutes.institute_user_id', '=', 'users.id')
            ->where('course_student_counts.course_id', '=', $course_id)
            ->get(['institutes.institute_id', 'name']);

        $subjects = DB::table('subjects')
            ->get(['subject_id', 'subject_name']);

        $subjects = $this->subjectService->getAllSubjects(['subject_id', 'subject_name']);

        $institutes = DB::table('users')
            ->rightJoin('institutes', 'institutes.institute_user_id', '=', 'users.id')
            ->get(['name', 'institute_id']);

        return json_encode(array($subjects_selected, $institutes_selected, $subjects, $institutes, $courses));
    }

    public function editCourse(Request $request)
    {
        $validate = $request->validate([
            'course_name' => 'required',
            'course_description' => 'required',
            'institute_id' => 'required',
            'subject_id' => 'required',
        ]);
        $complete_delete = false;
        extract($request->input());

        //Code to Delete and then add the dependencies
        try {
            $this->courseService->deleteCourse($request->course_id, $complete_delete);
            $this->courseService->editCourse($request->course_id, $course_name, $course_description, $subject_id, $institute_id);
        } catch (Exception $e) {
            return redirect()->back()->with(
                [
                    'type' => 'danger',
                    'title' => 'Failed to Edit course',
                    'message' => 'There was some error in editing course, please try again later',
                ]
            );
        }
        return redirect()->back()->with(
            [
                'type' => 'success',
                'title' => 'Success',
                'message' => 'Course Edited Successfully',
            ]
        );
    }

    public function addSubject(Request $request)
    {
        $validate = $request->validate([
            'subject_name' => 'required',
            'subject_description' => 'required',
        ]);
        extract($request->input());
        try {
            $this->subjectService->addSubject($subject_name, $subject_description);

        } catch (Exception $exception) {
            return redirect()->back()->with(
                [
                    'type' => 'danger',
                    'title' => 'Failed to Add Subject',
                    'message' => 'There was some error in adding subject, please try again later',
                ]
            );
        }
        return redirect()->back()->with(
            [
                'type' => 'success',
                'title' => 'Success',
                'message' => 'Subject Added Successfully',
            ]
        );
    }

    public function getSubjects()
    {
        $result = $this->subjectService->getAllSubjects(['subject_id', 'subject_name', 'subject_description']);
        $datatable = DataTables::of($result)
            ->addColumn('editSubject', function ($subjects) {
                return '<button data-subject-id="' . $subjects->subject_id . ' " class="btn btn-success btn-sm fa fa-edit editSubject" data-toggle="modal" data-target="#editSubjects_Modal"></button>';
            })
            ->addColumn('delete', function ($subjects) {
                return '<button data-subject-id="' . $subjects->subject_id . ' " class="btn btn-danger btn-sm fa fa-trash deleteSubject" data-toggle="modal" data-target="#deleteSubject_Modal"></button>';
            })
            ->rawColumns(['editSubject', 'delete'])
            ->make(true);

        return $datatable;
    }

    public function deleteSubject(Request $request)
    {
        try {
            $this->subjectService->deleteSubject($request->subject_id);
        } catch (Exception $exception) {
            return redirect()->back()->with(
                [
                    'type' => 'danger',
                    'title' => 'Failed to delete subject',
                    'message' => 'There was some error in deleting subject, please try again later',
                ]
            );
        }
        return redirect()->back()->with(
            [
                'type' => 'success',
                'title' => 'Success',
                'message' => 'Subject Deleted Successfully',
            ]
        );

    }

    public function editSubjectInfo(Request $request)
    {
        // $result = DB::table('subjects')->where('subject_id' , $request->subject_id)->get(['subject_id' , 'subject_name' , 'subject_description'])->first();
        $result = $this->subjectService->getSubjectById($request->subject_id, ['subject_id', 'subject_name', 'subject_description']);
        return json_encode($result);
    }

    public function editSubject(Request $request)
    {
        $subject_name = $request->subject_name;
        $subject_description = $request->subject_description;
        $validate = $request->validate([
            'subject_name' => 'required',
            'subject_description' => 'required',
        ]);

        try {
            // DB::table('subjects')->where('subject_id' , $request->subject_id)->update(['subject_name' => $subject_name , 'subject_description' => $subject_description]);
            $this->subjectService->editSubject($request->subject_id, ['subject_name' => $subject_name, 'subject_description' => $subject_description]);
        } catch (Exception $exception) {
            return redirect()->back()->with(
                [
                    'type' => 'danger',
                    'title' => 'Failed to edit subject',
                    'message' => 'There was some error in editing subject, please try again later',
                ]
            );
        }
        return redirect()->back()->with(
            [
                'type' => 'success',
                'title' => 'Success',
                'message' => 'Subject Edited Successfully',
            ]
        );

    }

    public function addChapter(Request $request)
    {
        $validate = $request->validate([
            'chapter_name' => 'required',
            'chapter_description' => 'required',
            'subject' => 'required',
        ]);

        extract($request->input());
        try {
            $this->chapterService->addChapter($chapter_name, $chapter_description, $subject);
        } catch (Exception $exception) {
            return redirect()->back()->with(
                [
                    'type' => 'danger',
                    'title' => 'Failed to add chapter',
                    'message' => 'There was some error in adding chapter, please try again later',
                ]
            );
        }
        return redirect()->back()->with(
            [
                'type' => 'success',
                'title' => 'Success',
                'message' => 'Chapter Added Successfully',
            ]
        );
    }

    public function getChapters()
    {
        $result = $this->chapterService->getAllChapters(['chapter_id', 'chapter_name', 'chapter_description']);
        $datatable = DataTables::of($result)
            ->addColumn('editChapter', function ($chapters) {
                return '<button data-chapter-id="' . $chapters->chapter_id . ' " class="btn btn-success btn-sm fa fa-edit editChapter" data-toggle="modal" data-target="#editChapters_Modal"></button>';
            })
            ->addColumn('delete', function ($chapters) {
                return '<button data-chapter-id="' . $chapters->chapter_id . ' " class="btn btn-danger btn-sm fa fa-trash deleteChapter" data-toggle="modal" data-target="#deleteChapter_Modal"></button>';
            })
            ->rawColumns(['editChapter', 'delete'])
            ->make(true);

        return $datatable;
    }

    public function deleteChapter(Request $request)
    {
        try {
            //   DB::table('chapters')->where('chapter_id', $request->chapter_id)->delete();
            $this->chapterService->deleteChapter($request->chapter_id);
        } catch (Exception $exception) {
            return redirect()->back()->with(
                [
                    'type' => 'danger',
                    'title' => 'Failed to delete chapter',
                    'message' => 'There was some error in deleting chapter, please try again later',
                ]
            );
        }
        return redirect()->back()->with(
            [
                'type' => 'success',
                'title' => 'Success',
                'message' => 'Chapter Deleted Successfully',
            ]
        );
    }

    public function getChapterInfo(Request $request)
    {
        $request = DB::table('chapters')->where('chapter_id', $request->chapter_id)->get()->first();
        $subjects = DB::table('subjects')->get(['subject_id', 'subject_name']);
        return json_encode([$request, $subjects]);
    }

    public function editChapter(Request $request)
    {
        $validate = $request->validate([
            'chapter_name' => 'required',
            'chapter_description' => 'required',
            'subject' => 'required',
        ]);
        extract($request->input());
        try {
            // DB::table('chapters')->where('chapter_id' , $request->chapter_id)->update(['chapter_name' => $chapter_name , 'chapter_description' => $chapter_description , 'subject_id'=> $subject]);
            $this->chapterService->editChapter($request->chapter_id, ['chapter_name' => $chapter_name, 'chapter_description' => $chapter_description, 'subject_id' => $subject]);
        } catch (Exception $exception) {
            return redirect()->back()->with(
                [
                    'type' => 'danger',
                    'title' => 'Failed to add chapter',
                    'message' => 'There was some error in adding chapter, please try again later',
                ]
            );
        }
        return redirect()->back()->with(
            [
                'type' => 'success',
                'title' => 'Success',
                'message' => 'Chapter Added Successfully',
            ]
        );
    }

    public function getCourseStudentCounts()
    {
        $result = DB::table('course_student_counts')
            ->leftJoin('courses', 'course_student_counts.course_id', '=', 'courses.course_id')
            ->leftJoin('institutes', 'course_student_counts.institute_id', '=', 'institutes.institute_id')
            ->leftJoin('users', 'institutes.institute_user_id', '=', 'users.id')
            ->get(['users.name', 'institutes.institute_id','courses.course_id', 'courses.course_name', 'course_student_counts.max_students_in_course_allowed']);

        $datatable = DataTables::of($result)
            ->addColumn('count', function($object) {
                return "<input type='number' value='".$object->max_students_in_course_allowed."' class='form-control' id='student-count-". $object->institute_id. $object->course_id. $object->max_students_in_course_allowed."'>";
            })
            ->addColumn('change-count', function ($object) {
                return '<button data-institute-id="' . $object->institute_id . ' " data-course-id="' . $object->course_id . ' " data-previous-count="' . $object->max_students_in_course_allowed . ' "class="btn btn-success btn-sm fa fa-edit change-count"></button>';
            })
            ->rawColumns(['count', 'change-count'])
            ->make(true);

        return $datatable;
    }

    public function changeStudentCount(Request $request) {
        $institute_id = $request->institute_id;
        $course_id = $request->course_id;
        $prev_count = $request->previous_count;
        $new_count = $request->new_count;
        if($prev_count == $new_count) {
            return redirect()->back()->with(
                [
                    'type' => 'warning',
                    'title' => 'Error',
                    'message' => 'Please change the Student Count',
                ]
            );
        }

        if($prev_count > $new_count) {
            // Check enrollments since reducing number of seats
            $enrollment_counts = DB::table('enrollments')
                                    ->where('institute_id', '=', $institute_id)
                                    ->where('course_id', '=', $course_id)
                                    ->where('enrollment_status', '=', '1')
                                    ->count();

            if($enrollment_counts > $new_count) {
                return redirect()->back()->with(
                    [
                        'type' => 'danger',
                        'title' => 'Enrollment Error',
                        'message' => 'The student count cannot be reduced because the no. of enrollments are more. Kindly contact the institute to remove current enrollments. The current enrollment count is : '. $enrollment_counts
                    ]
                );
            } else {
                try {
                    $course_student_count = CourseStudentCount::where('institute_id', '=', $institute_id)
                                                ->where('course_id', '=', $course_id)
                                                ->first();
                    $course_student_count->max_students_in_course_allowed = $new_count;
                    $course_student_count->save();
                } catch(Exception $e) {
                    return redirect()->back()->with(
                        [
                            'type' => 'danger',
                            'title' => 'Error',
                            'message' => 'Cannot Change the Count. Please try again after sometime !'
                        ]
                    );
                }

                return redirect()->back()->with(
                    [
                        'type' => 'success',
                        'title' => 'Successfully Changed The Count',
                        'message' => 'The Student Count has been updated'
                    ]
                );

            }
        } else {
            try {
                $course_student_count = CourseStudentCount::where('institute_id', '=', $institute_id)
                                            ->where('course_id', '=', $course_id)
                                            ->first();
                $course_student_count->max_students_in_course_allowed = $new_count;
                $course_student_count->save();
            } catch(Exception $e) {
                return redirect()->back()->with(
                    [
                        'type' => 'danger',
                        'title' => 'Error',
                        'message' => 'Cannot Change the Count. Please try again after sometime !'
                    ]
                );
            }

            return redirect()->back()->with(
                [
                    'type' => 'success',
                    'title' => 'Successfully Changed The Count',
                    'message' => 'The Student Count has been updated'
                ]
            );

        }
    }

}
