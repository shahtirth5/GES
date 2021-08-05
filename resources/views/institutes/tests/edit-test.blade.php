@extends('layouts.base')

@section('custom-styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
<style>
    .sr-only,
    .bootstrap-datetimepicker-widget .btn[data-action="incrementHours"]::after,
    .bootstrap-datetimepicker-widget .btn[data-action="incrementMinutes"]::after,
    .bootstrap-datetimepicker-widget .btn[data-action="decrementHours"]::after,
    .bootstrap-datetimepicker-widget .btn[data-action="decrementMinutes"]::after,
    .bootstrap-datetimepicker-widget .btn[data-action="showHours"]::after,
    .bootstrap-datetimepicker-widget .btn[data-action="showMinutes"]::after,
    .bootstrap-datetimepicker-widget .btn[data-action="togglePeriod"]::after,
    .bootstrap-datetimepicker-widget .btn[data-action="clear"]::after,
    .bootstrap-datetimepicker-widget .btn[data-action="today"]::after,
    .bootstrap-datetimepicker-widget .picker-switch::after,
    .bootstrap-datetimepicker-widget table th.prev::after,
    .bootstrap-datetimepicker-widget table th.next::after {
        position: absolute;
        width: 1px;
        height: 1px;
        margin: -1px;
        padding: 0;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        border: 0
    }

    /*!
 * Datetimepicker for Bootstrap 3
 * ! version : 4.7.14
 * https://github.com/Eonasdan/bootstrap-datetimepicker/
 */
    .bootstrap-datetimepicker-widget {
        list-style: none
    }

    .bootstrap-datetimepicker-widget.dropdown-menu {
        margin: 2px 0;
        padding: 4px;
        width: 19em
    }

    @media (min-width: 540px) {
        .bootstrap-datetimepicker-widget.dropdown-menu.timepicker-sbs {
            width: 38em
        }
    }

    @media (min-width: 720px) {
        .bootstrap-datetimepicker-widget.dropdown-menu.timepicker-sbs {
            width: 38em
        }
    }

    @media (min-width: 960px) {
        .bootstrap-datetimepicker-widget.dropdown-menu.timepicker-sbs {
            width: 38em
        }
    }

    .bootstrap-datetimepicker-widget.dropdown-menu:before,
    .bootstrap-datetimepicker-widget.dropdown-menu:after {
        content: '';
        display: inline-block;
        position: absolute
    }

    .bootstrap-datetimepicker-widget.dropdown-menu.bottom:before {
        border-left: 7px solid transparent;
        border-right: 7px solid transparent;
        border-bottom: 7px solid #ccc;
        border-bottom-color: rgba(0, 0, 0, 0.2);
        top: -7px;
        left: 7px
    }

    .bootstrap-datetimepicker-widget.dropdown-menu.bottom:after {
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-bottom: 6px solid #fff;
        top: -6px;
        left: 8px
    }

    .bootstrap-datetimepicker-widget.dropdown-menu.top:before {
        border-left: 7px solid transparent;
        border-right: 7px solid transparent;
        border-top: 7px solid #ccc;
        border-top-color: rgba(0, 0, 0, 0.2);
        bottom: -7px;
        left: 6px
    }

    .bootstrap-datetimepicker-widget.dropdown-menu.top:after {
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-top: 6px solid #fff;
        bottom: -6px;
        left: 7px
    }

    .bootstrap-datetimepicker-widget.dropdown-menu.pull-right:before {
        left: auto;
        right: 6px
    }

    .bootstrap-datetimepicker-widget.dropdown-menu.pull-right:after {
        left: auto;
        right: 7px
    }

    .bootstrap-datetimepicker-widget .list-unstyled {
        margin: 0
    }

    .bootstrap-datetimepicker-widget a[data-action] {
        padding: 6px 0
    }

    .bootstrap-datetimepicker-widget a[data-action]:active {
        box-shadow: none
    }

    .bootstrap-datetimepicker-widget .timepicker-hour,
    .bootstrap-datetimepicker-widget .timepicker-minute,
    .bootstrap-datetimepicker-widget .timepicker-second {
        width: 54px;
        font-weight: bold;
        font-size: 1.2em;
        margin: 0
    }

    .bootstrap-datetimepicker-widget button[data-action] {
        padding: 6px
    }

    .bootstrap-datetimepicker-widget .btn[data-action="incrementHours"]::after {
        content: "Increment Hours"
    }

    .bootstrap-datetimepicker-widget .btn[data-action="incrementMinutes"]::after {
        content: "Increment Minutes"
    }

    .bootstrap-datetimepicker-widget .btn[data-action="decrementHours"]::after {
        content: "Decrement Hours"
    }

    .bootstrap-datetimepicker-widget .btn[data-action="decrementMinutes"]::after {
        content: "Decrement Minutes"
    }

    .bootstrap-datetimepicker-widget .btn[data-action="showHours"]::after {
        content: "Show Hours"
    }

    .bootstrap-datetimepicker-widget .btn[data-action="showMinutes"]::after {
        content: "Show Minutes"
    }

    .bootstrap-datetimepicker-widget .btn[data-action="togglePeriod"]::after {
        content: "Toggle AM/PM"
    }

    .bootstrap-datetimepicker-widget .btn[data-action="clear"]::after {
        content: "Clear the picker"
    }

    .bootstrap-datetimepicker-widget .btn[data-action="today"]::after {
        content: "Set the date to today"
    }

    .bootstrap-datetimepicker-widget .picker-switch {
        text-align: center
    }

    .bootstrap-datetimepicker-widget .picker-switch::after {
        content: "Toggle Date and Time Screens"
    }

    .bootstrap-datetimepicker-widget .picker-switch td {
        padding: 0;
        margin: 0;
        height: auto;
        width: auto;
        line-height: inherit
    }

    .bootstrap-datetimepicker-widget .picker-switch td span {
        line-height: 2.5;
        height: 2.5em;
        width: 100%
    }

    .bootstrap-datetimepicker-widget table {
        width: 100%;
        margin: 0
    }

    .bootstrap-datetimepicker-widget table td,
    .bootstrap-datetimepicker-widget table th {
        text-align: center;
        border-radius: .25rem
    }

    .bootstrap-datetimepicker-widget table th {
        height: 20px;
        line-height: 20px;
        width: 20px
    }

    .bootstrap-datetimepicker-widget table th.picker-switch {
        width: 145px
    }

    .bootstrap-datetimepicker-widget table th.disabled,
    .bootstrap-datetimepicker-widget table th.disabled:hover {
        background: none;
        color: #636c72;
        cursor: not-allowed
    }

    .bootstrap-datetimepicker-widget table th.prev::after {
        content: "Previous Month"
    }

    .bootstrap-datetimepicker-widget table th.next::after {
        content: "Next Month"
    }

    .bootstrap-datetimepicker-widget table thead tr:first-child th {
        cursor: pointer
    }

    .bootstrap-datetimepicker-widget table thead tr:first-child th:hover {
        background: #eceeef
    }

    .bootstrap-datetimepicker-widget table td {
        height: 54px;
        line-height: 54px;
        width: 54px
    }

    .bootstrap-datetimepicker-widget table td.cw {
        font-size: .8em;
        height: 20px;
        line-height: 20px;
        color: #636c72
    }

    .bootstrap-datetimepicker-widget table td.day {
        height: 20px;
        line-height: 20px;
        width: 20px;
        padding: 5px
    }

    .bootstrap-datetimepicker-widget table td.day:hover,
    .bootstrap-datetimepicker-widget table td.hour:hover,
    .bootstrap-datetimepicker-widget table td.minute:hover,
    .bootstrap-datetimepicker-widget table td.second:hover {
        background: #eceeef;
        cursor: pointer
    }

    .bootstrap-datetimepicker-widget table td.old,
    .bootstrap-datetimepicker-widget table td.new {
        color: #636c72
    }

    .bootstrap-datetimepicker-widget table td.today {
        position: relative
    }

    .bootstrap-datetimepicker-widget table td.today:before {
        content: '';
        display: inline-block;
        border: solid transparent;
        border-width: 0 0 7px 7px;
        border-bottom-color: #0275d8;
        border-top-color: rgba(0, 0, 0, 0.2);
        position: absolute;
        bottom: 4px;
        right: 4px
    }

    .bootstrap-datetimepicker-widget table td.active,
    .bootstrap-datetimepicker-widget table td.active:hover {
        background-color: #0275d8;
        color: #fff;
        text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25)
    }

    .bootstrap-datetimepicker-widget table td.active.today:before {
        border-bottom-color: #fff
    }

    .bootstrap-datetimepicker-widget table td.disabled,
    .bootstrap-datetimepicker-widget table td.disabled:hover {
        background: none;
        color: #636c72;
        cursor: not-allowed
    }

    .bootstrap-datetimepicker-widget table td span {
        display: inline-block;
        width: 54px;
        height: 54px;
        line-height: 54px;
        margin: 2px 1.5px;
        cursor: pointer;
        border-radius: .25rem
    }

    .bootstrap-datetimepicker-widget table td span:hover {
        background: #eceeef
    }

    .bootstrap-datetimepicker-widget table td span.active {
        background-color: #0275d8;
        color: #fff;
        text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25)
    }

    .bootstrap-datetimepicker-widget table td span.old {
        color: #636c72
    }

    .bootstrap-datetimepicker-widget table td span.disabled,
    .bootstrap-datetimepicker-widget table td span.disabled:hover {
        background: none;
        color: #636c72;
        cursor: not-allowed
    }

    .bootstrap-datetimepicker-widget.usetwentyfour td.hour {
        height: 27px;
        line-height: 27px
    }

    .input-group.date .input-group-addon {
        cursor: pointer
    }
</style>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="/tests"><i class="ni ni-ruler-pencil"></i></a></li>
<li class="breadcrumb-item"><a href="/tests">Tests</a></li>
<li class="breadcrumb-item active" aria-current="page">Create Test</li>
@endsection

@section('page-content')
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="row">
    <div class="col">
        <div class="card">
            <!-- Card header -->
            <div class="card-header">
                @if($disabled)
                <div class="well text-info text-sm"> The test has started. Now you can only extend the Test End
                    Date/Time</div>
                @endif
                <h3 class="mb-0">Edit Test - Step 1</h3>
            </div>

            <!-- Card body -->
            <div class="card-body">
                <form action="{{ url('/institute/tests/edit-test-query') }}" method="post">
                    @csrf
                    <input type="hidden" name="test_id" value="{{$test->test_id}}">
                    <div class="mb-2">
                        <label for="test_name" class="form-control-label"> Test Name </label>
                        <input type="text" name="test_name" id="test_name" class="form-control"
                            value="{{$test->test_name}}" @if($disabled) disabled @endif>
                    </div>

                    <div class="mb-2">
                        <label for="test_description" class="form-control-label"> Test Description </label>
                        <input type="text" name="test_description" id="test_test_description" class="form-control"
                            value="{{$test->test_description}}" @if($disabled) disabled @endif>
                    </div>

                    <div class="mb-2">
                        <label for="course" class="form-control-label">Course</label>
                        <p class="form-control" id="{{$selected_course->course_id}}">{{$selected_course->course_name}}
                        </p>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <label for="test_start_time" class="form-control-label"> Test Start Date &amp; Time </label>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control datetime" id="test_start_time"
                                        name="test_start_time" value="{{$test->test_start_time}}" @if($disabled)
                                        disabled @endif />
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="test_end_time" class="form-control-label"> Test End Date &amp; Time </label>
                            <div class="form-group">
                                <div class="input-group date">
                                    <input type="text" class="form-control datetime" id="test_end_time"
                                        name="test_end_time" value="{{$test->test_end_time}}" />
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="test_duration_min" class="form-control-label"> Test Duration (In Min) </label>
                        <input type="number" name="test_duration_min" id="test_duration_min" class="form-control"
                            value="{{($test->test_duration/60)}}" @if($disabled) disabled @endif>
                    </div>

                    <div class="mb-2">
                        <div class="row">
                            <div class="col-4">
                                <label for="positive_marking" class="form-control-label">Positive Marking</label>
                                <input type="number" name="positive_marking" id="positive_marking" class=form-control
                                    value="{{$test->positive_marking}}" @if($disabled) disabled @endif>
                            </div>
                            <div class="col-4">
                                <label for="neutral_marking" class="form-control-label">Neutral Marking</label>
                                <input type="number" name="neutral_marking" id="form-control" class="form-control"
                                    value="{{$test->neutral_marking}}" @if($disabled) disabled @endif>
                            </div>
                            <div class="col-4">
                                <label for="negative_marking" class="form-control-label">Negative Marking</label>
                                <input type="number" name="negative_marking" id="negative_marking" class="form-control"
                                    value="{{$test->negative_marking}}" @if($disabled) disabled @endif>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <input type="submit" class="btn btn-primary" value="Go To Step 2 - Add/Remove Questions">
                    </div>
                </form>
            </div>
            <!-- -->
        </div>
    </div>
</div>
</div>
@endsection


@section ('custom-script')
<script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
{{-- <script src="{{ asset('assets/vendor/datatables.net-select/js/dataTables.select.min.js') }}"></script> --}}
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script>
    !function(e){"use strict";if("function"==typeof define&&define.amd)define(["jquery","moment"],e);else if("object"==typeof exports)module.exports=e(require("jquery"),require("moment"));else{if("undefined"==typeof jQuery)throw"bootstrap-datetimepicker requires jQuery to be loaded first";if("undefined"==typeof moment)throw"bootstrap-datetimepicker requires Moment.js to be loaded first";e(jQuery,moment)}}(function(e,t){"use strict";if(!t)throw new Error("bootstrap-datetimepicker requires Moment.js to be loaded first");var a=function(a,n){var r,i,o,s,d,l,p,c,u,f={},h=!0,m=!1,y=!1,g=0,w=[{clsName:"days",navFnc:"M",navStep:1},{clsName:"months",navFnc:"y",navStep:1},{clsName:"years",navFnc:"y",navStep:10},{clsName:"decades",navFnc:"y",navStep:100}],b=["days","months","years","decades"],v=["top","bottom","auto"],k=["left","right","auto"],D=["default","top","bottom"],C={up:38,38:"up",down:40,40:"down",left:37,37:"left",right:39,39:"right",tab:9,9:"tab",escape:27,27:"escape",enter:13,13:"enter",pageUp:33,33:"pageUp",pageDown:34,34:"pageDown",shift:16,16:"shift",control:17,17:"control",space:32,32:"space",t:84,84:"t",delete:46,46:"delete"},x={},T=function(){return void 0!==t.tz&&void 0!==n.timeZone&&null!==n.timeZone&&""!==n.timeZone},M=function(e){var a;return a=null==e?t():t.isDate(e)||t.isMoment(e)?t(e):T()?t.tz(e,l,n.useStrict,n.timeZone):t(e,l,n.useStrict),T()&&a.tz(n.timeZone),a},S=function(e){if("string"!=typeof e||e.length>1)throw new TypeError("isEnabled expects a single character string parameter");switch(e){case"y":return-1!==d.indexOf("Y");case"M":return-1!==d.indexOf("M");case"d":return-1!==d.toLowerCase().indexOf("d");case"h":case"H":return-1!==d.toLowerCase().indexOf("h");case"m":return-1!==d.indexOf("m");case"s":return-1!==d.indexOf("s");default:return!1}},O=function(){return S("h")||S("m")||S("s")},P=function(){return S("y")||S("M")||S("d")},E=function(){var t,a,r,i,o,d,l,p,c,u,f=e("<div>").addClass("bootstrap-datetimepicker-widget dropdown-menu"),h=e("<div>").addClass("datepicker").append((c=e("<thead>").append(e("<tr>").append(e("<th>").addClass("prev").attr("data-action","previous").append(e("<span>").addClass(n.icons.previous))).append(e("<th>").addClass("picker-switch").attr("data-action","pickerSwitch").attr("colspan",n.calendarWeeks?"6":"5")).append(e("<th>").addClass("next").attr("data-action","next").append(e("<span>").addClass(n.icons.next)))),u=e("<tbody>").append(e("<tr>").append(e("<td>").attr("colspan",n.calendarWeeks?"8":"7"))),[e("<div>").addClass("datepicker-days").append(e("<table>").addClass("table-condensed").append(c).append(e("<tbody>"))),e("<div>").addClass("datepicker-months").append(e("<table>").addClass("table-condensed").append(c.clone()).append(u.clone())),e("<div>").addClass("datepicker-years").append(e("<table>").addClass("table-condensed").append(c.clone()).append(u.clone())),e("<div>").addClass("datepicker-decades").append(e("<table>").addClass("table-condensed").append(c.clone()).append(u.clone()))])),m=e("<div>").addClass("timepicker").append((o=e("<div>").addClass("timepicker-hours").append(e("<table>").addClass("table-condensed")),d=e("<div>").addClass("timepicker-minutes").append(e("<table>").addClass("table-condensed")),l=e("<div>").addClass("timepicker-seconds").append(e("<table>").addClass("table-condensed")),p=[(a=e("<tr>"),r=e("<tr>"),i=e("<tr>"),S("h")&&(a.append(e("<td>").append(e("<a>").attr({href:"#",tabindex:"-1",title:n.tooltips.incrementHour}).addClass("btn").attr("data-action","incrementHours").append(e("<span>").addClass(n.icons.up)))),r.append(e("<td>").append(e("<span>").addClass("timepicker-hour").attr({"data-time-component":"hours",title:n.tooltips.pickHour}).attr("data-action","showHours"))),i.append(e("<td>").append(e("<a>").attr({href:"#",tabindex:"-1",title:n.tooltips.decrementHour}).addClass("btn").attr("data-action","decrementHours").append(e("<span>").addClass(n.icons.down))))),S("m")&&(S("h")&&(a.append(e("<td>").addClass("separator")),r.append(e("<td>").addClass("separator").html(":")),i.append(e("<td>").addClass("separator"))),a.append(e("<td>").append(e("<a>").attr({href:"#",tabindex:"-1",title:n.tooltips.incrementMinute}).addClass("btn").attr("data-action","incrementMinutes").append(e("<span>").addClass(n.icons.up)))),r.append(e("<td>").append(e("<span>").addClass("timepicker-minute").attr({"data-time-component":"minutes",title:n.tooltips.pickMinute}).attr("data-action","showMinutes"))),i.append(e("<td>").append(e("<a>").attr({href:"#",tabindex:"-1",title:n.tooltips.decrementMinute}).addClass("btn").attr("data-action","decrementMinutes").append(e("<span>").addClass(n.icons.down))))),S("s")&&(S("m")&&(a.append(e("<td>").addClass("separator")),r.append(e("<td>").addClass("separator").html(":")),i.append(e("<td>").addClass("separator"))),a.append(e("<td>").append(e("<a>").attr({href:"#",tabindex:"-1",title:n.tooltips.incrementSecond}).addClass("btn").attr("data-action","incrementSeconds").append(e("<span>").addClass(n.icons.up)))),r.append(e("<td>").append(e("<span>").addClass("timepicker-second").attr({"data-time-component":"seconds",title:n.tooltips.pickSecond}).attr("data-action","showSeconds"))),i.append(e("<td>").append(e("<a>").attr({href:"#",tabindex:"-1",title:n.tooltips.decrementSecond}).addClass("btn").attr("data-action","decrementSeconds").append(e("<span>").addClass(n.icons.down))))),s||(a.append(e("<td>").addClass("separator")),r.append(e("<td>").append(e("<button>").addClass("btn btn-primary").attr({"data-action":"togglePeriod",tabindex:"-1",title:n.tooltips.togglePeriod}))),i.append(e("<td>").addClass("separator"))),e("<div>").addClass("timepicker-picker").append(e("<table>").addClass("table-condensed").append([a,r,i])))],S("h")&&p.push(o),S("m")&&p.push(d),S("s")&&p.push(l),p)),y=e("<ul>").addClass("list-unstyled"),g=e("<li>").addClass("picker-switch"+(n.collapse?" accordion-toggle":"")).append((t=[],n.showTodayButton&&t.push(e("<td>").append(e("<a>").attr({"data-action":"today",title:n.tooltips.today}).append(e("<span>").addClass(n.icons.today)))),!n.sideBySide&&P()&&O()&&t.push(e("<td>").append(e("<a>").attr({"data-action":"togglePicker",title:n.tooltips.selectTime}).append(e("<span>").addClass(n.icons.time)))),n.showClear&&t.push(e("<td>").append(e("<a>").attr({"data-action":"clear",title:n.tooltips.clear}).append(e("<span>").addClass(n.icons.clear)))),n.showClose&&t.push(e("<td>").append(e("<a>").attr({"data-action":"close",title:n.tooltips.close}).append(e("<span>").addClass(n.icons.close)))),e("<table>").addClass("table-condensed").append(e("<tbody>").append(e("<tr>").append(t)))));return n.inline&&f.removeClass("dropdown-menu"),s&&f.addClass("usetwentyfour"),S("s")&&!s&&f.addClass("wider"),n.sideBySide&&P()&&O()?(f.addClass("timepicker-sbs"),"top"===n.toolbarPlacement&&f.append(g),f.append(e("<div>").addClass("row").append(h.addClass("col-md-6")).append(m.addClass("col-md-6"))),"bottom"===n.toolbarPlacement&&f.append(g),f):("top"===n.toolbarPlacement&&y.append(g),P()&&y.append(e("<li>").addClass(n.collapse&&O()?"collapse show":"").append(h)),"default"===n.toolbarPlacement&&y.append(g),O()&&y.append(e("<li>").addClass(n.collapse&&P()?"collapse":"").append(m)),"bottom"===n.toolbarPlacement&&y.append(g),f.append(y))},H=function(){var t,r=(m||a).position(),i=(m||a).offset(),o=n.widgetPositioning.vertical,s=n.widgetPositioning.horizontal;if(n.widgetParent)t=n.widgetParent.append(y);else if(a.is("input"))t=a.after(y).parent();else{if(n.inline)return void(t=a.append(y));t=a,a.children().first().after(y)}if("auto"===o&&(o=i.top+1.5*y.height()>=e(window).height()+e(window).scrollTop()&&y.height()+a.outerHeight()<i.top?"top":"bottom"),"auto"===s&&(s=t.width()<i.left+y.outerWidth()/2&&i.left+y.outerWidth()>e(window).width()?"right":"left"),"top"===o?y.addClass("top").removeClass("bottom"):y.addClass("bottom").removeClass("top"),"right"===s?y.addClass("pull-right"):y.removeClass("pull-right"),"static"===t.css("position")&&(t=t.parents().filter(function(){return"static"!==e(this).css("position")}).first()),0===t.length)throw new Error("datetimepicker component should be placed within a non-static positioned container");y.css({top:"top"===o?"auto":r.top+a.outerHeight(),bottom:"top"===o?t.outerHeight()-(t===a?0:r.top):"auto",left:"left"===s?t===a?0:r.left:"auto",right:"left"===s?"auto":t.outerWidth()-a.outerWidth()-(t===a?0:r.left)})},I=function(e){"dp.change"===e.type&&(e.date&&e.date.isSame(e.oldDate)||!e.date&&!e.oldDate)||a.trigger(e)},Y=function(e){"y"===e&&(e="YYYY"),I({type:"dp.update",change:e,viewDate:i.clone()})},q=function(e){y&&(e&&(p=Math.max(g,Math.min(3,p+e))),y.find(".datepicker > div").hide().filter(".datepicker-"+w[p].clsName).show())},B=function(t,a){if(!t.isValid())return!1;if(n.disabledDates&&"d"===a&&(r=t,!0===n.disabledDates[r.format("YYYY-MM-DD")]))return!1;var r;if(n.enabledDates&&"d"===a&&!function(e){return!0===n.enabledDates[e.format("YYYY-MM-DD")]}(t))return!1;if(n.minDate&&t.isBefore(n.minDate,a))return!1;if(n.maxDate&&t.isAfter(n.maxDate,a))return!1;if(n.daysOfWeekDisabled&&"d"===a&&-1!==n.daysOfWeekDisabled.indexOf(t.day()))return!1;if(n.disabledHours&&("h"===a||"m"===a||"s"===a)&&function(e){return!0===n.disabledHours[e.format("H")]}(t))return!1;if(n.enabledHours&&("h"===a||"m"===a||"s"===a)&&!function(e){return!0===n.enabledHours[e.format("H")]}(t))return!1;if(n.disabledTimeIntervals&&("h"===a||"m"===a||"s"===a)){var i=!1;if(e.each(n.disabledTimeIntervals,function(){if(t.isBetween(this[0],this[1]))return i=!0,!1}),i)return!1}return!0},j=function(){var a,o,s,d=y.find(".datepicker-days"),l=d.find("th"),p=[],c=[];if(P()){for(l.eq(0).find("span").attr("title",n.tooltips.prevMonth),l.eq(1).attr("title",n.tooltips.selectMonth),l.eq(2).find("span").attr("title",n.tooltips.nextMonth),d.find(".disabled").removeClass("disabled"),l.eq(1).text(i.format(n.dayViewHeaderFormat)),B(i.clone().subtract(1,"M"),"M")||l.eq(0).addClass("disabled"),B(i.clone().add(1,"M"),"M")||l.eq(2).addClass("disabled"),a=i.clone().startOf("M").startOf("w").startOf("d"),s=0;s<42;s++)0===a.weekday()&&(o=e("<tr>"),n.calendarWeeks&&o.append('<td class="cw">'+a.week()+"</td>"),p.push(o)),c=["day"],a.isBefore(i,"M")&&c.push("old"),a.isAfter(i,"M")&&c.push("new"),a.isSame(r,"d")&&!h&&c.push("active"),B(a,"d")||c.push("disabled"),a.isSame(M(),"d")&&c.push("today"),0!==a.day()&&6!==a.day()||c.push("weekend"),I({type:"dp.classify",date:a,classNames:c}),o.append('<td data-action="selectDay" data-day="'+a.format("L")+'" class="'+c.join(" ")+'">'+a.date()+"</td>"),a.add(1,"d");var u,f,m;d.find("tbody").empty().append(p),u=y.find(".datepicker-months"),f=u.find("th"),m=u.find("tbody").find("span"),f.eq(0).find("span").attr("title",n.tooltips.prevYear),f.eq(1).attr("title",n.tooltips.selectYear),f.eq(2).find("span").attr("title",n.tooltips.nextYear),u.find(".disabled").removeClass("disabled"),B(i.clone().subtract(1,"y"),"y")||f.eq(0).addClass("disabled"),f.eq(1).text(i.year()),B(i.clone().add(1,"y"),"y")||f.eq(2).addClass("disabled"),m.removeClass("active"),r.isSame(i,"y")&&!h&&m.eq(r.month()).addClass("active"),m.each(function(t){B(i.clone().month(t),"M")||e(this).addClass("disabled")}),function(){var e=y.find(".datepicker-years"),t=e.find("th"),a=i.clone().subtract(5,"y"),o=i.clone().add(6,"y"),s="";for(t.eq(0).find("span").attr("title",n.tooltips.prevDecade),t.eq(1).attr("title",n.tooltips.selectDecade),t.eq(2).find("span").attr("title",n.tooltips.nextDecade),e.find(".disabled").removeClass("disabled"),n.minDate&&n.minDate.isAfter(a,"y")&&t.eq(0).addClass("disabled"),t.eq(1).text(a.year()+"-"+o.year()),n.maxDate&&n.maxDate.isBefore(o,"y")&&t.eq(2).addClass("disabled");!a.isAfter(o,"y");)s+='<span data-action="selectYear" class="year'+(a.isSame(r,"y")&&!h?" active":"")+(B(a,"y")?"":" disabled")+'">'+a.year()+"</span>",a.add(1,"y");e.find("td").html(s)}(),function(){var e,a=y.find(".datepicker-decades"),o=a.find("th"),s=t({y:i.year()-i.year()%100-1}),d=s.clone().add(100,"y"),l=s.clone(),p=!1,c=!1,u="";for(o.eq(0).find("span").attr("title",n.tooltips.prevCentury),o.eq(2).find("span").attr("title",n.tooltips.nextCentury),a.find(".disabled").removeClass("disabled"),(s.isSame(t({y:1900}))||n.minDate&&n.minDate.isAfter(s,"y"))&&o.eq(0).addClass("disabled"),o.eq(1).text(s.year()+"-"+d.year()),(s.isSame(t({y:2e3}))||n.maxDate&&n.maxDate.isBefore(d,"y"))&&o.eq(2).addClass("disabled");!s.isAfter(d,"y");)e=s.year()+12,p=n.minDate&&n.minDate.isAfter(s,"y")&&n.minDate.year()<=e,c=n.maxDate&&n.maxDate.isAfter(s,"y")&&n.maxDate.year()<=e,u+='<span data-action="selectDecade" class="decade'+(r.isAfter(s)&&r.year()<=e?" active":"")+(B(s,"y")||p||c?"":" disabled")+'" data-selection="'+(s.year()+6)+'">'+(s.year()+1)+" - "+(s.year()+12)+"</span>",s.add(12,"y");u+="<span></span><span></span><span></span>",a.find("td").html(u),o.eq(1).text(l.year()+1+"-"+s.year())}()}},A=function(){var t,a,o=y.find(".timepicker span[data-time-component]");s||(t=y.find(".timepicker [data-action=togglePeriod]"),a=r.clone().add(r.hours()>=12?-12:12,"h"),t.text(r.format("A")),B(a,"h")?t.removeClass("disabled"):t.addClass("disabled")),o.filter("[data-time-component=hours]").text(r.format(s?"HH":"hh")),o.filter("[data-time-component=minutes]").text(r.format("mm")),o.filter("[data-time-component=seconds]").text(r.format("ss")),function(){var t=y.find(".timepicker-hours table"),a=i.clone().startOf("d"),n=[],r=e("<tr>");for(i.hour()>11&&!s&&a.hour(12);a.isSame(i,"d")&&(s||i.hour()<12&&a.hour()<12||i.hour()>11);)a.hour()%4==0&&(r=e("<tr>"),n.push(r)),r.append('<td data-action="selectHour" class="hour'+(B(a,"h")?"":" disabled")+'">'+a.format(s?"HH":"hh")+"</td>"),a.add(1,"h");t.empty().append(n)}(),function(){for(var t=y.find(".timepicker-minutes table"),a=i.clone().startOf("h"),r=[],o=e("<tr>"),s=1===n.stepping?5:n.stepping;i.isSame(a,"h");)a.minute()%(4*s)==0&&(o=e("<tr>"),r.push(o)),o.append('<td data-action="selectMinute" class="minute'+(B(a,"m")?"":" disabled")+'">'+a.format("mm")+"</td>"),a.add(s,"m");t.empty().append(r)}(),function(){for(var t=y.find(".timepicker-seconds table"),a=i.clone().startOf("m"),n=[],r=e("<tr>");i.isSame(a,"m");)a.second()%20==0&&(r=e("<tr>"),n.push(r)),r.append('<td data-action="selectSecond" class="second'+(B(a,"s")?"":" disabled")+'">'+a.format("ss")+"</td>"),a.add(5,"s");t.empty().append(n)}()},F=function(){y&&(j(),A())},L=function(e){var t=h?null:r;if(!e)return h=!0,o.val(""),a.data("date",""),I({type:"dp.change",date:!1,oldDate:t}),void F();if(e=e.clone().locale(n.locale),T()&&e.tz(n.timeZone),1!==n.stepping)for(e.minutes(Math.round(e.minutes()/n.stepping)*n.stepping).seconds(0);n.minDate&&e.isBefore(n.minDate);)e.add(n.stepping,"minutes");B(e)?(i=(r=e).clone(),o.val(r.format(d)),a.data("date",r.format(d)),h=!1,F(),I({type:"dp.change",date:r.clone(),oldDate:t})):(n.keepInvalid?I({type:"dp.change",date:e,oldDate:t}):o.val(h?"":r.format(d)),I({type:"dp.error",date:e,oldDate:t}))},W=function(){var t=!1;return y?(y.find(".collapse").each(function(){var a=e(this).data("collapse");return!a||!a.transitioning||(t=!0,!1)}),t?f:(m&&m.hasClass("btn")&&m.toggleClass("active"),y.hide(),e(window).off("resize",H),y.off("click","[data-action]"),y.off("mousedown",!1),y.remove(),y=!1,I({type:"dp.hide",date:r.clone()}),o.blur(),i=r.clone(),f)):f},z=function(){L(null)},N=function(e){return void 0===n.parseInputDate?(!t.isMoment(e)||e instanceof Date)&&(e=M(e)):e=n.parseInputDate(e),e},V={next:function(){var e=w[p].navFnc;i.add(w[p].navStep,e),j(),Y(e)},previous:function(){var e=w[p].navFnc;i.subtract(w[p].navStep,e),j(),Y(e)},pickerSwitch:function(){q(1)},selectMonth:function(t){var a=e(t.target).closest("tbody").find("span").index(e(t.target));i.month(a),p===g?(L(r.clone().year(i.year()).month(i.month())),n.inline||W()):(q(-1),j()),Y("M")},selectYear:function(t){var a=parseInt(e(t.target).text(),10)||0;i.year(a),p===g?(L(r.clone().year(i.year())),n.inline||W()):(q(-1),j()),Y("YYYY")},selectDecade:function(t){var a=parseInt(e(t.target).data("selection"),10)||0;i.year(a),p===g?(L(r.clone().year(i.year())),n.inline||W()):(q(-1),j()),Y("YYYY")},selectDay:function(t){var a=i.clone();e(t.target).is(".old")&&a.subtract(1,"M"),e(t.target).is(".new")&&a.add(1,"M"),L(a.date(parseInt(e(t.target).text(),10))),O()||n.keepOpen||n.inline||W()},incrementHours:function(){var e=r.clone().add(1,"h");B(e,"h")&&L(e)},incrementMinutes:function(){var e=r.clone().add(n.stepping,"m");B(e,"m")&&L(e)},incrementSeconds:function(){var e=r.clone().add(1,"s");B(e,"s")&&L(e)},decrementHours:function(){var e=r.clone().subtract(1,"h");B(e,"h")&&L(e)},decrementMinutes:function(){var e=r.clone().subtract(n.stepping,"m");B(e,"m")&&L(e)},decrementSeconds:function(){var e=r.clone().subtract(1,"s");B(e,"s")&&L(e)},togglePeriod:function(){L(r.clone().add(r.hours()>=12?-12:12,"h"))},togglePicker:function(t){var a,r=e(t.target),i=r.closest("ul"),o=i.find(".show"),s=i.find(".collapse:not(.show)");if(o&&o.length){if((a=o.data("collapse"))&&a.transitioning)return;o.collapse?(o.collapse("hide"),s.collapse("show")):(o.removeClass("show"),s.addClass("show")),r.is("span")?r.toggleClass(n.icons.time+" "+n.icons.date):r.find("span").toggleClass(n.icons.time+" "+n.icons.date)}},showPicker:function(){y.find(".timepicker > div:not(.timepicker-picker)").hide(),y.find(".timepicker .timepicker-picker").show()},showHours:function(){y.find(".timepicker .timepicker-picker").hide(),y.find(".timepicker .timepicker-hours").show()},showMinutes:function(){y.find(".timepicker .timepicker-picker").hide(),y.find(".timepicker .timepicker-minutes").show()},showSeconds:function(){y.find(".timepicker .timepicker-picker").hide(),y.find(".timepicker .timepicker-seconds").show()},selectHour:function(t){var a=parseInt(e(t.target).text(),10);s||(r.hours()>=12?12!==a&&(a+=12):12===a&&(a=0)),L(r.clone().hours(a)),V.showPicker.call(f)},selectMinute:function(t){L(r.clone().minutes(parseInt(e(t.target).text(),10))),V.showPicker.call(f)},selectSecond:function(t){L(r.clone().seconds(parseInt(e(t.target).text(),10))),V.showPicker.call(f)},clear:z,today:function(){var e=M();B(e,"d")&&L(e)},close:W},Z=function(t){return!e(t.currentTarget).is(".disabled")&&(V[e(t.currentTarget).data("action")].apply(f,arguments),!1)},R=function(){var t;return o.prop("disabled")||!n.ignoreReadonly&&o.prop("readonly")||y?f:(void 0!==o.val()&&0!==o.val().trim().length?L(N(o.val().trim())):h&&n.useCurrent&&(n.inline||o.is("input")&&0===o.val().trim().length)&&(t=M(),"string"==typeof n.useCurrent&&(t={year:function(e){return e.month(0).date(1).hours(0).seconds(0).minutes(0)},month:function(e){return e.date(1).hours(0).seconds(0).minutes(0)},day:function(e){return e.hours(0).seconds(0).minutes(0)},hour:function(e){return e.seconds(0).minutes(0)},minute:function(e){return e.seconds(0)}}[n.useCurrent](t)),L(t)),y=E(),function(){var t=e("<tr>"),a=i.clone().startOf("w").startOf("d");for(!0===n.calendarWeeks&&t.append(e("<th>").addClass("cw").text("#"));a.isBefore(i.clone().endOf("w"));)t.append(e("<th>").addClass("dow").text(a.format("dd"))),a.add(1,"d");y.find(".datepicker-days thead").append(t)}(),function(){for(var t=[],a=i.clone().startOf("y").startOf("d");a.isSame(i,"y");)t.push(e("<span>").attr("data-action","selectMonth").addClass("month").text(a.format("MMM"))),a.add(1,"M");y.find(".datepicker-months td").empty().append(t)}(),y.find(".timepicker-hours").hide(),y.find(".timepicker-minutes").hide(),y.find(".timepicker-seconds").hide(),F(),q(),e(window).on("resize",H),y.on("click","[data-action]",Z),y.on("mousedown",!1),m&&m.hasClass("btn")&&m.toggleClass("active"),H(),y.show(),n.focusOnShow&&!o.is(":focus")&&o.focus(),I({type:"dp.show"}),f)},Q=function(){return y?W():R()},U=function(e){var t,a,r,i,o=null,s=[],d={},l=e.which;for(t in x[l]="p",x)x.hasOwnProperty(t)&&"p"===x[t]&&(s.push(t),parseInt(t,10)!==l&&(d[t]=!0));for(t in n.keyBinds)if(n.keyBinds.hasOwnProperty(t)&&"function"==typeof n.keyBinds[t]&&(r=t.split(" ")).length===s.length&&C[l]===r[r.length-1]){for(i=!0,a=r.length-2;a>=0;a--)if(!(C[r[a]]in d)){i=!1;break}if(i){o=n.keyBinds[t];break}}o&&(o.call(f,y),e.stopPropagation(),e.preventDefault())},G=function(e){x[e.which]="r",e.stopPropagation(),e.preventDefault()},J=function(t){var a=e(t.target).val().trim(),n=a?N(a):null;return L(n),t.stopImmediatePropagation(),!1},K=function(t){var a={};return e.each(t,function(){var e=N(this);e.isValid()&&(a[e.format("YYYY-MM-DD")]=!0)}),!!Object.keys(a).length&&a},X=function(t){var a={};return e.each(t,function(){a[this]=!0}),!!Object.keys(a).length&&a},$=function(){var e=n.format||"L LT";d=e.replace(/(\[[^\[]*\])|(\\)?(LTS|LT|LL?L?L?|l{1,4})/g,function(e){return(r.localeData().longDateFormat(e)||e).replace(/(\[[^\[]*\])|(\\)?(LTS|LT|LL?L?L?|l{1,4})/g,function(e){return r.localeData().longDateFormat(e)||e})}),(l=n.extraFormats?n.extraFormats.slice():[]).indexOf(e)<0&&l.indexOf(d)<0&&l.push(d),s=d.toLowerCase().indexOf("a")<1&&d.replace(/\[.*?\]/g,"").indexOf("h")<1,S("y")&&(g=2),S("M")&&(g=1),S("d")&&(g=0),p=Math.max(g,p),h||L(r)};if(f.destroy=function(){W(),o.off({change:J,blur:blur,keydown:U,keyup:G,focus:n.allowInputToggle?W:""}),a.is("input")?o.off({focus:R}):m&&(m.off("click",Q),m.off("mousedown",!1)),a.removeData("DateTimePicker"),a.removeData("date")},f.toggle=Q,f.show=R,f.hide=W,f.disable=function(){return W(),m&&m.hasClass("btn")&&m.addClass("disabled"),o.prop("disabled",!0),f},f.enable=function(){return m&&m.hasClass("btn")&&m.removeClass("disabled"),o.prop("disabled",!1),f},f.ignoreReadonly=function(e){if(0===arguments.length)return n.ignoreReadonly;if("boolean"!=typeof e)throw new TypeError("ignoreReadonly () expects a boolean parameter");return n.ignoreReadonly=e,f},f.options=function(t){if(0===arguments.length)return e.extend(!0,{},n);if(!(t instanceof Object))throw new TypeError("options() options parameter should be an object");return e.extend(!0,n,t),e.each(n,function(e,t){if(void 0===f[e])throw new TypeError("option "+e+" is not recognized!");f[e](t)}),f},f.date=function(e){if(0===arguments.length)return h?null:r.clone();if(!(null===e||"string"==typeof e||t.isMoment(e)||e instanceof Date))throw new TypeError("date() parameter must be one of [null, string, moment or Date]");return L(null===e?null:N(e)),f},f.format=function(e){if(0===arguments.length)return n.format;if("string"!=typeof e&&("boolean"!=typeof e||!1!==e))throw new TypeError("format() expects a string or boolean:false parameter "+e);return n.format=e,d&&$(),f},f.timeZone=function(e){if(0===arguments.length)return n.timeZone;if("string"!=typeof e)throw new TypeError("newZone() expects a string parameter");return n.timeZone=e,f},f.dayViewHeaderFormat=function(e){if(0===arguments.length)return n.dayViewHeaderFormat;if("string"!=typeof e)throw new TypeError("dayViewHeaderFormat() expects a string parameter");return n.dayViewHeaderFormat=e,f},f.extraFormats=function(e){if(0===arguments.length)return n.extraFormats;if(!1!==e&&!(e instanceof Array))throw new TypeError("extraFormats() expects an array or false parameter");return n.extraFormats=e,l&&$(),f},f.disabledDates=function(t){if(0===arguments.length)return n.disabledDates?e.extend({},n.disabledDates):n.disabledDates;if(!t)return n.disabledDates=!1,F(),f;if(!(t instanceof Array))throw new TypeError("disabledDates() expects an array parameter");return n.disabledDates=K(t),n.enabledDates=!1,F(),f},f.enabledDates=function(t){if(0===arguments.length)return n.enabledDates?e.extend({},n.enabledDates):n.enabledDates;if(!t)return n.enabledDates=!1,F(),f;if(!(t instanceof Array))throw new TypeError("enabledDates() expects an array parameter");return n.enabledDates=K(t),n.disabledDates=!1,F(),f},f.daysOfWeekDisabled=function(e){if(0===arguments.length)return n.daysOfWeekDisabled.splice(0);if("boolean"==typeof e&&!e)return n.daysOfWeekDisabled=!1,F(),f;if(!(e instanceof Array))throw new TypeError("daysOfWeekDisabled() expects an array parameter");if(n.daysOfWeekDisabled=e.reduce(function(e,t){return(t=parseInt(t,10))>6||t<0||isNaN(t)?e:(-1===e.indexOf(t)&&e.push(t),e)},[]).sort(),n.useCurrent&&!n.keepInvalid){for(var t=0;!B(r,"d");){if(r.add(1,"d"),31===t)throw"Tried 31 times to find a valid date";t++}L(r)}return F(),f},f.maxDate=function(e){if(0===arguments.length)return n.maxDate?n.maxDate.clone():n.maxDate;if("boolean"==typeof e&&!1===e)return n.maxDate=!1,F(),f;"string"==typeof e&&("now"!==e&&"moment"!==e||(e=M()));var t=N(e);if(!t.isValid())throw new TypeError("maxDate() Could not parse date parameter: "+e);if(n.minDate&&t.isBefore(n.minDate))throw new TypeError("maxDate() date parameter is before options.minDate: "+t.format(d));return n.maxDate=t,n.useCurrent&&!n.keepInvalid&&r.isAfter(e)&&L(n.maxDate),i.isAfter(t)&&(i=t.clone().subtract(n.stepping,"m")),F(),f},f.minDate=function(e){if(0===arguments.length)return n.minDate?n.minDate.clone():n.minDate;if("boolean"==typeof e&&!1===e)return n.minDate=!1,F(),f;"string"==typeof e&&("now"!==e&&"moment"!==e||(e=M()));var t=N(e);if(!t.isValid())throw new TypeError("minDate() Could not parse date parameter: "+e);if(n.maxDate&&t.isAfter(n.maxDate))throw new TypeError("minDate() date parameter is after options.maxDate: "+t.format(d));return n.minDate=t,n.useCurrent&&!n.keepInvalid&&r.isBefore(e)&&L(n.minDate),i.isBefore(t)&&(i=t.clone().add(n.stepping,"m")),F(),f},f.defaultDate=function(e){if(0===arguments.length)return n.defaultDate?n.defaultDate.clone():n.defaultDate;if(!e)return n.defaultDate=!1,f;"string"==typeof e&&(e="now"===e||"moment"===e?M():M(e));var t=N(e);if(!t.isValid())throw new TypeError("defaultDate() Could not parse date parameter: "+e);if(!B(t))throw new TypeError("defaultDate() date passed is invalid according to component setup validations");return n.defaultDate=t,(n.defaultDate&&n.inline||""===o.val().trim())&&L(n.defaultDate),f},f.locale=function(e){if(0===arguments.length)return n.locale;if(!t.localeData(e))throw new TypeError("locale() locale "+e+" is not loaded from moment locales!");return n.locale=e,r.locale(n.locale),i.locale(n.locale),d&&$(),y&&(W(),R()),f},f.stepping=function(e){return 0===arguments.length?n.stepping:(e=parseInt(e,10),(isNaN(e)||e<1)&&(e=1),n.stepping=e,f)},f.useCurrent=function(e){var t=["year","month","day","hour","minute"];if(0===arguments.length)return n.useCurrent;if("boolean"!=typeof e&&"string"!=typeof e)throw new TypeError("useCurrent() expects a boolean or string parameter");if("string"==typeof e&&-1===t.indexOf(e.toLowerCase()))throw new TypeError("useCurrent() expects a string parameter of "+t.join(", "));return n.useCurrent=e,f},f.collapse=function(e){if(0===arguments.length)return n.collapse;if("boolean"!=typeof e)throw new TypeError("collapse() expects a boolean parameter");return n.collapse===e?f:(n.collapse=e,y&&(W(),R()),f)},f.icons=function(t){if(0===arguments.length)return e.extend({},n.icons);if(!(t instanceof Object))throw new TypeError("icons() expects parameter to be an Object");return e.extend(n.icons,t),y&&(W(),R()),f},f.tooltips=function(t){if(0===arguments.length)return e.extend({},n.tooltips);if(!(t instanceof Object))throw new TypeError("tooltips() expects parameter to be an Object");return e.extend(n.tooltips,t),y&&(W(),R()),f},f.useStrict=function(e){if(0===arguments.length)return n.useStrict;if("boolean"!=typeof e)throw new TypeError("useStrict() expects a boolean parameter");return n.useStrict=e,f},f.sideBySide=function(e){if(0===arguments.length)return n.sideBySide;if("boolean"!=typeof e)throw new TypeError("sideBySide() expects a boolean parameter");return n.sideBySide=e,y&&(W(),R()),f},f.viewMode=function(e){if(0===arguments.length)return n.viewMode;if("string"!=typeof e)throw new TypeError("viewMode() expects a string parameter");if(-1===b.indexOf(e))throw new TypeError("viewMode() parameter must be one of ("+b.join(", ")+") value");return n.viewMode=e,p=Math.max(b.indexOf(e),g),q(),f},f.toolbarPlacement=function(e){if(0===arguments.length)return n.toolbarPlacement;if("string"!=typeof e)throw new TypeError("toolbarPlacement() expects a string parameter");if(-1===D.indexOf(e))throw new TypeError("toolbarPlacement() parameter must be one of ("+D.join(", ")+") value");return n.toolbarPlacement=e,y&&(W(),R()),f},f.widgetPositioning=function(t){if(0===arguments.length)return e.extend({},n.widgetPositioning);if("[object Object]"!=={}.toString.call(t))throw new TypeError("widgetPositioning() expects an object variable");if(t.horizontal){if("string"!=typeof t.horizontal)throw new TypeError("widgetPositioning() horizontal variable must be a string");if(t.horizontal=t.horizontal.toLowerCase(),-1===k.indexOf(t.horizontal))throw new TypeError("widgetPositioning() expects horizontal parameter to be one of ("+k.join(", ")+")");n.widgetPositioning.horizontal=t.horizontal}if(t.vertical){if("string"!=typeof t.vertical)throw new TypeError("widgetPositioning() vertical variable must be a string");if(t.vertical=t.vertical.toLowerCase(),-1===v.indexOf(t.vertical))throw new TypeError("widgetPositioning() expects vertical parameter to be one of ("+v.join(", ")+")");n.widgetPositioning.vertical=t.vertical}return F(),f},f.calendarWeeks=function(e){if(0===arguments.length)return n.calendarWeeks;if("boolean"!=typeof e)throw new TypeError("calendarWeeks() expects parameter to be a boolean value");return n.calendarWeeks=e,F(),f},f.showTodayButton=function(e){if(0===arguments.length)return n.showTodayButton;if("boolean"!=typeof e)throw new TypeError("showTodayButton() expects a boolean parameter");return n.showTodayButton=e,y&&(W(),R()),f},f.showClear=function(e){if(0===arguments.length)return n.showClear;if("boolean"!=typeof e)throw new TypeError("showClear() expects a boolean parameter");return n.showClear=e,y&&(W(),R()),f},f.widgetParent=function(t){if(0===arguments.length)return n.widgetParent;if("string"==typeof t&&(t=e(t)),null!==t&&"string"!=typeof t&&!(t instanceof e))throw new TypeError("widgetParent() expects a string or a jQuery object parameter");return n.widgetParent=t,y&&(W(),R()),f},f.keepOpen=function(e){if(0===arguments.length)return n.keepOpen;if("boolean"!=typeof e)throw new TypeError("keepOpen() expects a boolean parameter");return n.keepOpen=e,f},f.focusOnShow=function(e){if(0===arguments.length)return n.focusOnShow;if("boolean"!=typeof e)throw new TypeError("focusOnShow() expects a boolean parameter");return n.focusOnShow=e,f},f.inline=function(e){if(0===arguments.length)return n.inline;if("boolean"!=typeof e)throw new TypeError("inline() expects a boolean parameter");return n.inline=e,f},f.clear=function(){return z(),f},f.keyBinds=function(e){return 0===arguments.length?n.keyBinds:(n.keyBinds=e,f)},f.getMoment=function(e){return M(e)},f.debug=function(e){if("boolean"!=typeof e)throw new TypeError("debug() expects a boolean parameter");return n.debug=e,f},f.allowInputToggle=function(e){if(0===arguments.length)return n.allowInputToggle;if("boolean"!=typeof e)throw new TypeError("allowInputToggle() expects a boolean parameter");return n.allowInputToggle=e,f},f.showClose=function(e){if(0===arguments.length)return n.showClose;if("boolean"!=typeof e)throw new TypeError("showClose() expects a boolean parameter");return n.showClose=e,f},f.keepInvalid=function(e){if(0===arguments.length)return n.keepInvalid;if("boolean"!=typeof e)throw new TypeError("keepInvalid() expects a boolean parameter");return n.keepInvalid=e,f},f.datepickerInput=function(e){if(0===arguments.length)return n.datepickerInput;if("string"!=typeof e)throw new TypeError("datepickerInput() expects a string parameter");return n.datepickerInput=e,f},f.parseInputDate=function(e){if(0===arguments.length)return n.parseInputDate;if("function"!=typeof e)throw new TypeError("parseInputDate() sholud be as function");return n.parseInputDate=e,f},f.disabledTimeIntervals=function(t){if(0===arguments.length)return n.disabledTimeIntervals?e.extend({},n.disabledTimeIntervals):n.disabledTimeIntervals;if(!t)return n.disabledTimeIntervals=!1,F(),f;if(!(t instanceof Array))throw new TypeError("disabledTimeIntervals() expects an array parameter");return n.disabledTimeIntervals=t,F(),f},f.disabledHours=function(t){if(0===arguments.length)return n.disabledHours?e.extend({},n.disabledHours):n.disabledHours;if(!t)return n.disabledHours=!1,F(),f;if(!(t instanceof Array))throw new TypeError("disabledHours() expects an array parameter");if(n.disabledHours=X(t),n.enabledHours=!1,n.useCurrent&&!n.keepInvalid){for(var a=0;!B(r,"h");){if(r.add(1,"h"),24===a)throw"Tried 24 times to find a valid date";a++}L(r)}return F(),f},f.enabledHours=function(t){if(0===arguments.length)return n.enabledHours?e.extend({},n.enabledHours):n.enabledHours;if(!t)return n.enabledHours=!1,F(),f;if(!(t instanceof Array))throw new TypeError("enabledHours() expects an array parameter");if(n.enabledHours=X(t),n.disabledHours=!1,n.useCurrent&&!n.keepInvalid){for(var a=0;!B(r,"h");){if(r.add(1,"h"),24===a)throw"Tried 24 times to find a valid date";a++}L(r)}return F(),f},f.viewDate=function(e){if(0===arguments.length)return i.clone();if(!e)return i=r.clone(),f;if(!("string"==typeof e||t.isMoment(e)||e instanceof Date))throw new TypeError("viewDate() parameter must be one of [string, moment or Date]");return i=N(e),Y(),f},a.is("input"))o=a;else if(0===(o=a.find(n.datepickerInput)).length)o=a.find("input");else if(!o.is("input"))throw new Error('CSS class "'+n.datepickerInput+'" cannot be applied to non input element');if(a.hasClass("input-group")&&(m=0===a.find(".datepickerbutton").length?a.find(".input-group-addon"):a.find(".datepickerbutton")),!n.inline&&!o.is("input"))throw new Error("Could not initialize DateTimePicker without an input element");return r=M(),i=r.clone(),e.extend(!0,n,(u={},(c=a.is("input")||n.inline?a.data():a.find("input").data()).dateOptions&&c.dateOptions instanceof Object&&(u=e.extend(!0,u,c.dateOptions)),e.each(n,function(e){var t="date"+e.charAt(0).toUpperCase()+e.slice(1);void 0!==c[t]&&(u[e]=c[t])}),u)),f.options(n),$(),o.on({change:J,blur:n.debug?"":W,keydown:U,keyup:G,focus:n.allowInputToggle?R:""}),a.is("input")?o.on({focus:R}):m&&(m.on("click",Q),m.on("mousedown",!1)),o.prop("disabled")&&f.disable(),o.is("input")&&0!==o.val().trim().length?L(N(o.val().trim())):n.defaultDate&&void 0===o.attr("placeholder")&&L(n.defaultDate),n.inline&&R(),f};return e.fn.datetimepicker=function(t){t=t||{};var n,r=Array.prototype.slice.call(arguments,1),i=!0;if("object"==typeof t)return this.each(function(){var n,r=e(this);r.data("DateTimePicker")||(n=e.extend(!0,{},e.fn.datetimepicker.defaults,t),r.data("DateTimePicker",a(r,n)))});if("string"==typeof t)return this.each(function(){var a=e(this).data("DateTimePicker");if(!a)throw new Error('bootstrap-datetimepicker("'+t+'") method was called on an element that is not using DateTimePicker');n=a[t].apply(a,r),i=n===a}),i||e.inArray(t,["destroy","hide","show","toggle"])>-1?this:n;throw new TypeError("Invalid arguments for DateTimePicker: "+t)},e.fn.datetimepicker.defaults={timeZone:"",format:!1,dayViewHeaderFormat:"MMMM YYYY",extraFormats:!1,stepping:1,minDate:!1,maxDate:!1,useCurrent:!0,collapse:!0,locale:t.locale(),defaultDate:!1,disabledDates:!1,enabledDates:!1,icons:{time:"glyphicon glyphicon-time",date:"glyphicon glyphicon-calendar",up:"glyphicon glyphicon-chevron-up",down:"glyphicon glyphicon-chevron-down",previous:"glyphicon glyphicon-chevron-left",next:"glyphicon glyphicon-chevron-right",today:"glyphicon glyphicon-screenshot",clear:"glyphicon glyphicon-trash",close:"glyphicon glyphicon-remove"},tooltips:{today:"Go to today",clear:"Clear selection",close:"Close the picker",selectMonth:"Select Month",prevMonth:"Previous Month",nextMonth:"Next Month",selectYear:"Select Year",prevYear:"Previous Year",nextYear:"Next Year",selectDecade:"Select Decade",prevDecade:"Previous Decade",nextDecade:"Next Decade",prevCentury:"Previous Century",nextCentury:"Next Century",pickHour:"Pick Hour",incrementHour:"Increment Hour",decrementHour:"Decrement Hour",pickMinute:"Pick Minute",incrementMinute:"Increment Minute",decrementMinute:"Decrement Minute",pickSecond:"Pick Second",incrementSecond:"Increment Second",decrementSecond:"Decrement Second",togglePeriod:"Toggle Period",selectTime:"Select Time"},useStrict:!1,sideBySide:!1,daysOfWeekDisabled:!1,calendarWeeks:!1,viewMode:"days",toolbarPlacement:"default",showTodayButton:!1,showClear:!1,showClose:!1,widgetPositioning:{horizontal:"auto",vertical:"auto"},widgetParent:null,ignoreReadonly:!1,keepOpen:!1,focusOnShow:!0,inline:!1,keepInvalid:!1,datepickerInput:".datepickerinput",keyBinds:{up:function(e){if(e){var t=this.date()||this.getMoment();e.find(".datepicker").is(":visible")?this.date(t.clone().subtract(7,"d")):this.date(t.clone().add(this.stepping(),"m"))}},down:function(e){if(e){var t=this.date()||this.getMoment();e.find(".datepicker").is(":visible")?this.date(t.clone().add(7,"d")):this.date(t.clone().subtract(this.stepping(),"m"))}else this.show()},"control up":function(e){if(e){var t=this.date()||this.getMoment();e.find(".datepicker").is(":visible")?this.date(t.clone().subtract(1,"y")):this.date(t.clone().add(1,"h"))}},"control down":function(e){if(e){var t=this.date()||this.getMoment();e.find(".datepicker").is(":visible")?this.date(t.clone().add(1,"y")):this.date(t.clone().subtract(1,"h"))}},left:function(e){if(e){var t=this.date()||this.getMoment();e.find(".datepicker").is(":visible")&&this.date(t.clone().subtract(1,"d"))}},right:function(e){if(e){var t=this.date()||this.getMoment();e.find(".datepicker").is(":visible")&&this.date(t.clone().add(1,"d"))}},pageUp:function(e){if(e){var t=this.date()||this.getMoment();e.find(".datepicker").is(":visible")&&this.date(t.clone().subtract(1,"M"))}},pageDown:function(e){if(e){var t=this.date()||this.getMoment();e.find(".datepicker").is(":visible")&&this.date(t.clone().add(1,"M"))}},enter:function(){this.hide()},escape:function(){this.hide()},"control space":function(e){e&&e.find(".timepicker").is(":visible")&&e.find('.btn[data-action="togglePeriod"]').click()},t:function(){this.date(this.getMoment())},delete:function(){this.clear()}},debug:!1,allowInputToggle:!1,disabledTimeIntervals:!1,disabledHours:!1,enabledHours:!1,viewDate:!1},e.fn.datetimepicker});
</script>

<script>
    $(document).ready(function () {
            $('#test_start_time').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss',
                icons: {
                    time: 'fa fa-clock',
                    date: 'fa fa-calendar',
                    up: 'fa fa-chevron-up',
                    down: 'fa fa-chevron-down',
                    previous: 'fa fa-chevron-left',
                    next: 'fa fa-chevron-right',
                    today: 'fa fa-check',
                    clear: 'fa fa-trash',
                    close: 'fa fa-times'
                },
                minDate: moment('{{$test->test_start_time}}'),
            });

            $('#test_end_time').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss',
                icons: {
                    time: 'fa fa-clock',
                    date: 'fa fa-calendar',
                    up: 'fa fa-chevron-up',
                    down: 'fa fa-chevron-down',
                    previous: 'fa fa-chevron-left',
                    next: 'fa fa-chevron-right',
                    today: 'fa fa-check',
                    clear: 'fa fa-trash',
                    close: 'fa fa-times'
                },
                minDate: moment('{{$test->test_end_time}}'),
            });
        });

        $('form').submit(function() {
            $(':disabled').each(function(e) {
                $(this).removeAttr('disabled')
            })
        })
</script>

@if(session()->has('type'))
<script>
    $.notify({
                // options
                title: '<h4 style="color:white">{{ session('title') }}</h4>',
                message: '{{ session('message') }}',
            },{
                // settings
                type: '{{ session('type') }}',
                allow_dismiss: true,
                placement: {
                    from: "top",
                    align: "right"
                },
                offset: 20,
                spacing: 10,
                z_index: 1031,
                delay: 3000,
                timer: 1000,
                animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                }
            });
</script>
@endif
@endsection
