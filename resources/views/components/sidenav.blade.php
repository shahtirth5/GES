<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header d-flex align-items-center">
            <a class="navbar-brand" href="/dashboard">
                {{-- <img src="{{ \Illuminate\Support\Facades\URL::asset('assets/img/brand/.png') }}" class="navbar-brand-img" alt="..."> --}}
                <h1>GES</h1>
            </a>
            <div class="ml-auto">
                <!-- Sidenav toggler -->
                <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">
                    @role('Institute')
                        @include('routes.institute-routes')
                    @endrole

                    @role('Student')
                        @include('routes.student-routes')
                    @endrole

                    @role('Admin')
                        @include('routes.admin-routes')
                    @endrole
                </ul>
            </div>
        </div>
    </div>
</nav>
