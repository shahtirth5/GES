@extends('layouts.base')
@section('custom-styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/quilljs/css/quill.bubble.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/quilljs/css/quill.snow.css') }}">
<style>
    .ql-editor {
    font-family: inherit;
    margin: 0;
    margin-top: 1px;
    padding: 0;
    width: 100%!important;
    height: 100%!important;
    border-color: white;
    border-width: 0;
    width: 10rem;
    color: #525f7f;
    text-align: left;
    }
    .ql-editor p {
    font-size: .8125rem;
    }
</style>
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="/enrollments"><i class="ni ni-ruler-pencil"></i></a></li>
<li class="breadcrumb-item"><a href="/enrollments">Student Enrollment</a></li>
<li class="breadcrumb-item active" aria-current="page">Pending Enrollments</li>
@endsection
@section('page-content')
<div class="row">
    <div class="col">
        <div class="card">
            <!-- Card header -->
            <div class="card-header">
                <h3 class="mb-0">Student Enrollments</h3>
            </div>
            <!-- Card body -->
            <div class="card-body">
                <div class="table-responsive py-4">
                    <table class="table table-flush" id="questions-list">
                        <thead class="thead-light">
                            <tr>
                                <th> # </th>
                                <th> Subject </th>
                                <th> Chapter </th>
                                <th> Question </th>
                                <th> Option 1 </th>
                                <th> Option 2 </th>
                                <th> Option 3</th>
                                <th> Option 4 </th>
                                <th> Answer </th>
                                <th> Answer Explanation </th>
                                <th> Difficulty Rating </th>
                                <th> Edit </th>
                                <th> Delete </th>
                            </tr>
                        </thead>
                        <tfoot class="tfoot-light">
                            <tr>
                                <th></th>
                                <th> Subject </th>
                                <th> Chapter </th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th> Difficulty Rating </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{{--MODAL SECTION--}}
<!-- DELETE MODAL -->
<div class="modal fade" tabindex="-1" role="dialog" id="deleteModal">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modal-title-default">Delete Enrollment Request</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <form  id="delete_form" method="POST" action="/institute/questions/delete-question/">
                <div class="modal-body">
                    @method('DELETE')
                    @csrf
                    <div class="form-body">
                        <!-- START OF MODAL BODY -->
                        <div class="container">
                            <label><strong>Delete</strong> the question ?</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default  ml-auto" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Edit Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
<div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h6 class="modal-title" id="modal-title-default">Edit Question</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-body">
                <!-- START OF MODAL BODY -->
                <form action="{{url('institute/questions/edit-question-query')}}" method="post" id="edit_question_form">
                    @csrf
                    <div class="container">
                        <input type="hidden" name="question_id" id="question_id">
                        <div class="mb-2">
                            <label for="subject" class="form-control-label">Subject</label>
                            <select name="subject_id" id="subject" class="form-control">
                                @foreach($subjects as $subject)
                                <option value="{{$subject->subject_id}}">{{$subject->subject_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="chapter" class="form-control-label">Chapter</label>
                            <select name="chapter_id" id="chapter" class="form-control">
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="question_text" class="form-control-label">Question</label>
                            <input type="hidden" name="question_text" id="question_text">
                            <div class="richtext" id="question_text_rt"></div>
                        </div>
                        <div class="mb-2">
                            <label for="option_1" class="form-control-label">Option 1</label>
                            <input type="hidden" name="option_1" id="option_1">
                            <div class="richtext" id="option_1_rt"></div>
                        </div>
                        <div class="mb-2">
                            <label for="option_2" class="form-control-label">Option 2</label>
                            <input type="hidden" name="option_2" id="option_2">
                            <div class="richtext" id="option_2_rt"></div>
                        </div>
                        <div class="mb-2">
                            <label for="option_3" class="form-control-label">Option 3</label>
                            <input type="hidden" name="option_3" id="option_3">
                            <div class="richtext" id="option_3_rt"></div>
                        </div>
                        <div class="mb-2">
                            <label for="option_4" class="form-control-label">Option 4</label>
                            <input type="hidden" name="option_4" id="option_4">
                            <div class="richtext" id="option_4_rt"></div>
                        </div>
                        <div class="mb-2">
                            <label for="correct_option" class="form-control-label">Correct Option</label>
                            <select name="correct_option" id="correct_option" class="form-control">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="question_answer_explanation" class="form-control-label">Answer Explanation</label>
                            <input type="hidden" name="question_answer_explanation" id="question_answer_explanation">
                            <div class="richtext" id="question_answer_explanation_rt"></textarea>
                            </div>
                            <div class="mb-2">
                                <label for="question_rating" class="form-control-label">Difficulty Rating</label>
                                <select name="question_rating" id="question_rating" class="form-control">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default  ml-auto" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning" id="edit-question-button">Edit</button>
                    </div>
                </form>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.10.2/katex.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mathquill/0.10.1/mathquill.min.js"></script>
<script src="{{ asset('assets/vendor/quilljs/js/quill.min.js') }}"></script>
{{-- Quill Image Resize --}}
{{-- Image Resize --}}
<script>
    !function(t,e){"object"==typeof exports&&"object"==typeof module?module.exports=e():"function"==typeof define&&define.amd?define([],e):"object"==typeof exports?exports.ImageResize=e():t.ImageResize=e()}(this,function(){return function(t){function e(o){if(n[o])return n[o].exports;var r=n[o]={i:o,l:!1,exports:{}};return t[o].call(r.exports,r,r.exports,e),r.l=!0,r.exports}var n={};return e.m=t,e.c=n,e.i=function(t){return t},e.d=function(t,n,o){e.o(t,n)||Object.defineProperty(t,n,{configurable:!1,enumerable:!0,get:o})},e.n=function(t){var n=t&&t.__esModule?function(){return t.default}:function(){return t};return e.d(n,"a",n),n},e.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},e.p="",e(e.s=38)}([function(t,e){function n(t){var e=typeof t;return null!=t&&("object"==e||"function"==e)}t.exports=n},function(t,e,n){var o=n(22),r="object"==typeof self&&self&&self.Object===Object&&self,i=o||r||Function("return this")();t.exports=i},function(t,e){function n(t){return null!=t&&"object"==typeof t}t.exports=n},function(t,e,n){function o(t){var e=-1,n=null==t?0:t.length;for(this.clear();++e<n;){var o=t[e];this.set(o[0],o[1])}}var r=n(75),i=n(76),a=n(77),s=n(78),u=n(79);o.prototype.clear=r,o.prototype.delete=i,o.prototype.get=a,o.prototype.has=s,o.prototype.set=u,t.exports=o},function(t,e,n){function o(t,e){for(var n=t.length;n--;)if(r(t[n][0],e))return n;return-1}var r=n(8);t.exports=o},function(t,e,n){function o(t){return null==t?void 0===t?u:s:c&&c in Object(t)?i(t):a(t)}var r=n(16),i=n(64),a=n(87),s="[object Null]",u="[object Undefined]",c=r?r.toStringTag:void 0;t.exports=o},function(t,e,n){function o(t,e){var n=t.__data__;return r(e)?n["string"==typeof e?"string":"hash"]:n.map}var r=n(73);t.exports=o},function(t,e,n){var o=n(11),r=o(Object,"create");t.exports=r},function(t,e){function n(t,e){return t===e||t!==t&&e!==e}t.exports=n},function(t,e,n){"use strict";function o(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}n.d(e,"a",function(){return r});var r=function t(e){o(this,t),this.onCreate=function(){},this.onDestroy=function(){},this.onUpdate=function(){},this.overlay=e.overlay,this.img=e.img,this.options=e.options,this.requestUpdate=e.onUpdate}},function(t,e,n){function o(t,e,n){"__proto__"==e&&r?r(t,e,{configurable:!0,enumerable:!0,value:n,writable:!0}):t[e]=n}var r=n(21);t.exports=o},function(t,e,n){function o(t,e){var n=i(t,e);return r(n)?n:void 0}var r=n(48),i=n(65);t.exports=o},function(t,e,n){function o(t){return null!=t&&i(t.length)&&!r(t)}var r=n(13),i=n(30);t.exports=o},function(t,e,n){function o(t){if(!i(t))return!1;var e=r(t);return e==s||e==u||e==a||e==c}var r=n(5),i=n(0),a="[object AsyncFunction]",s="[object Function]",u="[object GeneratorFunction]",c="[object Proxy]";t.exports=o},function(t,e){t.exports=function(t){return t.webpackPolyfill||(t.deprecate=function(){},t.paths=[],t.children||(t.children=[]),Object.defineProperty(t,"loaded",{enumerable:!0,get:function(){return t.l}}),Object.defineProperty(t,"id",{enumerable:!0,get:function(){return t.i}}),t.webpackPolyfill=1),t}},function(t,e,n){var o=n(11),r=n(1),i=o(r,"Map");t.exports=i},function(t,e,n){var o=n(1),r=o.Symbol;t.exports=r},function(t,e){function n(t,e,n){switch(n.length){case 0:return t.call(e);case 1:return t.call(e,n[0]);case 2:return t.call(e,n[0],n[1]);case 3:return t.call(e,n[0],n[1],n[2])}return t.apply(e,n)}t.exports=n},function(t,e,n){function o(t,e,n){(void 0===n||i(t[e],n))&&(void 0!==n||e in t)||r(t,e,n)}var r=n(10),i=n(8);t.exports=o},function(t,e,n){function o(t,e,n,l,f){t!==e&&a(e,function(a,c){if(u(a))f||(f=new r),s(t,e,c,n,o,l,f);else{var p=l?l(t[c],a,c+"",t,e,f):void 0;void 0===p&&(p=a),i(t,c,p)}},c)}var r=n(41),i=n(18),a=n(46),s=n(51),u=n(0),c=n(32);t.exports=o},function(t,e,n){function o(t,e){return a(i(t,e,r),t+"")}var r=n(26),i=n(89),a=n(90);t.exports=o},function(t,e,n){var o=n(11),r=function(){try{var t=o(Object,"defineProperty");return t({},"",{}),t}catch(t){}}();t.exports=r},function(t,e,n){(function(e){var n="object"==typeof e&&e&&e.Object===Object&&e;t.exports=n}).call(e,n(107))},function(t,e,n){var o=n(88),r=o(Object.getPrototypeOf,Object);t.exports=r},function(t,e){function n(t,e){return!!(e=null==e?o:e)&&("number"==typeof t||r.test(t))&&t>-1&&t%1==0&&t<e}var o=9007199254740991,r=/^(?:0|[1-9]\d*)$/;t.exports=n},function(t,e){function n(t){var e=t&&t.constructor;return t===("function"==typeof e&&e.prototype||o)}var o=Object.prototype;t.exports=n},function(t,e){function n(t){return t}t.exports=n},function(t,e,n){var o=n(47),r=n(2),i=Object.prototype,a=i.hasOwnProperty,s=i.propertyIsEnumerable,u=o(function(){return arguments}())?o:function(t){return r(t)&&a.call(t,"callee")&&!s.call(t,"callee")};t.exports=u},function(t,e){var n=Array.isArray;t.exports=n},function(t,e,n){(function(t){var o=n(1),r=n(102),i="object"==typeof e&&e&&!e.nodeType&&e,a=i&&"object"==typeof t&&t&&!t.nodeType&&t,s=a&&a.exports===i,u=s?o.Buffer:void 0,c=u?u.isBuffer:void 0,l=c||r;t.exports=l}).call(e,n(14)(t))},function(t,e){function n(t){return"number"==typeof t&&t>-1&&t%1==0&&t<=o}var o=9007199254740991;t.exports=n},function(t,e,n){var o=n(49),r=n(54),i=n(86),a=i&&i.isTypedArray,s=a?r(a):o;t.exports=s},function(t,e,n){function o(t){return a(t)?r(t,!0):i(t)}var r=n(43),i=n(50),a=n(12);t.exports=o},function(t,e,n){"use strict";e.a={modules:["DisplaySize","Toolbar","Resize"],overlayStyles:{position:"absolute",boxSizing:"border-box",border:"1px dashed #444"},handleStyles:{position:"absolute",height:"12px",width:"12px",backgroundColor:"white",border:"1px solid #777",boxSizing:"border-box",opacity:"0.80"},displayStyles:{position:"absolute",font:"12px/1.0 Arial, Helvetica, sans-serif",padding:"4px 8px",textAlign:"center",backgroundColor:"white",color:"#333",border:"1px solid #777",boxSizing:"border-box",opacity:"0.80",cursor:"default"},toolbarStyles:{position:"absolute",top:"-12px",right:"0",left:"0",height:"0",minWidth:"100px",font:"12px/1.0 Arial, Helvetica, sans-serif",textAlign:"center",color:"#333",boxSizing:"border-box",cursor:"default"},toolbarButtonStyles:{display:"inline-block",width:"24px",height:"24px",background:"white",border:"1px solid #999",verticalAlign:"middle"},toolbarButtonSvgStyles:{fill:"#444",stroke:"#444",strokeWidth:"2"}}},function(t,e,n){"use strict";function o(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}function r(t,e){if(!t)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!e||"object"!=typeof e&&"function"!=typeof e?t:e}function i(t,e){if("function"!=typeof e&&null!==e)throw new TypeError("Super expression must either be null or a function, not "+typeof e);t.prototype=Object.create(e&&e.prototype,{constructor:{value:t,enumerable:!1,writable:!0,configurable:!0}}),e&&(Object.setPrototypeOf?Object.setPrototypeOf(t,e):t.__proto__=e)}var a=n(9);n.d(e,"a",function(){return s});var s=function(t){function e(){var t,n,i,a;o(this,e);for(var s=arguments.length,u=Array(s),c=0;c<s;c++)u[c]=arguments[c];return n=i=r(this,(t=e.__proto__||Object.getPrototypeOf(e)).call.apply(t,[this].concat(u))),i.onCreate=function(){i.display=document.createElement("div"),Object.assign(i.display.style,i.options.displayStyles),i.overlay.appendChild(i.display)},i.onDestroy=function(){},i.onUpdate=function(){if(i.display&&i.img){var t=i.getCurrentSize();if(i.display.innerHTML=t.join(" &times; "),t[0]>120&&t[1]>30)Object.assign(i.display.style,{right:"4px",bottom:"4px",left:"auto"});else if("right"==i.img.style.float){var e=i.display.getBoundingClientRect();Object.assign(i.display.style,{right:"auto",bottom:"-"+(e.height+4)+"px",left:"-"+(e.width+4)+"px"})}else{var n=i.display.getBoundingClientRect();Object.assign(i.display.style,{right:"-"+(n.width+4)+"px",bottom:"-"+(n.height+4)+"px",left:"auto"})}}},i.getCurrentSize=function(){return[i.img.width,Math.round(i.img.width/i.img.naturalWidth*i.img.naturalHeight)]},a=n,r(i,a)}return i(e,t),e}(a.a)},function(t,e,n){"use strict";function o(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}function r(t,e){if(!t)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!e||"object"!=typeof e&&"function"!=typeof e?t:e}function i(t,e){if("function"!=typeof e&&null!==e)throw new TypeError("Super expression must either be null or a function, not "+typeof e);t.prototype=Object.create(e&&e.prototype,{constructor:{value:t,enumerable:!1,writable:!0,configurable:!0}}),e&&(Object.setPrototypeOf?Object.setPrototypeOf(t,e):t.__proto__=e)}var a=n(9);n.d(e,"a",function(){return s});var s=function(t){function e(){var t,n,i,a;o(this,e);for(var s=arguments.length,u=Array(s),c=0;c<s;c++)u[c]=arguments[c];return n=i=r(this,(t=e.__proto__||Object.getPrototypeOf(e)).call.apply(t,[this].concat(u))),i.onCreate=function(){i.boxes=[],i.addBox("nwse-resize"),i.addBox("nesw-resize"),i.addBox("nwse-resize"),i.addBox("nesw-resize"),i.positionBoxes()},i.onDestroy=function(){i.setCursor("")},i.positionBoxes=function(){var t=-parseFloat(i.options.handleStyles.width)/2+"px",e=-parseFloat(i.options.handleStyles.height)/2+"px";[{left:t,top:e},{right:t,top:e},{right:t,bottom:e},{left:t,bottom:e}].forEach(function(t,e){Object.assign(i.boxes[e].style,t)})},i.addBox=function(t){var e=document.createElement("div");Object.assign(e.style,i.options.handleStyles),e.style.cursor=t,e.style.width=i.options.handleStyles.width+"px",e.style.height=i.options.handleStyles.height+"px",e.addEventListener("mousedown",i.handleMousedown,!1),i.overlay.appendChild(e),i.boxes.push(e)},i.handleMousedown=function(t){i.dragBox=t.target,i.dragStartX=t.clientX,i.preDragWidth=i.img.width||i.img.naturalWidth,i.setCursor(i.dragBox.style.cursor),document.addEventListener("mousemove",i.handleDrag,!1),document.addEventListener("mouseup",i.handleMouseup,!1)},i.handleMouseup=function(){i.setCursor(""),document.removeEventListener("mousemove",i.handleDrag),document.removeEventListener("mouseup",i.handleMouseup)},i.handleDrag=function(t){if(i.img){var e=t.clientX-i.dragStartX;i.dragBox===i.boxes[0]||i.dragBox===i.boxes[3]?i.img.width=Math.round(i.preDragWidth-e):i.img.width=Math.round(i.preDragWidth+e),i.requestUpdate()}},i.setCursor=function(t){[document.body,i.img].forEach(function(e){e.style.cursor=t})},a=n,r(i,a)}return i(e,t),e}(a.a)},function(t,e,n){"use strict";function o(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}function r(t,e){if(!t)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!e||"object"!=typeof e&&"function"!=typeof e?t:e}function i(t,e){if("function"!=typeof e&&null!==e)throw new TypeError("Super expression must either be null or a function, not "+typeof e);t.prototype=Object.create(e&&e.prototype,{constructor:{value:t,enumerable:!1,writable:!0,configurable:!0}}),e&&(Object.setPrototypeOf?Object.setPrototypeOf(t,e):t.__proto__=e)}var a=n(105),s=n.n(a),u=n(104),c=n.n(u),l=n(106),f=n.n(l),p=n(9);n.d(e,"a",function(){return b});var d=window.Quill.imports.parchment,h=new d.Attributor.Style("float","float"),y=new d.Attributor.Style("margin","margin"),v=new d.Attributor.Style("display","display"),b=function(t){function e(){var t,n,i,a;o(this,e);for(var u=arguments.length,l=Array(u),p=0;p<u;p++)l[p]=arguments[p];return n=i=r(this,(t=e.__proto__||Object.getPrototypeOf(e)).call.apply(t,[this].concat(l))),i.onCreate=function(){i.toolbar=document.createElement("div"),Object.assign(i.toolbar.style,i.options.toolbarStyles),i.overlay.appendChild(i.toolbar),i._defineAlignments(),i._addToolbarButtons()},i.onDestroy=function(){},i.onUpdate=function(){},i._defineAlignments=function(){i.alignments=[{icon:s.a,apply:function(){v.add(i.img,"inline"),h.add(i.img,"left"),y.add(i.img,"0 1em 1em 0")},isApplied:function(){return"left"==h.value(i.img)}},{icon:c.a,apply:function(){v.add(i.img,"block"),h.remove(i.img),y.add(i.img,"auto")},isApplied:function(){return"auto"==y.value(i.img)}},{icon:f.a,apply:function(){v.add(i.img,"inline"),h.add(i.img,"right"),y.add(i.img,"0 0 1em 1em")},isApplied:function(){return"right"==h.value(i.img)}}]},i._addToolbarButtons=function(){var t=[];i.alignments.forEach(function(e,n){var o=document.createElement("span");t.push(o),o.innerHTML=e.icon,o.addEventListener("click",function(){t.forEach(function(t){return t.style.filter=""}),e.isApplied()?(h.remove(i.img),y.remove(i.img),v.remove(i.img)):(i._selectButton(o),e.apply()),i.requestUpdate()}),Object.assign(o.style,i.options.toolbarButtonStyles),n>0&&(o.style.borderLeftWidth="0"),Object.assign(o.children[0].style,i.options.toolbarButtonSvgStyles),e.isApplied()&&i._selectButton(o),i.toolbar.appendChild(o)})},i._selectButton=function(t){t.style.filter="invert(20%)"},a=n,r(i,a)}return i(e,t),e}(p.a)},function(t,e,n){var o=n(17),r=n(20),i=n(63),a=n(101),s=r(function(t){return t.push(void 0,i),o(a,void 0,t)});t.exports=s},function(t,e,n){"use strict";function o(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}Object.defineProperty(e,"__esModule",{value:!0});var r=n(37),i=n.n(r),a=n(33),s=n(34),u=n(36),c=n(35),l={DisplaySize:s.a,Toolbar:u.a,Resize:c.a},f=function t(e){var n=this,r=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};o(this,t),this.initializeModules=function(){n.removeModules(),n.modules=n.moduleClasses.map(function(t){return new(l[t]||t)(n)}),n.modules.forEach(function(t){t.onCreate()}),n.onUpdate()},this.onUpdate=function(){n.repositionElements(),n.modules.forEach(function(t){t.onUpdate()})},this.removeModules=function(){n.modules.forEach(function(t){t.onDestroy()}),n.modules=[]},this.handleClick=function(t){if(t.target&&t.target.tagName&&"IMG"===t.target.tagName.toUpperCase()){if(n.img===t.target)return;n.img&&n.hide(),n.show(t.target)}else n.img&&n.hide()},this.show=function(t){n.img=t,n.showOverlay(),n.initializeModules()},this.showOverlay=function(){n.overlay&&n.hideOverlay(),n.quill.setSelection(null),n.setUserSelect("none"),document.addEventListener("keyup",n.checkImage,!0),n.quill.root.addEventListener("input",n.checkImage,!0),n.overlay=document.createElement("div"),Object.assign(n.overlay.style,n.options.overlayStyles),n.quill.root.parentNode.appendChild(n.overlay),n.repositionElements()},this.hideOverlay=function(){n.overlay&&(n.quill.root.parentNode.removeChild(n.overlay),n.overlay=void 0,document.removeEventListener("keyup",n.checkImage),n.quill.root.removeEventListener("input",n.checkImage),n.setUserSelect(""))},this.repositionElements=function(){if(n.overlay&&n.img){var t=n.quill.root.parentNode,e=n.img.getBoundingClientRect(),o=t.getBoundingClientRect();Object.assign(n.overlay.style,{left:e.left-o.left-1+t.scrollLeft+"px",top:e.top-o.top+t.scrollTop+"px",width:e.width+"px",height:e.height+"px"})}},this.hide=function(){n.hideOverlay(),n.removeModules(),n.img=void 0},this.setUserSelect=function(t){["userSelect","mozUserSelect","webkitUserSelect","msUserSelect"].forEach(function(e){n.quill.root.style[e]=t,document.documentElement.style[e]=t})},this.checkImage=function(t){n.img&&(46!=t.keyCode&&8!=t.keyCode||window.Quill.find(n.img).deleteAt(0),n.hide())},this.quill=e;var s=!1;r.modules&&(s=r.modules.slice()),this.options=i()({},r,a.a),s!==!1&&(this.options.modules=s),document.execCommand("enableObjectResizing",!1,"false"),this.quill.root.addEventListener("click",this.handleClick,!1),this.quill.root.parentNode.style.position=this.quill.root.parentNode.style.position||"relative",this.moduleClasses=this.options.modules,console.log("this.options.modules",this.options.modules),this.modules=[]};e.default=f,window.Quill&&window.Quill.register("modules/imageResize",f)},function(t,e,n){function o(t){var e=-1,n=null==t?0:t.length;for(this.clear();++e<n;){var o=t[e];this.set(o[0],o[1])}}var r=n(66),i=n(67),a=n(68),s=n(69),u=n(70);o.prototype.clear=r,o.prototype.delete=i,o.prototype.get=a,o.prototype.has=s,o.prototype.set=u,t.exports=o},function(t,e,n){function o(t){var e=-1,n=null==t?0:t.length;for(this.clear();++e<n;){var o=t[e];this.set(o[0],o[1])}}var r=n(80),i=n(81),a=n(82),s=n(83),u=n(84);o.prototype.clear=r,o.prototype.delete=i,o.prototype.get=a,o.prototype.has=s,o.prototype.set=u,t.exports=o},function(t,e,n){function o(t){var e=this.__data__=new r(t);this.size=e.size}var r=n(3),i=n(92),a=n(93),s=n(94),u=n(95),c=n(96);o.prototype.clear=i,o.prototype.delete=a,o.prototype.get=s,o.prototype.has=u,o.prototype.set=c,t.exports=o},function(t,e,n){var o=n(1),r=o.Uint8Array;t.exports=r},function(t,e,n){function o(t,e){var n=a(t),o=!n&&i(t),l=!n&&!o&&s(t),p=!n&&!o&&!l&&c(t),d=n||o||l||p,h=d?r(t.length,String):[],y=h.length;for(var v in t)!e&&!f.call(t,v)||d&&("length"==v||l&&("offset"==v||"parent"==v)||p&&("buffer"==v||"byteLength"==v||"byteOffset"==v)||u(v,y))||h.push(v);return h}var r=n(53),i=n(27),a=n(28),s=n(29),u=n(24),c=n(31),l=Object.prototype,f=l.hasOwnProperty;t.exports=o},function(t,e,n){function o(t,e,n){var o=t[e];s.call(t,e)&&i(o,n)&&(void 0!==n||e in t)||r(t,e,n)}var r=n(10),i=n(8),a=Object.prototype,s=a.hasOwnProperty;t.exports=o},function(t,e,n){var o=n(0),r=Object.create,i=function(){function t(){}return function(e){if(!o(e))return{};if(r)return r(e);t.prototype=e;var n=new t;return t.prototype=void 0,n}}();t.exports=i},function(t,e,n){var o=n(62),r=o();t.exports=r},function(t,e,n){function o(t){return i(t)&&r(t)==a}var r=n(5),i=n(2),a="[object Arguments]";t.exports=o},function(t,e,n){function o(t){return!(!a(t)||i(t))&&(r(t)?d:u).test(s(t))}var r=n(13),i=n(74),a=n(0),s=n(97),u=/^\[object .+?Constructor\]$/,c=Function.prototype,l=Object.prototype,f=c.toString,p=l.hasOwnProperty,d=RegExp("^"+f.call(p).replace(/[\\^$.*+?()[\]{}|]/g,"\\$&").replace(/hasOwnProperty|(function).*?(?=\\\()| for .+?(?=\\\])/g,"$1.*?")+"$");t.exports=o},function(t,e,n){function o(t){return a(t)&&i(t.length)&&!!s[r(t)]}var r=n(5),i=n(30),a=n(2),s={};s["[object Float32Array]"]=s["[object Float64Array]"]=s["[object Int8Array]"]=s["[object Int16Array]"]=s["[object Int32Array]"]=s["[object Uint8Array]"]=s["[object Uint8ClampedArray]"]=s["[object Uint16Array]"]=s["[object Uint32Array]"]=!0,s["[object Arguments]"]=s["[object Array]"]=s["[object ArrayBuffer]"]=s["[object Boolean]"]=s["[object DataView]"]=s["[object Date]"]=s["[object Error]"]=s["[object Function]"]=s["[object Map]"]=s["[object Number]"]=s["[object Object]"]=s["[object RegExp]"]=s["[object Set]"]=s["[object String]"]=s["[object WeakMap]"]=!1,t.exports=o},function(t,e,n){function o(t){if(!r(t))return a(t);var e=i(t),n=[];for(var o in t)("constructor"!=o||!e&&u.call(t,o))&&n.push(o);return n}var r=n(0),i=n(25),a=n(85),s=Object.prototype,u=s.hasOwnProperty;t.exports=o},function(t,e,n){function o(t,e,n,o,g,x,m){var _=t[n],j=e[n],w=m.get(j);if(w)return void r(t,n,w);var O=x?x(_,j,n+"",t,e,m):void 0,S=void 0===O;if(S){var E=l(j),A=!E&&p(j),z=!E&&!A&&v(j);O=j,E||A||z?l(_)?O=_:f(_)?O=s(_):A?(S=!1,O=i(j,!0)):z?(S=!1,O=a(j,!0)):O=[]:y(j)||c(j)?(O=_,c(_)?O=b(_):(!h(_)||o&&d(_))&&(O=u(j))):S=!1}S&&(m.set(j,O),g(O,j,o,x,m),m.delete(j)),r(t,n,O)}var r=n(18),i=n(56),a=n(57),s=n(58),u=n(71),c=n(27),l=n(28),f=n(99),p=n(29),d=n(13),h=n(0),y=n(100),v=n(31),b=n(103);t.exports=o},function(t,e,n){var o=n(98),r=n(21),i=n(26),a=r?function(t,e){return r(t,"toString",{configurable:!0,enumerable:!1,value:o(e),writable:!0})}:i;t.exports=a},function(t,e){function n(t,e){for(var n=-1,o=Array(t);++n<t;)o[n]=e(n);return o}t.exports=n},function(t,e){function n(t){return function(e){return t(e)}}t.exports=n},function(t,e,n){function o(t){var e=new t.constructor(t.byteLength);return new r(e).set(new r(t)),e}var r=n(42);t.exports=o},function(t,e,n){(function(t){function o(t,e){if(e)return t.slice();var n=t.length,o=c?c(n):new t.constructor(n);return t.copy(o),o}var r=n(1),i="object"==typeof e&&e&&!e.nodeType&&e,a=i&&"object"==typeof t&&t&&!t.nodeType&&t,s=a&&a.exports===i,u=s?r.Buffer:void 0,c=u?u.allocUnsafe:void 0;t.exports=o}).call(e,n(14)(t))},function(t,e,n){function o(t,e){var n=e?r(t.buffer):t.buffer;return new t.constructor(n,t.byteOffset,t.length)}var r=n(55);t.exports=o},function(t,e){function n(t,e){var n=-1,o=t.length;for(e||(e=Array(o));++n<o;)e[n]=t[n];return e}t.exports=n},function(t,e,n){function o(t,e,n,o){var a=!n;n||(n={});for(var s=-1,u=e.length;++s<u;){var c=e[s],l=o?o(n[c],t[c],c,n,t):void 0;void 0===l&&(l=t[c]),a?i(n,c,l):r(n,c,l)}return n}var r=n(44),i=n(10);t.exports=o},function(t,e,n){var o=n(1),r=o["__core-js_shared__"];t.exports=r},function(t,e,n){function o(t){return r(function(e,n){var o=-1,r=n.length,a=r>1?n[r-1]:void 0,s=r>2?n[2]:void 0;for(a=t.length>3&&"function"==typeof a?(r--,a):void 0,s&&i(n[0],n[1],s)&&(a=r<3?void 0:a,r=1),e=Object(e);++o<r;){var u=n[o];u&&t(e,u,o,a)}return e})}var r=n(20),i=n(72);t.exports=o},function(t,e){function n(t){return function(e,n,o){for(var r=-1,i=Object(e),a=o(e),s=a.length;s--;){var u=a[t?s:++r];if(n(i[u],u,i)===!1)break}return e}}t.exports=n},function(t,e,n){function o(t,e,n,a,s,u){return i(t)&&i(e)&&(u.set(e,t),r(t,e,void 0,o,u),u.delete(e)),t}var r=n(19),i=n(0);t.exports=o},function(t,e,n){function o(t){var e=a.call(t,u),n=t[u];try{t[u]=void 0}catch(t){}var o=s.call(t);return e?t[u]=n:delete t[u],o}var r=n(16),i=Object.prototype,a=i.hasOwnProperty,s=i.toString,u=r?r.toStringTag:void 0;t.exports=o},function(t,e){function n(t,e){return null==t?void 0:t[e]}t.exports=n},function(t,e,n){function o(){this.__data__=r?r(null):{},this.size=0}var r=n(7);t.exports=o},function(t,e){function n(t){var e=this.has(t)&&delete this.__data__[t];return this.size-=e?1:0,e}t.exports=n},function(t,e,n){function o(t){var e=this.__data__;if(r){var n=e[t];return n===i?void 0:n}return s.call(e,t)?e[t]:void 0}var r=n(7),i="__lodash_hash_undefined__",a=Object.prototype,s=a.hasOwnProperty;t.exports=o},function(t,e,n){function o(t){var e=this.__data__;return r?void 0!==e[t]:a.call(e,t)}var r=n(7),i=Object.prototype,a=i.hasOwnProperty;t.exports=o},function(t,e,n){function o(t,e){var n=this.__data__;return this.size+=this.has(t)?0:1,n[t]=r&&void 0===e?i:e,this}var r=n(7),i="__lodash_hash_undefined__";t.exports=o},function(t,e,n){function o(t){return"function"!=typeof t.constructor||a(t)?{}:r(i(t))}var r=n(45),i=n(23),a=n(25);t.exports=o},function(t,e,n){function o(t,e,n){if(!s(n))return!1;var o=typeof e;return!!("number"==o?i(n)&&a(e,n.length):"string"==o&&e in n)&&r(n[e],t)}var r=n(8),i=n(12),a=n(24),s=n(0);t.exports=o},function(t,e){function n(t){var e=typeof t;return"string"==e||"number"==e||"symbol"==e||"boolean"==e?"__proto__"!==t:null===t}t.exports=n},function(t,e,n){function o(t){return!!i&&i in t}var r=n(60),i=function(){var t=/[^.]+$/.exec(r&&r.keys&&r.keys.IE_PROTO||"");return t?"Symbol(src)_1."+t:""}();t.exports=o},function(t,e){function n(){this.__data__=[],this.size=0}t.exports=n},function(t,e,n){function o(t){var e=this.__data__,n=r(e,t);return!(n<0)&&(n==e.length-1?e.pop():a.call(e,n,1),--this.size,!0)}var r=n(4),i=Array.prototype,a=i.splice;t.exports=o},function(t,e,n){function o(t){var e=this.__data__,n=r(e,t);return n<0?void 0:e[n][1]}var r=n(4);t.exports=o},function(t,e,n){function o(t){return r(this.__data__,t)>-1}var r=n(4);t.exports=o},function(t,e,n){function o(t,e){var n=this.__data__,o=r(n,t);return o<0?(++this.size,n.push([t,e])):n[o][1]=e,this}var r=n(4);t.exports=o},function(t,e,n){function o(){this.size=0,this.__data__={hash:new r,map:new(a||i),string:new r}}var r=n(39),i=n(3),a=n(15);t.exports=o},function(t,e,n){function o(t){var e=r(this,t).delete(t);return this.size-=e?1:0,e}var r=n(6);t.exports=o},function(t,e,n){function o(t){return r(this,t).get(t)}var r=n(6);t.exports=o},function(t,e,n){function o(t){return r(this,t).has(t)}var r=n(6);t.exports=o},function(t,e,n){function o(t,e){var n=r(this,t),o=n.size;return n.set(t,e),this.size+=n.size==o?0:1,this}var r=n(6);t.exports=o},function(t,e){function n(t){var e=[];if(null!=t)for(var n in Object(t))e.push(n);return e}t.exports=n},function(t,e,n){(function(t){var o=n(22),r="object"==typeof e&&e&&!e.nodeType&&e,i=r&&"object"==typeof t&&t&&!t.nodeType&&t,a=i&&i.exports===r,s=a&&o.process,u=function(){try{return s&&s.binding&&s.binding("util")}catch(t){}}();t.exports=u}).call(e,n(14)(t))},function(t,e){function n(t){return r.call(t)}var o=Object.prototype,r=o.toString;t.exports=n},function(t,e){function n(t,e){return function(n){return t(e(n))}}t.exports=n},function(t,e,n){function o(t,e,n){return e=i(void 0===e?t.length-1:e,0),function(){for(var o=arguments,a=-1,s=i(o.length-e,0),u=Array(s);++a<s;)u[a]=o[e+a];a=-1;for(var c=Array(e+1);++a<e;)c[a]=o[a];return c[e]=n(u),r(t,this,c)}}var r=n(17),i=Math.max;t.exports=o},function(t,e,n){var o=n(52),r=n(91),i=r(o);t.exports=i},function(t,e){function n(t){var e=0,n=0;return function(){var a=i(),s=r-(a-n);if(n=a,s>0){if(++e>=o)return arguments[0]}else e=0;return t.apply(void 0,arguments)}}var o=800,r=16,i=Date.now;t.exports=n},function(t,e,n){function o(){this.__data__=new r,this.size=0}var r=n(3);t.exports=o},function(t,e){function n(t){var e=this.__data__,n=e.delete(t);return this.size=e.size,n}t.exports=n},function(t,e){function n(t){return this.__data__.get(t)}t.exports=n},function(t,e){function n(t){return this.__data__.has(t)}t.exports=n},function(t,e,n){function o(t,e){var n=this.__data__;if(n instanceof r){var o=n.__data__;if(!i||o.length<s-1)return o.push([t,e]),this.size=++n.size,this;n=this.__data__=new a(o)}return n.set(t,e),this.size=n.size,this}var r=n(3),i=n(15),a=n(40),s=200;t.exports=o},function(t,e){function n(t){if(null!=t){try{return r.call(t)}catch(t){}try{return t+""}catch(t){}}return""}var o=Function.prototype,r=o.toString;t.exports=n},function(t,e){function n(t){return function(){return t}}t.exports=n},function(t,e,n){function o(t){return i(t)&&r(t)}var r=n(12),i=n(2);t.exports=o},function(t,e,n){function o(t){if(!a(t)||r(t)!=s)return!1;var e=i(t);if(null===e)return!0;var n=f.call(e,"constructor")&&e.constructor;return"function"==typeof n&&n instanceof n&&l.call(n)==p}var r=n(5),i=n(23),a=n(2),s="[object Object]",u=Function.prototype,c=Object.prototype,l=u.toString,f=c.hasOwnProperty,p=l.call(Object);t.exports=o},function(t,e,n){var o=n(19),r=n(61),i=r(function(t,e,n,r){o(t,e,n,r)});t.exports=i},function(t,e){function n(){return!1}t.exports=n},function(t,e,n){function o(t){return r(t,i(t))}var r=n(59),i=n(32);t.exports=o},function(t,e){t.exports='<svg viewbox="0 0 18 18">\n  <line class="ql-stroke" x1="15" x2="3" y1="9" y2="9"></line>\n  <line class="ql-stroke" x1="14" x2="4" y1="14" y2="14"></line>\n  <line class="ql-stroke" x1="12" x2="6" y1="4" y2="4"></line>\n</svg>'},function(t,e){t.exports='<svg viewbox="0 0 18 18">\n  <line class="ql-stroke" x1="3" x2="15" y1="9" y2="9"></line>\n  <line class="ql-stroke" x1="3" x2="13" y1="14" y2="14"></line>\n  <line class="ql-stroke" x1="3" x2="9" y1="4" y2="4"></line>\n</svg>'},function(t,e){t.exports='<svg viewbox="0 0 18 18">\n  <line class="ql-stroke" x1="15" x2="3" y1="9" y2="9"></line>\n  <line class="ql-stroke" x1="15" x2="5" y1="14" y2="14"></line>\n  <line class="ql-stroke" x1="15" x2="9" y1="4" y2="4"></line>\n</svg>'},function(t,e){var n;n=function(){return this}();try{n=n||Function("return this")()||(0,eval)("this")}catch(t){"object"==typeof window&&(n=window)}t.exports=n}])});
</script>
{{-- MathQuill4Quill --}}
<script>
    /* eslint-env browser */

    window.mathquill4quill = function(dependencies) {
    dependencies = dependencies || {};

    const Quill = dependencies.Quill || window.Quill;
    const MathQuill = dependencies.MathQuill || window.MathQuill;
    const katex = dependencies.katex || window.katex;

    function insertAfter(newNode, referenceNode) {
        referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
    }

    function enableMathQuillFormulaAuthoring(quill, options) {
        options = options || {};

        function areAllDependenciesMet() {
        if (!Quill) {
            console.log("Quill.js not loaded"); // eslint-disable-line no-console
            return false;
        }

        if (!MathQuill) {
            console.log("MathQuill.js not loaded"); // eslint-disable-line no-console
            return false;
        }

        if (!katex) {
            console.log("katex.js not loaded"); // eslint-disable-line no-console
            return false;
        }

        if (!quill.options.modules.formula) {
            console.log("Formula module not enabled"); // eslint-disable-line no-console
            return false;
        }

        if (!MutationObserver) {
            console.log("MutationObserver not defined"); // eslint-disable-line no-console
            return false;
        }

        return true;
        }

        function getTooltip() {
        return quill.container.getElementsByClassName("ql-tooltip")[0];
        }

        function getSaveButton() {
        const tooltip = getTooltip();
        return tooltip.getElementsByClassName("ql-action")[0];
        }

        function getLatexInput() {
        const tooltip = getTooltip();
        return tooltip.getElementsByTagName("input")[0];
        }

        function newMathquillInput() {
        const autofocus = options.autofocus == null ? true : options.autofocus;
        let mqInput = null;
        let mqField = null;
        let latexInputStyle = null;

        function applyMathquillInputStyles(mqInput) {
            mqInput.style.border = "1px solid #ccc";
            mqInput.style.fontSize = "13px";
            mqInput.style.minHeight = "26px";
            mqInput.style.margin = "0px";
            mqInput.style.padding = "3px 5px";
            mqInput.style.width = "170px";
        }

        function applyLatexInputStyles(latexInput) {
            latexInput.setAttribute(
            "style",
            "visibility:hidden;padding:0px;border:0px;width:0px;"
            );
        }

        function syncMathquillToQuill(latexInput, saveButton) {
            const mqField = MathQuill.getInterface(2).MathField(mqInput, {
            handlers: {
                edit() {
                latexInput.value = mqField.latex();
                },
                enter() {
                saveButton.click();
                }
            }
            });

            return mqField;
        }

        function autofocusFormulaField(mqField) {
            if (!autofocus) {
            return;
            }

            window.setTimeout(() => mqField.focus(), 1);
        }

        return {
            render() {
            if (mqInput != null) {
                return;
            }

            const latexInput = getLatexInput();
            const saveButton = getSaveButton();

            mqInput = document.createElement("span");
            applyMathquillInputStyles(mqInput);

            latexInputStyle = latexInput.style.all;
            applyLatexInputStyles(latexInput);

            mqField = syncMathquillToQuill(latexInput, saveButton);
            autofocusFormulaField(mqField);

            insertAfter(mqInput, latexInput);
            return mqField;
            },
            destroy() {
            if (mqInput == null) {
                return;
            }

            const latexInput = getLatexInput();

            latexInput.setAttribute("style", latexInputStyle);

            mqInput.remove();
            mqInput = null;
            }
        };
        }

        function newOperatorButtons() {
        const operators = options.operators || [];
        let container = null;

        function applyOperatorButtonStyles(button) {
            button.style.margin = "5px";
            button.style.width = "50px";
            button.style.height = "50px";
            button.style.backgroundColor = "#ffffff";
            button.style.borderColor = "#000000";
            button.style.borderRadius = "7px";
            button.style.borderWidth = "2px";
        }

        function applyOperatorContainerStyles(container) {
            container.style.display = "flex";
            container.style.alignItems = "center";
        }

        function createOperatorButton(element, mqField) {
            const displayOperator = element[0];
            const operator = element[1];

            const button = document.createElement("button");
            button.setAttribute("type", "button");

            katex.render(displayOperator, button, {
            throwOnError: false
            });
            button.onclick = () => {
            mqField.cmd(operator);
            mqField.focus();
            };

            return button;
        }

        return {
            render(mqField) {
            if (container != null || operators.length === 0) {
                return;
            }

            const tooltip = getTooltip();

            container = document.createElement("div");
            applyOperatorContainerStyles(container);

            operators.forEach(element => {
                const button = createOperatorButton(element, mqField);
                applyOperatorButtonStyles(button);
                container.appendChild(button);
            });

            tooltip.appendChild(container);
            },
            destroy() {
            if (container == null) {
                return;
            }

            container.remove();
            container = null;
            }
        };
        }

        if (!areAllDependenciesMet()) {
        return;
        }

        const tooltip = getTooltip();

        const mqInput = newMathquillInput();
        const operatorButtons = newOperatorButtons();

        const observer = new MutationObserver(() => {
        const isFormulaTooltipActive =
            !tooltip.classList.contains("ql-hidden") &&
            tooltip.attributes["data-mode"] &&
            tooltip.attributes["data-mode"].value === "formula";

        if (isFormulaTooltipActive) {
            const mqField = mqInput.render();
            operatorButtons.render(mqField);
        } else {
            mqInput.destroy();
            operatorButtons.destroy();
        }
        });

        observer.observe(tooltip, {
        attributes: true,
        attributeFilter: ["class", "data-mode"]
        });
    }

    return enableMathQuillFormulaAuthoring;
    };

    // for backwards compatibility with prototype-based API
    if (window.Quill) {
    window.Quill.prototype.enableMathQuillFormulaAuthoring = function(options) {
        window.mathquill4quill()(this, options);
    };
    }
</script>
<script>
    var containers = document.querySelectorAll('.richtext');
    let toolBarOptions = [
        ['bold', 'italic', 'underline', 'strike'],
        [{'script': 'sub'}, {'script': 'super'}],
        [{ 'color': [] }, { 'background': [] }],
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }, { 'size': ['small', false, 'large', 'huge'] }, { 'font': [] }],
        ['blockquote', 'code-block'],
        [{'list': 'ordered'}, {'list': 'bullet'}, { 'align': [] }],
        ['link', 'image', 'video', 'formula'],
        ['clean']
    ]

    var editors = Array.from(containers).map(function(container) {
        let quill = new Quill(container, {
            modules: {
                formula: true,
                toolbar: toolBarOptions,
                imageResize: {
                    displaySize: true
                }
            },
            formats: [
                'bold', 'italic', 'underline', 'strike', 'script', 'color', 'background', 'header', 'size', 'font', 'blockquote', 'list','align', 'link', 'image', 'video', 'formula', 'clean'
            ],
            theme: 'snow'
        });
        var enableMathQuillFormulaAuthoring = mathquill4quill();
        enableMathQuillFormulaAuthoring(quill,  {
            operators: [["\\sqrt[n]{x}", "\\nthroot"], ["\\frac{x}{y}","\\frac"], ["\int_{}^{}", "\\int"]]
        });
        return quill;
    });

    var getChapters = function(subject_id, chapter_name) {
        $("#chapter").html("");
        $.ajax({
            type: 'GET',
            url: '/get-chapters/' + subject_id,
            success: function(response) {
                response = JSON.parse(response);
                response.forEach(function (item) {
                    let tag;
                    if(item.chapter_name == chapter_name) {
                        tag = "<option value=" + item.chapter_id + " selected>" + item.chapter_name +"</option>";
                    } else {
                        tag = "<option value=" + item.chapter_id + ">" + item.chapter_name +"</option>";
                    }

                    $("#chapter").append(tag);
                });
            }
        })
    };


    $('#subject').change(function(event) {
        let subject_id = $(this).val();
        $("#chapter").html("");
        getChapters(subject_id, "");
    });

</script>
<script>
    let questionTable = $('#questions-list');
    let questionDataTable = questionTable.DataTable({
        initComplete: function() {
            this.api().columns([1,2,10]).every( function () {
            var column = this;
            var select = $('<select class="form-control"><option value=""></option></select>')
                .appendTo( $(column.footer()).empty() )
                .on( 'change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                    );

                    column
                        .search( val ? '^'+val+'$' : '', true, false )
                        .draw();
                } );

            column.data().unique().sort().each( function ( d, j ) {
                select.append( '<option value="'+d+'">'+d+'</option>' )
            } );
        } );
        },
        processing: true,
        serverSide: true,
        select: true,
        ajax:  '/institute/questions/get-questions',
        columns: [
            {data: 'question_id'},
            {data: 'subject'},
            {data: 'chapter'},
            {data: 'question_text', "width" : '100%'},
            {data: 'option_1'},
            {data: 'option_2'},
            {data: 'option_3'},
            {data: 'option_4'},
            {data: 'correct_option'},
            {data: 'question_explanation'},
            {data: 'question_rating'},
            {data: 'edit'},
            {data: 'delete'}
        ],
        language: {paginate: {previous: "<i class='fa fa-angle-left'>", next: "<i class='fa fa-angle-right'>"}}
    });

    questionTable.on('click', '.edit', function() {
        let question_id = $(this).attr('data-question-id');
        var data = questionDataTable.row($(this).parents('tr')).data();
        $("#subject option").removeAttr('selected');
        $("#subject option:contains("+ data.subject.trim() +")").attr('selected', 'selected');
        let subject_id = $('#subject').val();
        getChapters(subject_id, data.chapter);
        quillJsAddText(data.question_text, $("#question_text_rt")[0].__quill);
        quillJsAddText(data.option_1, $("#option_1_rt")[0].__quill);
        quillJsAddText(data.option_2, $("#option_2_rt")[0].__quill);
        quillJsAddText(data.option_3, $("#option_3_rt")[0].__quill);
        quillJsAddText(data.option_4, $("#option_4_rt")[0].__quill);
        quillJsAddText(data.question_explanation, $("#question_answer_explanation_rt")[0].__quill);
        $("#correct_option option:contains("+ data.correct_option +")").attr('selected', 'selected');
        switch(data.question_rating) {
            case "Easy" :
            {
                var q_ratings = "<option value='1' selected>Easy</option>" +
                                "<option value='2'>Medium</option>" +
                                "<option value='3'>Hard</option>" +
                                "<option value='4'>Very Hard</option>";
            }
            break;

            case "Medium":
            {
                var q_ratings = "<option value='1'>Easy</option>" +
                                "<option value='2' selected>Medium</option>" +
                                "<option value='3'>Hard</option>" +
                                "<option value='4'>Very Hard</option>";
            }
            break;

            case "Hard":
            {
                var q_ratings = "<option value='1'>Easy</option>" +
                                "<option value='2'>Medium</option>" +
                                "<option value='3' selected>Hard</option>" +
                                "<option value='4'>Very Hard</option>";
            }
            break;

            case "Very Hard":
            {
                var q_ratings = "<option value='1'>Easy</option>" +
                                "<option value='2'>Medium</option>" +
                                "<option value='3'>Hard</option>" +
                                "<option value='4' selected>Very Hard</option>";
            }
            break;
        }
        $("#question_rating").html(q_ratings);
        $("#question_id").val($(this).attr('data-question-id'));
    });

    questionTable.on('click', '.delete', function() {
        let question_id = $(this).attr('data-question-id');
        $('#delete_form').attr('action', '/institute/questions/delete-question/' + question_id);
    });

    function quillJsAddText(str, obj) {
        str = $(str).html();
        obj.root.innerHTML = str;
    }

    $("#edit_question_form").on('submit', function(event) {
        addTextToHiddenField($('#question_text_rt'), $('#question_text'));
        addTextToHiddenField($('#option_1_rt'), $('#option_1'));
        addTextToHiddenField($('#option_2_rt'), $('#option_2'));
        addTextToHiddenField($('#option_3_rt'), $('#option_3'));
        addTextToHiddenField($('#option_4_rt'), $('#option_4'));
        addTextToHiddenField($('#question_answer_explanation_rt'), $('#question_answer_explanation'));
    });

    var addTextToHiddenField = function(div_element, hidden_input_element) {
        var text = div_element.html();
        text = text.replace(/<\/?(input)\b[^<>]*>/g, "");
        hidden_input_element.val(text);
    };

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

