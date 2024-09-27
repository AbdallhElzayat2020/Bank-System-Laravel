@extends('Dashboard.layouts.master')
@section('title', 'الاقسام')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الاقسام</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    الاعدادات</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <div class="col-lg-1">
                            <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale"
                                data-toggle="modal" href="#modaldemo8">اضافة قسم</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session()->get('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if (session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session()->get('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">ID</th>
                                    <th class="wd-15p border-bottom-0">اسم القسم</th>
                                    <th class="wd-20p border-bottom-0">تم الاضافة بواسطة</th>
                                    <th class="wd-20p border-bottom-0">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($sections) && count($sections) > 0)
                                    @foreach ($sections as $key => $section)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $section->section_name }}</td>
                                            <td>{{ $section->created_by }}</td>
                                            <td class="d-flex align-items-center justify-center gap-3 ">
                                                <a class="modal-effect btn mx-2 btn-outline-primary btn-sm"
                                                    data-effect="effect-scale" data-toggle="modal"
                                                    data-id="{{ $section->id }}"
                                                    data-section_name="{{ $section->section_name }}" title="تعديل"
                                                    href="#modaldemo7">
                                                    <i class="las la-edit" style="font-size:20px"></i>
                                                </a>

                                                <a class="modal-effect btn mx-2 btn-sm btn-danger"
                                                    data-effect="effect-scale" data-id="{{ $section->id }}"
                                                    data-section_name="{{ $section->section_name }}" data-toggle="modal"
                                                    href="#modaldemo6" title="حذف">
                                                    <i class="las la-trash" style="font-size:20px"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">لا يوجد اقسام</td>
                                    </tr>
                                @endif
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>


        {{-- Modal Create --}}
        <div class="modal" id="modaldemo8">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">اضافة قسم</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                                aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('sections.store') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="section_name" class="control-label mb-1">اسم القسم</label>
                                <input id="section_name" name="section_name" type="text" class="form-control"
                                    aria-required="true" aria-invalid="false">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn ripple btn-success" type="button">انشاء وحفظ</button>
                            <button class="btn ripple btn-danger" data-dismiss="modal" type="button">الغاء</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Modal Create --}}
        {{-- Modal Edit --}}
        <div class="modal" id="modaldemo7">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">تعديل قسم</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="post" id="editForm">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="section_name" class="control-label mb-1">اسم القسم</label>
                                <input id="section_name" name="section_name" type="text" class="form-control"
                                    aria-required="true" aria-invalid="false">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn ripple btn-success">تعديل وحفظ</button>
                            <button class="btn ripple btn-danger" data-dismiss="modal" type="button">الغاء</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        {{-- Modal Edit --}}
        {{-- Modal Delete --}}
        <div class="modal" id="modaldemo6">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">حذف قسم</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="post" id="deleteForm">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="id" id="delete_id" value="">
                                <h3>هل انت متاكد من الحذف</h3>
                                <label for="section_name" class="control-label mb-1">اسم القسم</label>
                                <input id="delete_section_name" disabled name="section_name" type="text"
                                    class="form-control" aria-required="true" aria-invalid="false">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn ripple btn-success" type="button">الحذف</button>
                            <button class="btn ripple btn-danger" data-dismiss="modal" type="button">الغاء</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal Delete --}}

    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <!-- Internal Modal js-->
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>
    <script>
        // عند فتح مودال التعديل
        $('#modaldemo7').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // الزر الذي فتح المودال
            var id = button.data('id'); // جلب البيانات من الـ data-attributes
            var section_name = button.data('section_name');

            var modal = $(this);
            modal.find('#section_name').val(section_name);

            // تحديث رابط النموذج حسب القسم
            $('#editForm').attr('action', '/sections/' + id);
        });

        // عند فتح مودال الحذف
        $('#modaldemo6').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // الزر الذي فتح المودال
            var id = button.data('id'); // جلب البيانات من الـ data-attributes
            var section_name = button.data('section_name');

            var modal = $(this);
            modal.find('#delete_section_name').val(section_name);
            modal.find('#delete_id').val(id);

            // تحديث رابط النموذج حسب القسم
            $('#deleteForm').attr('action', '/sections/' + id);
        });
    </script>
@endsection
