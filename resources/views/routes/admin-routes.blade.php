<li class="nav-item">
    <a class="nav-link {{Request::is('admin/dashboard*') ? 'active' : ''}}" href="{{ url('admin/dashboard/')}}" role="button" aria-expanded="true" aria-controls="navbar-enquiry">
        <i class="ni ni-album-2 text-primary"></i>
        <span class="nav-link-text">Dashboard</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{Request::is('admin/admin-institutes*') ? 'active' : ''}}" href="#navbar-institutes"
        data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-institutes">
        <i class="ni ni-book-bookmark  text-primary"></i>
        <span class="nav-link-text">Institutes</span>
    </a>
    <div class="collapse {{Request::is('admin/admin-institutes*') ? 'show' : ''}} " id="navbar-institutes">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="{{url('/admin/admin-institutes/institute-course-student-count')}}" class="nav-link">Institute - Course - Student Count</a>
            </li>
        </ul>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link {{Request::is('admin/admin-courses*') ? 'active' : ''}}" href="#navbar-course"
        data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-course">
        <i class="ni ni-book-bookmark  text-primary"></i>
        <span class="nav-link-text">Courses</span>
    </a>
    <div class="collapse {{Request::is('admin/admin-courses*') ? 'show' : ''}} " id="navbar-course">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="{{url('admin/admin-courses/add-courses')}}" class="nav-link">Add Course</a>
            </li>
            <li class="nav-item">
                <a href="{{url('admin/admin-courses/manage-courses')}}" class="nav-link">Manage Courses</a>
            </li>
        </ul>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link  {{Request::is('admin/admin-subjects*') ? 'active' : ''}}" href="#navbar-subjects"
        data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-subjects">
        <i class="ni ni-briefcase-24 text-primary"></i>
        <span class="nav-link-text">Subjects </span>
    </a>
    <div class="collapse {{Request::is('admin/admin-subjects*') ? 'show' : ''}}" id="navbar-subjects">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="{{url('admin/admin-subjects/add-subjects')}}" class="nav-link">Add Subjects</a>
            </li>
            <li class="nav-item">
                <a href="{{url('admin/admin-subjects/manage-subjects')}}" class="nav-link">Manage Subjects</a>
            </li>
        </ul>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link  {{Request::is('admin/admin-chapters*') ? 'active' : ''}}" href="#navbar-chpaters"
       data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-chapters">
        <i class="ni ni-briefcase-24 text-primary"></i>
        <span class="nav-link-text">Chapters </span>
    </a>
    <div class="collapse {{Request::is('admin/admin-chapters*') ? 'show' : ''}}" id="navbar-chpaters">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="{{url('admin/admin-chapters/add-chapters')}}" class="nav-link">Add Chapters</a>
            </li>
            <li class="nav-item">
                <a href="{{url('admin/admin-chapters/manage-chapters')}}" class="nav-link">Manage Chapters</a>
            </li>
        </ul>
    </div>
</li>
