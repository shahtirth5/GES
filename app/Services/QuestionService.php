<?php


namespace App\Services;


use App\Option;
use App\Question;
use App\Subject;
use App\Chapter;
use DB;
use Exception;

class QuestionService
{
    public function addQuestion($institute_id, $subject_id, $chapter_id, $question_text, $question_answer_explanation, $option_1, $option_2, $option_3, $option_4, $correct_option, $question_rating)
    {
        $question = Question::create([
            'question_text' => $question_text,
            'question_answer_explanation' => $question_answer_explanation,
            'subject_id' => $subject_id,
            'chapter_id' => $chapter_id,
            'question_rating' => $question_rating,
            'institute_id' => $institute_id
        ]);

        $question_id = $question->question_id;

        $option__1 = Option::create([
            'option_text' => $option_1,
            'is_correct' => 0,
            'question_id' => $question_id
        ]);

        $option__2 = Option::create([
            'option_text' => $option_2,
            'is_correct' => 0,
            'question_id' => $question_id
        ]);

        $option__3 = Option::create([
            'option_text' => $option_3,
            'is_correct' => 0,
            'question_id' => $question_id
        ]);

        $option__4 = Option::create([
            'option_text' => $option_4,
            'is_correct' => 0,
            'question_id' => $question_id
        ]);

        switch ($correct_option) {
            case '1':
                $option__1->is_correct = 1;
                $option__1->save();
                break;

            case '2':
                $option__2->is_correct = 1;
                $option__2->save();
                break;

            case '3':
                $option__3->is_correct = 1;
                $option__3->save();
                break;

            case '4':
                $option__4->is_correct = 1;
                $option__4->save();
                break;
        }
    }

    public function getQuestions($institute_id)
    {
        $result = [];
        $questions  = Question::where('institute_id', '=', $institute_id)->get();
        for ($i = 0; $i < sizeof($questions); $i++) {
            $question = $questions[$i];
            $temp = (object) [];
            $temp->question_id = $question->question_id;
            $temp->subject = Subject::where('subject_id', '=', $question->subject_id)->first('subject_name')->subject_name;
            $temp->chapter = Chapter::where('chapter_id', '=', $question->chapter_id)->first('chapter_name')->chapter_name;
            $temp->question_text = $this->removeContentEditable($question->question_text);
            $opt = $question->options()->get();
            $temp->option_1 = $this->removeContentEditable($opt[0]->option_text);
            $temp->option_2 = $this->removeContentEditable($opt[1]->option_text);
            $temp->option_3 = $this->removeContentEditable($opt[2]->option_text);
            $temp->option_4 = $this->removeContentEditable($opt[3]->option_text);
            for ($j = 0; $j < 4; $j++) {
                if ($opt[$j]->is_correct == 1) {
                    $temp->correct_option = $j + 1;
                    break;
                }
            }
            $temp->question_explanation = $this->removeContentEditable($question->question_answer_explanation);
            switch ($question->question_rating) {
                case '1':
                    $temp->question_rating = 'Easy';
                    break;

                case '2':
                    $temp->question_rating = 'Medium';
                    break;

                case '3':
                    $temp->question_rating = 'Hard';
                    break;

                case '4':
                    $temp->question_rating = 'Very Hard';
                    break;
            }
            array_push($result, $temp);
        }
        return $result;
    }

    public function getQuestionsBySubjectId($institute_id, $subject_id)
    {
        $result = [];

        $questions  = Question::where('institute_id', '=', $institute_id)->where('subject_id', '=', $subject_id)->get();

        for ($i = 0; $i < sizeof($questions); $i++) {
            $question = $questions[$i];
            $temp = (object) [];
            $temp->question_id = $question->question_id;
            $temp->chapter = Chapter::where('chapter_id', '=', $question->chapter_id)->first('chapter_name')->chapter_name;
            $temp->question_text = $question->question_text;
            $opt = $question->options()->get();
            $temp->option_1 = $opt[0]->option_text;
            $temp->option_2 = $opt[1]->option_text;
            $temp->option_3 = $opt[2]->option_text;
            $temp->option_4 = $opt[3]->option_text;
            for ($j = 0; $j < 4; $j++) {
                if ($opt[$j]->is_correct == 1) {
                    $temp->correct_option = $j + 1;
                    break;
                }
            }
            $temp->question_explanation = $question->question_answer_explanation;
            switch ($question->question_rating) {
                case '1':
                    $temp->question_rating = 'Easy';
                    break;

                case '2':
                    $temp->question_rating = 'Medium';
                    break;

                case '3':
                    $temp->question_rating = 'Hard';
                    break;

                case '4':
                    $temp->question_rating = 'Very Hard';
                    break;
            }
            array_push($result, $temp);
        }
        return $result;
    }

    public function editQuestion($question_id, $subject_id, $chapter_id, $question_text, $question_answer_explanation, $option_1, $option_2, $option_3, $option_4, $correct_option, $question_rating)
    {
        try {
            $question = Question::where('question_id', '=', $question_id)->first();
            $options = Option::where('question_id', '=', $question->question_id)->take(4)->get();

            // Updating Question
            $question->subject_id = $subject_id;
            $question->chapter_id = $chapter_id;
            $question->question_text = $question_text;
            $question->question_answer_explanation = $question_answer_explanation;
            $question->question_rating = $question_rating;
            $question->save();

            // Updating Options
            $options[0]->option_text = $option_1;
            $options[0]->is_correct = 0;
            $options[1]->option_text = $option_2;
            $options[1]->is_correct = 0;
            $options[2]->option_text = $option_3;
            $options[2]->is_correct = 0;
            $options[3]->option_text = $option_4;
            $options[3]->is_correct = 0;
            $correct_option = $correct_option - 1;
            $options[$correct_option]->is_correct = 1;
            $options[0]->save();
            $options[1]->save();
            $options[2]->save();
            $options[3]->save();
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    public function deleteQuestion($question_id)
    {
        try {
            $question = Question::where('question_id', '=', $question_id)->first();
            $options = Option::where('question_id', '=', $question->question_id)->get();
            // Delete options first and then questions because there's a foreign key constraint
            $options[0]->delete();
            $options[1]->delete();
            $options[2]->delete();
            $options[3]->delete();

            $question->delete();
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    public function getQuestionsBySubjectIdNotInTest($institute_id, $subject_id, $test_id)
    {
        $result = [];
        $GES_INSTITUTE_ID = env('GES_INSTITUTE_ID');

        $questions = DB::select('SELECT * FROM questions WHERE (institute_id = ? OR institute_id = ?) AND subject_id = ?  AND question_id NOT IN (SELECT question_id FROM test_question_pivot WHERE test_question_pivot.test_id = ?)', [$institute_id, $GES_INSTITUTE_ID, $subject_id, $test_id]);

        // foreach($questions as $question) {
        for ($i = 0; $i < sizeof($questions); $i++) {
            $question = $questions[$i];
            $temp = (object) [];
            $temp->institute_id = $question->institute_id;
            $temp->question_id = $question->question_id;
            $temp->chapter = Chapter::where('chapter_id', '=', $question->chapter_id)->first('chapter_name')->chapter_name;
            $temp->question_text = $question->question_text;
            $opt = DB::select('SELECT * FROM options WHERE question_id = ?', [$question->question_id]);
            $temp->option_1 = $opt[0]->option_text;
            $temp->option_2 = $opt[1]->option_text;
            $temp->option_3 = $opt[2]->option_text;
            $temp->option_4 = $opt[3]->option_text;
            for ($j = 0; $j < 4; $j++) {
                if ($opt[$j]->is_correct == 1) {
                    $temp->correct_option = $j + 1;
                    break;
                }
            }
            $temp->question_explanation = $question->question_answer_explanation;
            switch ($question->question_rating) {
                case '1':
                    $temp->question_rating = 'Easy';
                    break;

                case '2':
                    $temp->question_rating = 'Medium';
                    break;

                case '3':
                    $temp->question_rating = 'Hard';
                    break;

                case '4':
                    $temp->question_rating = 'Very Hard';
                    break;
            }
            array_push($result, $temp);
        }
        return $result;
    }

    public function getQuestionsBySubjectIdInTest($institute_id, $subject_id, $test_id)
    {
        $result = [];
        $GES_INSTITUTE_ID = env('GES_INSTITUTE_ID');
        $questions = DB::select('select * from questions where (institute_id = ? OR institute_id = ?) and subject_id = ? and question_id in (select question_id from test_question_pivot where (test_question_pivot.test_id = ?))', [$institute_id, $GES_INSTITUTE_ID, $subject_id, $test_id]);
        if (sizeof($questions) == 0) {
            return $result;
        }
        // foreach($questions as $question) {
        for ($i = 0; $i < sizeof($questions); $i++) {
            $question = $questions[$i];
            $temp = (object) [];
            $temp->institute_id = $question->institute_id;
            $temp->question_id = $question->question_id;
            $temp->chapter = Chapter::where('chapter_id', '=', $question->chapter_id)->first('chapter_name')->chapter_name;
            $temp->question_text = $question->question_text;
            $opt = DB::select('SELECT * FROM options WHERE question_id = ?', [$question->question_id]);
            $temp->option_1 = $opt[0]->option_text;
            $temp->option_2 = $opt[1]->option_text;
            $temp->option_3 = $opt[2]->option_text;
            $temp->option_4 = $opt[3]->option_text;
            for ($j = 0; $j < 4; $j++) {
                if ($opt[$j]->is_correct == 1) {
                    $temp->correct_option = $j + 1;
                    break;
                }
            }
            $temp->question_explanation = $question->question_answer_explanation;
            switch ($question->question_rating) {
                case '1':
                    $temp->question_rating = 'Easy';
                    break;

                case '2':
                    $temp->question_rating = 'Medium';
                    break;

                case '3':
                    $temp->question_rating = 'Hard';
                    break;

                case '4':
                    $temp->question_rating = 'Very Hard';
                    break;
            }
            array_push($result, $temp);
        }
        return $result;
    }


    private function removeContentEditable($string)
    {
        $string = str_replace('contenteditable="true"', '', $string);
        return $string;
    }
}
