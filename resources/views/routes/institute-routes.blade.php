<li class="nav-item">
    <a class="nav-link {{Request::is('institute/dashboard*') ? 'active' : ''}}" href="{{ url('institute/dashboard/')}}" role="button" aria-expanded="true" aria-controls="navbar-enquiry">
        <i class="ni ni-map-big text-primary"></i>
        <span class="nav-link-text">Dashboard</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{Request::is('institute/enrollments/*') ? 'active' : ''}}" href="#navbar-enrollments" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-enrollments">
        <i class="ni ni-badge text-primary"></i>
        <span class="nav-link-text">Enrollments</span>
    </a>
    <div class="collapse {{Request::is('institute/enrollments/*') ? 'show' : ''}}" id="navbar-enrollments">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="{{ url('institute/enrollments/pending-student-enrollments') }}" class="nav-link">Pending Enrollments</a>
            </li>
            <li class="nav-item">
                <a href={{ url('institute/enrollments/enrolled-students') }} class="nav-link"> Existing Enrollments </a>
            </li>
            <li class="nav-item">
                <a href={{ url('institute/enrollments/blocked-students') }} class="nav-link"> Blocked Enrollments </a>
            </li>
        </ul>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link {{Request::is('institute/questions/*') ? 'active' : ''}}" href="#navbar-questions" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-questions">
        <i class="fa fa-question text-primary"></i>
        <span class="nav-link-text">Questions</span>
    </a>
    <div class="collapse {{Request::is('institute/enrollments/*') ? 'show' : ''}}" id="navbar-questions">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="{{ url('institute/questions/add-questions') }}" class="nav-link">Add Questions</a>
            </li>
            <li class="nav-item">
                <a href={{ url('institute/questions/existing-questions') }} class="nav-link"> Edit/View Existing Questions </a>
            </li>
        </ul>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link {{Request::is('institute/tests/*') ? 'active' : ''}}" href="#navbar-tests" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-tests">
        <i class="fa fa-calculator text-primary"></i>
        <span class="nav-link-text">Tests</span>
    </a>
    <div class="collapse {{Request::is('institute/tests/*') ? 'show' : ''}}" id="navbar-tests">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href={{ url('institute/tests/create-test') }} class="nav-link">Create Test</a>
            </li>
            <li class="nav-item">
                <a href={{ url('institute/tests/existing-tests') }} class="nav-link">Existing Tests</a>
            </li>
            <li class="nav-item">
                <a href={{ url('institute/tests/results') }} class="nav-link">Results</a>
            </li>
        </ul>
    </div>
</li>

{{--<li class="nav-item">--}}
{{--    <a class="nav-link {{Request::is('admin/events*') ? 'active' : ''}}" href="#navbar-events" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-dashboards">--}}
{{--        <i class="ni ni-calendar-grid-58 text-primary"></i>--}}
{{--        <span class="nav-link-text">Events</span>--}}
{{--    </a>--}}

{{--    <div class="collapse {{Request::is('admin/events*') ? 'show' : ''}}" id="navbar-events">--}}
{{--        <ul class="nav nav-sm flex-column">--}}
{{--            <li class="nav-item">--}}
{{--                <a href="/admin/events/create" class="nav-link">Add Events</a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a href="/admin/events" class="nav-link">Manage Events</a>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--    </div>--}}
{{--</li>--}}

{{--<li class="nav-item">--}}
{{--    <a class="nav-link {{Request::is('classes*') ? 'active' : ''}}" href="#navbar-class" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-class">--}}
{{--        <i class="fa fa-layer-group text-primary"></i>--}}
{{--        <span class="nav-link-text">Class</span>--}}
{{--    </a>--}}
{{--    <div class="collapse {{Request::is('classes*') ? 'show' : ''}}" id="navbar-class">--}}
{{--        <ul class="nav nav-sm flex-column">--}}
{{--            <li class="nav-item">--}}
{{--                <a href="/classes/create" class="nav-link">Add Class</a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a href="/classes" class="nav-link">Manage Class</a>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--    </div>--}}
{{--</li>--}}

{{--<li class="nav-item">--}}
{{--    <a class="nav-link {{ Request::is('/news-feed*') ? 'active' : '' }}" href="#navbar-news-feed" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-dashboards">--}}
{{--        <i class="ni ni-single-copy-04 text-primary"></i>--}}
{{--        <span class="nav-link-text">News</span>--}}
{{--    </a>--}}
{{--    <div class="collapse {{ Request::is('/news-feed*') ? 'show' : '' }}" id="navbar-news-feed">--}}
{{--        <ul class="nav nav-sm flex-column">--}}
{{--            <li class="nav-item">--}}
{{--                <a href="/news-feed/create" class="nav-link">Publish News</a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a href="/news-feed" class="nav-link">Manage News Feed</a>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--    </div>--}}
{{--</li>--}}
