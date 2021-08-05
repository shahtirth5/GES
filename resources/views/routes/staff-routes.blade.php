<li class="nav-item">
    <a class="nav-link {{ Request::is('published-books*') ? 'active' : '' }}" href="#navbar-books" data-toggle="collapse" role="button" aria-expanded="true"
        aria-controls="navbar-dashboards">
        <i class="ni ni-books text-primary"></i>
        <span class="nav-link-text">Published Books</span>
    </a>
    <div class="collapse {{ Request::is('published-books*') ? 'show' : '' }}" id="navbar-books">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="/published-books/create" class="nav-link">Add Published Book</a>
            </li>
            <li class="nav-item">
                <a href="/published-books" class="nav-link">Manage Published Books</a>
            </li>
        </ul>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link {{ Request::is('research-projects*') ? 'active' : '' }}" href="#navbar-projects" data-toggle="collapse" role="button" aria-expanded="true"
        aria-controls="navbar-dashboards">
        <i class="ni ni-spaceship text-primary"></i>
        <span class="nav-link-text">Research Projects</span>
    </a>
    <div class="collapse {{ Request::is('research-projects*') ? 'show' : '' }}" id="navbar-projects">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="/research-projects/create" class="nav-link">Add Research Projects</a>
            </li>
            <li class="nav-item">
                <a href="/research-projects" class="nav-link">Manage Research Projects</a>
            </li>
        </ul>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link {{ Request::is('enquiry') ? 'active' : '' }}" href="#navbar-ipr" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-dashboards">
        <i class="ni ni-badge text-primary"></i>
        <span class="nav-link-text">IPR</span>
    </a>
    <div class="collapse {{ Request::is('enquiry') ? 'show' : '' }}" id="navbar-ipr">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="/ipr/create" class="nav-link">Add IPR</a>
            </li>
            <li class="nav-item">
                <a href="/ipr" class="nav-link">Manage IPR</a>
            </li>
        </ul>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link {{ Request::is('publications*') ? 'active' : '' }}" href="#navbar-publications" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-dashboards">
        <i class="ni ni-book-bookmark text-primary"></i>
        <span class="nav-link-text">Publications</span>
    </a>
    <div class="collapse {{ Request::is('publications*') ? 'show' : '' }}" id="navbar-publications">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="/publications/create" class="nav-link">Add Publication</a>
            </li>
            <li class="nav-item">
                <a href="/publications" class="nav-link">Manage Publications</a>
            </li>
        </ul>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link {{ Request::is('staff-lectures*') ? 'active' : '' }}" href="#navbar-staff-lectures" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-dashboards">
        <i class="ni ni-hat-3 text-primary"></i>
        <span class="nav-link-text">Staff Lectures</span>
    </a>
    <div class="collapse {{ Request::is('staff-lectures*') ? 'show' : '' }}" id="navbar-staff-lectures">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="/staff-lectures/create" class="nav-link">Add Lectures</a>
            </li>
            <li class="nav-item">
                <a href="/staff-lectures" class="nav-link">Manage Staff Lectures</a>
            </li>
        </ul>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link {{ Request::is('sacheivement*') ? 'active' : '' }}" href="#navbar-sacheivement" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-dashboards">
        <i class="ni ni-paper-diploma text-primary"></i>
        <span class="nav-link-text">Staff Acheivements</span>
    </a>
    <div class="collapse {{ Request::is('sacheivement*') ? 'show' : '' }}" id="navbar-sacheivement">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="/sachievement/create" class="nav-link">Add Acheivements</a>
            </li>
            <li class="nav-item">
                <a href="/sachievement" class="nav-link">Manage Acheivements</a>
            </li>
        </ul>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link {{ Request::is('staff-courses*') ? 'active' : '' }}" href="#navbar-staff-courses" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-dashboards">
        <i class="ni ni-single-copy-04 text-primary"></i>
        <span class="nav-link-text">Staff Courses</span>
    </a>
    <div class="collapse {{ Request::is('staff-courses*') ? 'show' : '' }}" id="navbar-staff-courses">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="/staff-courses/create" class="nav-link">Add Courses</a>
            </li>
            <li class="nav-item">
                <a href="/staff-courses" class="nav-link">Manage Staff Courses</a>
            </li>
        </ul>
    </div>
</li>


<li class="nav-item">
    <a class="nav-link {{ Request::is('staff-events*') ? 'active' : '' }}" href="#navbar-staff-events" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-dashboards">
        <i class="ni ni-paper-diploma text-primary"></i>
        <span class="nav-link-text">Staff Events</span>
    </a>
    <div class="collapse {{ Request::is('staff-events*') ? 'show' : '' }}" id="navbar-staff-events">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="/staff-events/create" class="nav-link">Add Events</a>
            </li>
            <li class="nav-item">
                <a href="/staff-events" class="nav-link">Manage Staff Events</a>
            </li>
        </ul>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link {{ Request::is('news-feed*') ? 'active' : '' }}" href="#navbar-newsfeed" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-dashboards">
        <i class="ni ni-archive-2 text-primary"></i>
        <span class="nav-link-text">News</span>
    </a>
    <div class="collapse {{ Request::is('news-feed*') ? 'show' : '' }}" id="navbar-newsfeed">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="/news-feed/create" class="nav-link">Publish News</a>
            </li>
            <li class="nav-item">
                <a href="/news-feed/view-all-news" class="nav-link">View News</a>
            </li>
        </ul>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link {{ Request::is('events*') ? 'active' : '' }}" href="/events/manage" role="button" aria-expanded="true" aria-controls="navbar-dashboards">
        <i class="ni ni-calendar-grid-58 text-primary"></i>
        <span class="nav-link-text">Events</span>
    </a>
</li>
