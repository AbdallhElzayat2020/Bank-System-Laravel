@extends('Dashboard.layouts.master')
@section('title', 'المنتحات')
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
                <h4 class="content-title mb-0 my-auto">المنتجات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    الاقسام</span>
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
                        <div class="col-lg-2">
                            <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale"
                                data-toggle="modal" href="#modaldemo8">اضافة قسم
                            </a>
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
                        <table class="table text-md-nowrap" data-page-length='50' id="example1">
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">ID</th>
                                    <th class="wd-15p border-bottom-0">اسم المنتج</th>
                                    <th class="wd-20p border-bottom-0">اسم القسم</th>
                                    <th class="wd-20p border-bottom-0">ملاحظات</th>
                                    <th class="wd-20p border-bottom-0">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($sections) && count($sections) > 0)
                                    @foreach ($products as $key => $product)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $product->product_name }}</td>
                                            <td>{{ $product->section->section_name }}</td>
                                            <td>{{ $product->description }}</td>
                                            <td>
                                                <button class="btn btn-outline-success btn-sm"
                                                    data-name="{{ $product->product_name }}"
                                                    data-pro_id="{{ $product->id }}"
                                                    data-section_name="{{ $product->section->section_name }}"
                                                    data-description="{{ $product->description }}" data-toggle="modal"
                                                    data-target="#edit_Product">تعديل
                                                </button>

                                                <button class="btn btn-outline-danger btn-sm "
                                                    data-pro_id="{{ $product->id }}"
                                                    data-product_name="{{ $product->product_name }}" data-toggle="modal"
                                                    data-target="#modaldemo6">حذف
                                                </button>
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
                        <h6 class="modal-title">اضافة منتج</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                                aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('products.store') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="product_name" class="control-label mb-1">اسم المنتج</label>
                                <input id="product_name" name="product_name" type="text" class="form-control"
                                    aria-required="true" aria-invalid="false">
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="section_id" class="control-label mb-1">القسم</label>
                                <select name="section_id" id="section_id" class="form-control">
                                    <option value="" selected disabled> --حدد القسم--</option>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="description" class="control-label mb-1">ملاحظات</label>
                                <textarea id="description" name="description" type="text" class="form-control" aria-required="true"
                                    aria-invalid="false"></textarea>
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
        <div class="modal" id="edit_Product">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">تعديل منتج</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                                aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('products.update', $product->id) }}" method="post" id="editForm"
                        autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <input type="hidden" class="form-control" name="pro_id" id="pro_id" value="">
                            <div class="form-group">
                                <label for="product_name" class="control-label mb-1">اسم المنتج</label>
                                <input id="product_name" name="product_name" type="text" class="form-control"
                                    aria-required="true" aria-invalid="false">
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="section_name" class="control-label mb-1">القسم</label>
                                <select name="section_name" id="section_name" class="custom-select my-1 mr-sm-2"
                                    required>
                                    <option value="" selected disabled> --حدد القسم--</option>
                                    @foreach ($sections as $section)
                                        <option>{{ $section->section_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="description" class="control-label mb-1">ملاحظات</label>
                                <textarea id="description" name="description" type="text" class="form-control" aria-required="true"
                                    aria-invalid="false"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn ripple btn-success" type="button">تعديل وحفظ</button>
                            <button class="btn ripple btn-danger" data-dismiss="modal" type="button">اغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Modal Edit --}}
        {{-- Modal Delete --}}
        <div class="modal fade" id="modaldemo6" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">حذف المنتج</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('products.destroy', $product->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <div class="modal-body">
                            <p>هل انت متاكد من عملية الحذف ؟</p><br>
                            <input type="hidden" name="pro_id" id="pro_id" value="">
                            <input class="form-control" name="product_name" id="product_name" type="text" readonly>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                            <button type="submit" class="btn btn-danger">تاكيد</button>
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
        $('#edit_Product').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var product_name = button.data('name')
            var section_name = button.data('section_name')
            var pro_id = button.data('pro_id')
            var description = button.data('description')
            var modal = $(this)
            modal.find('.modal-body #product_name').val(product_name);
            modal.find('.modal-body #section_name').val(section_name);
            modal.find('.modal-body #description').val(description);
            modal.find('.modal-body #pro_id').val(pro_id);
        })
        $(document).ready(function() {
            $('#modaldemo6').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var pro_id = button.data('pro_id')
                var product_name = button.data('product_name')
                var modal = $(this)

                modal.find('.modal-body #pro_id').val(pro_id);
                modal.find('.modal-body #product_name').val(product_name);
            })
        });
    </script>
@endsection
