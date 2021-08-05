<?php
namespace App\Services;

use DB;
use App\Subject;
use App\Chapter;

class ChapterService {

    // TODO: REFACTOR NAME TO getChaptersBySubjectId ( Currently not done because of not wanting to find usages )
    public function getChapters($subject_id) {
        $chapters = Subject::where('subject_id', '=', $subject_id)->first()->chapters()->get();
        return $chapters;
    }

    public function addChapter($chapter_name , $chapter_description , $subject_id)
    {
        Chapter::create([
            'chapter_name' => $chapter_name,
            'chapter_description' => $chapter_description,
            'subject_id' => $subject_id,
        ]);
    }

    public function getAllChapters($columns) {
        return Chapter::all($columns);
    }

    public function deleteChapter($chapter_id) {
        Chapter::where('chapter_id', $chapter_id)->delete();
    }

    public function editChapter($chapter_id, $columns) {
        Chapter::where('chapter_id' , $chapter_id)->update($columns);
    }


}
