@extends('layouts.backend.app')

@section('title','authors')

@push('css')
 <!-- JQuery DataTable Css -->
    <link href="{{ asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">  
    <style>
        .btn-sm, .btn-group-sm > .btn {
            padding: 1px 5px;
            font-size: 12px;
            line-height: 1.5;
            border-radius: 3px;
        }
    </style>
@endpush



@section('content')
    <div class="container-fluid">

        <div class="block-header">
            <a href="{{ route('admin.category.create') }}" class="btn bg-blue waves-effect">
                    <i class="material-icons">add</i>
                    <span>Created Category</span>
            </a>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            All Author
                            <span class="badge bg-blue">{{ $authors->count() }}</span>
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else here</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>Stt</th>
                                        <th>Name</th>
                                        <th>Post</th>
                                        <td>Favorite</td>
                                        <td>Comment</td>
                                        <th>Created at</th>
                                        <th>Updated at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Stt</th>
                                        <th>Name</th>
                                        <th>Post</th>
                                        <td>Favorite</td>
                                        <td>Comment</td>
                                        <th>Created at</th>
                                        <th>Updated at</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($authors as $key => $author)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $author->name }}</td>
                                            <td>{{ $author->posts->count() }}</td>
                                            <td>{{ $author->favorite_posts->count() }}</td>
                                            <td>{{ $author->comment->count() }}</td>
                                            <td>{{ date('d-m-Y', strtotime($author->created_at)) }}</td>
                                            <td>{{ date('d-m-Y', strtotime($author->updated_at)) }}</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-warning waves-effect">
                                                    <i class="material-icons">visibility</i>
                                                </a>
                                                <button onclick="deleteAuthor({{ $author->id }})" href="{{ route('admin.author.destroy',['id'=>$author->id]) }}" class="btn btn-sm btn-danger waves-effect">
                                                        <i class="material-icons">delete</i>
                                                </button>
                                                <form id="delete-form-{{ $author->id }}" action="{{ route('admin.author.destroy',['id'=>$author->id]) }}" method="POST" style="display:none;">
                                                    @csrf
                                                    @method('DELETE ')
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Basic Examples -->
    </div>
@endsection

@push('js')
    <!-- Jquery DataTable Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js') }}"></script>

    <script src="{{ asset('assets/backend/js/pages/tables/jquery-datatable.js') }}"></script>


    <!-- SweetAlert2  for detele tag Plugin Js -->
    <script type="text/javascript">
        function deleteAuthor(id) {
            const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
            })

            swalWithBootstrapButtons({
            title: 'Are you sure?',
            text: "You won't delele author this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
            }).then((result) => {
            if (result.value) {
                // code in here
                event.preventDefault();
                document.getElementById('delete-form-'+id).submit();
            } else if (
                // Read more about handling dismissals
                result.dismiss === swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons(
                'Cancelled',
                'Your imaginary author is safe :)',
                'error'
                )
            }
            })
        }
    </script>
@endpush
