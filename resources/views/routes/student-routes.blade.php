<li class="nav-item">
    <a class="nav-link {{Request::is("$institute_name/student/dashboard*") ? 'active' : ''}}" href="{{ url("$institute_name/student/dashboard/")}}" role="button" aria-expanded="true" aria-controls="navbar-enquiry">
        <i class="ni ni-album-2 text-primary"></i>
        <span class="nav-link-text">Dashboard</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link  {{Request::is("/$institute_name/student-test*") ? 'active' : ''}}" href="#navbar-test"
       data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-test">
        <i class="ni ni-briefcase-24 text-primary"></i>
        <span class="nav-link-text">My Tests</span>
    </a>
    <div class="collapse {{Request::is("/$institute_name/student-test*") ? 'show' : ''}}" id="navbar-test">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="/{{$institute_name}}/student/tests/pending" class="nav-link">Pending Tests</a>
            </li>
            <li class="nav-item">
                <a href="/{{$institute_name}}/student/tests/submitted" class="nav-link">Submitted Tests</a>
            </li>
            <li class="nav-item">
                <a href="/{{$institute_name}}/student/tests/ongoing" class="nav-link">Ongoing Tests</a>
            </li>
        </ul>
    </div>
</li>

{{-- <li class="nav-item">
    <a class="nav-link {{Request::is('student-courses*') ? 'active' : ''}}" href="#navbar-course"
        data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-course">
        <i class="ni ni-book-bookmark  text-primary"></i>
        <span class="nav-link-text">Student Courses</span>
    </a>
    <div class="collapse {{Request::is('student-courses*') ? 'show' : ''}} " id="navbar-course">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="/student-courses/create" class="nav-link">Add Course</a>
            </li>
            <li class="nav-item">
                <a href="/student-courses" class="nav-link">Manage Courses</a>
            </li>
        </ul>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link  {{Request::is('student-internship*') ? 'active' : ''}}" href="#navbar-internship"
        data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-internship">
        <i class="ni ni-briefcase-24 text-primary"></i>
        <span class="nav-link-text">Student Internship </span>
    </a>
    <div class="collapse {{Request::is('student-internship*') ? 'show' : ''}}" id="navbar-internship">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="/student-internship/create" class="nav-link">Add Internship</a>
            </li>
            <li class="nav-item">
                <a href="/student-internship" class="nav-link">Manage Internships</a>
            </li>
        </ul>
    </div>
</li> --}}
