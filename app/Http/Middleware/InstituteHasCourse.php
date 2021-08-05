<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\UserService;
use DB;
class InstituteHasCourse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $institute_id = UserService::getAuthInstituteId();
        $course_count = DB::table('course_student_counts')
                            ->where('institute_id', '=', $institute_id)
                            ->count();
        if($course_count == 0) {
            return redirect('/contact-admin')->with([
                "message" => "You Don't Have Any Course Assigned. Kindly Contact Admin And Get A Course Assigned"
            ]);
        }
        return $next($request);
    }
}
