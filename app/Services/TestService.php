<?php


namespace App\Services;


use App\Test;
use App\TestQuestionPivot;
use App\TestSelectedQuestion;
use App\TestSession;
use App\TestResult;
use DB;

class TestService
{
    public function createTest($test_name, $test_description, $course_id, $test_start_time, $test_end_time, $test_duration, $institute_id, $positive_marking, $neutral_marking, $negative_marking) {
        $test = Test::create([
            'test_name' => $test_name,
            'test_description' => $test_description,
            'course_id' => $course_id,
            'test_start_time' => $test_start_time,
            'test_end_time' => $test_end_time,
            'test_duration' => $test_duration,
            'institute_id' => $institute_id,
            'positive_marking' => $positive_marking,
            'neutral_marking' => $neutral_marking,
            'negative_marking' => $negative_marking
        ]);

        return $test;
    }

    public function addQuestionToTest($test_id, $question_id) {
        TestQuestionPivot::create([
            'test_id' => $test_id,
            'question_id' => $question_id
        ]);
    }

    public function removeQuestionFromTest($test_id, $question_id) {
        $test_question_pivot = TestQuestionPivot::where('test_id', '=', $test_id)
                                ->where('question_id', '=', $question_id)
                                ->first();
        $test_question_pivot->forceDelete();
    }

    public function getTests($institute_id, $columns) {
        $tests = Test::where('institute_id', '=', $institute_id)->orderBy('updated_at')->get($columns);
        return $tests;
    }

    public function deleteTest($institute_id, $test_id) {
        $test = Test::where('test_id', '=', $test_id)->where('institute_id', '=', $institute_id);
        if(!$test->exists()) {
            return 0;
        }
        $pivot = TestQuestionPivot::where('test_id', '=', $test_id);
        $session = TestSession::where('test_id', '=', $test_id);

        if($session->exists()) {
            return -1;
        }

        $pivot->delete();
        $session->delete();
        $test->delete();

        return 1;
    }

    public function editTest($test_id, $test_name, $test_description, $test_start_time, $test_end_time, $test_duration, $positive_marking, $neutral_marking, $negative_marking) {
        $test = Test::where('test_id', '=', $test_id)->first();
        $test->test_name = $test_name;
        $test->test_description = $test_description;
        $test->test_start_time = $test_start_time;
        $test->test_end_time = $test_end_time;
        $test->test_duration = $test_duration;
        $test->positive_marking = $positive_marking;
        $test->neutral_marking = $neutral_marking;
        $test->negative_marking = $negative_marking;
        $test->save();
    }



    // Student Test Part => (Made By Dhruvit)
    public function insertTestSession($test_id , $student_id)
    {
        $test_session = DB::table('test_sessions')
            ->where('test_id' , $test_id)
            ->where('student_id' , $student_id)
            ->get()->first();
        if($test_session == null)
        {
            $test_duration = DB::table('tests')->where('test_id' , $test_id)->select('test_duration')->get()->first()->test_duration;
            $test_session = TestSession::create([
                'test_id' => $test_id,
                'student_id' => $student_id,
                'session_timer' =>  $test_duration,
                'session_status' => '1',
            ]);
            return 1;
        }
        else{
            $test_session_status = $test_session->session_status;
            if($test_session_status == '1')
            {
                return 1;
            }
            else
            {
                return 0;
            }
        }
    }

    public function getTimeLeft($student_id , $test_id){
        $test_session = DB::table('test_sessions')->where('student_id' ,$student_id)->where('test_id' , $test_id)->get()->first();
        return $test_session->session_timer;
    }

    public function insertTestSelectedOptions($student_id , $test_id)
    {
        $test_session = DB::table('test_sessions')->where('student_id' ,$student_id)->where('test_id' , $test_id)->get()->first();
        $test_session_id = $test_session->test_session_id;
        $test_selected_question = DB::table('test_selected_questions')->where('test_session_id' ,$test_session_id)->get()->first();
        if($test_selected_question == null){
            $questions = $this->getQuestions($test_id);
            foreach ($questions as $question)
            {
                $x = TestSelectedQuestion::create([
                    'test_session_id' => $test_session_id,
                    'question_id' => $question['question_id'],
                    'status' => '0',
                ]);
            }
        }
        return $test_session_id;
    }

    public function getQuestionWithStatus($test_id , $test_session_id)
    {
        $questions = $this->getQuestions($test_id);
        $questionsWithStatus = $questions;
        $i = 0;
        foreach ($questions as $question)
        {
            $status = DB::table('test_selected_questions')
                ->where('question_id' , $question['question_id'])
                ->where('test_session_id' , $test_session_id)
                ->get(['selected_option_id' , 'status'])
                ->first();
            $questionsWithStatus[$i]['selected_option_id'] = $status->selected_option_id;
            $questionsWithStatus[$i]['status'] = $status->status;
            $i++;
        }
        return $questionsWithStatus;
    }

    public function getQuestions($test_id)
    {
            $questions = TestQuestionPivot::with( 'questions')->where('test_id' , $test_id)->get()->all();
            $result = [];
            $i = 0;
            foreach ($questions as $question)
            {
                $j = 0 ;
                $subject_id = $question->questions[0]->subject_id;
                $result[$i]['subject_name'] = DB::table('subjects')->where('subject_id' , $subject_id)->get()->first()->subject_name;
                $option_array = [];
                $result[$i]['question_id'] = $question->questions[0]->question_id;
                $result[$i]['question_text'] = $question->questions[0]->question_text;
                $result[$i]['question_rating'] = $question->questions[0]->question_rating;
                $result[$i]['question_answer_explanation'] = $question->questions[0]->question_answer_explanation;
                $options = $question->questions[0]->with('options')->where('question_id' , $result[$i]['question_id'])->get()[0]->options;
                foreach ($options as $option)
                {

                    $option_array[$j]['option_id'] = $option->option_id;
                    $option_array[$j]['option_text'] = $option->option_text;
                    $option_array[$j]['is_correct'] = $option->is_correct;
                    $j++;
                }
                $result[$i]['options'] = $option_array;
                $i++;
            }
            return $result;
    }

    public function updateTestSession($student_id , $test_id)
    {
        DB::table('test_sessions')->where('student_id' , $student_id)->where('test_id' , $test_id)->decrement('session_timer' , 10);
    }

    public function updateTestSelectedQuestion($test_session_id , $question_id , $optionSelected , $status)
    {
        if($optionSelected == -1) {
            DB::table('test_selected_questions')
                ->where('test_session_id', $test_session_id)
                ->where('question_id', $question_id)
                ->update([
                    'status' => $status
                ]);
        } else if($optionSelected == 'null') {
            DB::table('test_selected_questions')
                ->where('test_session_id', $test_session_id)
                ->where('question_id', $question_id)
                ->update([
                    'selected_option_id' => null,
                    'status' => $status
                ]);
        }else {
            DB::table('test_selected_questions')
                ->where('test_session_id', $test_session_id)
                ->where('question_id', $question_id)
                ->update([
                    'selected_option_id' => $optionSelected,
                    'status' => $status
                ]);
        }
    }


    public function calculate_result($test_id, $student_id, $test_session_id)
    {
        $questions = $this->getQuestionWithStatus($test_id, $test_session_id);
        $marking_scheme = DB::table('tests')->where('test_id', $test_id)->get(['positive_marking', 'negative_marking', 'neutral_marking'])->first();
        $positive = $marking_scheme->positive_marking;
        $neutral = $marking_scheme->neutral_marking;
        $negative = $marking_scheme->negative_marking;
        $correct = 0;
        $notSelected = 0;
        foreach ($questions as $question) {
            foreach ($question['options'] as $option) {
                if ($question['selected_option_id'] == null) {
                    $notSelected++;
                    break;
                }
                if ($question['selected_option_id'] == $option['option_id'] and $option['is_correct'] == 1) {
                    $correct++;
                    break;
                }
            }
        }
        $wrong = sizeof($questions) - $correct - $notSelected;
        $marks_scored = ($correct * $positive) + ($wrong * $negative) + ($notSelected * $neutral);
        $max_marks = $positive * sizeof($questions);
        $test_result = DB::table('test_results')->where('test_id', $test_id)->where('student_id', $student_id)->get()->first();

        if ($test_result == null) {
            TestResult::create([
                'marks_scored' => $marks_scored,
                'max_marks' => $max_marks,
                'test_id' => $test_id,
                'student_id' => $student_id,
            ]);
        }

    }
}
