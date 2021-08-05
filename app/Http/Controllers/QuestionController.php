<?php

namespace App\Http\Controllers;

use App\Services\QuestionService;
use App\Services\UserService;
use App\Services\SubjectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class QuestionController extends Controller
{
    protected $questionService, $subjectService;
    public function __construct(QuestionService $questionService, SubjectService $subjectService)
    {
        $this->questionService = $questionService;
        $this->subjectService = $subjectService;
    }

    public function addQuestionPage() {
        $institute_id = UserService::getAuthInstituteId();
        $subjects = $this->subjectService->getSubjects($institute_id);
        return view('institutes.questions.add-question', compact('subjects'));
    }

    public function addQuestion(Request $request) {
        $validate = $request->validate([
            'subject_id' => 'required',
            'chapter_id' => 'required',
            'question_text' => 'required',
            'option_1' => 'required',
            'option_2' => 'required',
            'option_3' => 'required',
            'option_4' => 'required',
            'correct_option' => 'required',
            'question_rating' => 'required'
        ]);

        $institute_id = UserService::getAuthInstituteId();
        extract($request->input());
        try {
            $this->questionService->addQuestion($institute_id, $subject_id, $chapter_id, $question_text, $question_answer_explanation, $option_1, $option_2, $option_3, $option_4, $correct_option, $question_rating);
        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->with(
                [
                    'type' => 'danger',
                    'title' => 'Failed to add question',
                    'message' => 'There was some error in adding question, please try again later'
                ]
            );
        }

        return redirect()->back()->with(
            [
                'type' => 'success',
                'title' => 'Success',
                'message' => 'Question Added Successfully'
            ]
        );
    }

    public function existingQuestionsPage() {
        $institute_id = UserService::getAuthInstituteId();
        $subjects = $this->subjectService->getSubjects($institute_id);
        return view('institutes.questions.existing-questions', compact('subjects'));
    }


    // Maybe this is unused. WARNING: Check before you remove
    public function getQuestions() {
        $institute_id = UserService::getAuthInstituteId();
        $result = $this->questionService->getQuestions($institute_id);
        $datatable = DataTables::of($result)
            ->addColumn('edit', function($question) {
                return '<button data-question-id="'.$question->question_id.'" class="btn btn-info btn-sm fa fa-edit edit" data-toggle="modal" data-target="#editModal"></button>';
            })
            ->addColumn('delete', function($question) {
                return '<button data-question-id="'.$question->question_id.'" class="btn btn-danger btn-sm fa fa-times delete" data-toggle="modal" data-target="#deleteModal"></button>';
            })
            ->rawColumns(['question_text', 'option_1', 'option_2', 'option_3', 'option_4', 'question_explanation', 'edit', 'delete'])
            ->make(true);

        return $datatable;
    }

    public function editQuestion(Request $request) {
        $validate = $request->validate([
            'subject_id' => 'required',
            'chapter_id' => 'required',
            'question_text' => 'required',
            'option_1' => 'required',
            'option_2' => 'required',
            'option_3' => 'required',
            'option_4' => 'required',
            'correct_option' => 'required',
            'question_rating' => 'required'
        ]);

        extract($request->input());
        $question_edited = $this->questionService->editQuestion($question_id, $subject_id, $chapter_id, $question_text, $question_answer_explanation, $option_1, $option_2, $option_3, $option_4, $correct_option, $question_rating);
        if($question_edited) {
            return redirect()->back()->with(
                [
                    'type' => 'success',
                    'title' => 'Successfully Changed',
                    'message' => 'The Question is successfully changed'
                ]
            );
        } else {
            return redirect()->back()->with(
                [
                    'type' => 'danger',
                    'title' => 'Failed to edit question',
                    'message' => 'There was some error in editing the question, please try again later'
                ]
            );
        }
    }

    public function deleteQuestion(Request $request) {
        if($this->questionService->deleteQuestion($request->question_id)){
            return redirect()->back()->with(
                [
                    'type' => 'success',
                    'title' => 'Successfully Deleted Question',
                    'message' => 'There question has been successfully deleted'
                ]
            );
        } else {
            return redirect()->back()->with(
                [
                    'type' => 'danger',
                    'title' => 'Failed to delete question',
                    'message' => 'There was some error in deleting question, please try again later'
                ]
            );
        }
    }

    public function getQuestionsBySubjectIdNotInTest(Request $request) {
        $institute_id = UserService::getAuthInstituteId();
        $test_id = $request->test_id;
        $subject_id = $request->subject_id;
        $result = $this->questionService->getQuestionsBySubjectIdNotInTest($institute_id, $subject_id, $test_id);
        $GES_INSTITUTE_ID = env('GES_INSTITUTE_ID');

        $datatable = DataTables::of($result)
                    ->addColumn('byGES', function($question) use ($GES_INSTITUTE_ID) {
                        return $question->institute_id==$GES_INSTITUTE_ID?"<span class='badge badge-info'>GES</span>":"";
                    })
                    ->addColumn('add', function($question){
                        return '<button type="button" data-question-id="'.$question->question_id.'" class="btn btn-info btn-sm fa fa-check add"></button>';
                    })
                    ->rawColumns(['byGES', 'question_text','option_1','option_2','option_3','option_4','question_explanation','add',])
                    ->make(true);
        return $datatable;
    }

    public function getQuestionsBySubjectIdInTest(Request $request) {
        $institute_id = UserService::getAuthInstituteId();
        $test_id = $request->test_id;
        $subject_id = $request->subject_id;
        $result = $this->questionService->getQuestionsBySubjectIdInTest($institute_id, $subject_id, $test_id);
        $GES_INSTITUTE_ID = env('GES_INSTITUTE_ID');

        $datatable = DataTables::of($result)
                    ->addColumn('byGES', function($question) use ($GES_INSTITUTE_ID) {
                        return $question->institute_id==$GES_INSTITUTE_ID?"<span class='badge badge-info'>GES</span>":"";
                    })
                    ->addColumn('remove', function($question){
                        return '<button type="button" data-question-id="'.$question->question_id.'" class="btn btn-danger btn-sm fa fa-window-close remove"></button>';
                    })
                    ->rawColumns(['byGES', 'question_text','option_1','option_2','option_3','option_4','question_explanation','remove'])
                    ->make(true);
        return $datatable;
    }
}
