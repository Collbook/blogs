@extends('layouts.backend.app')

@section('title','Favorite')

@push('css')
 <!-- JQuery DataTable Css -->
    <link href="{{ asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">  
    <style>
    .btn-sm, .btn-group-sm > .btn,button.btn.bg-green.waves-effect{
            padding: 5px 5px;
            font-size: 12px;
            line-height: 1.5;
            border-radius: 3px;
        }
    .btn:not(.btn-link):not(.btn-circle) i{
        font-size: 20px;
        position: relative;
        top: 1px;
    }
    </style>
@endpush


@section('content')
    <div class="container-fluid">
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            All Favorited Post
                            <span class="badge bg-blue">{{ $posts->count() }}</span>
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
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th><i class="material-icons">favorite</i></th>
                                        <th><i class="material-icons">comment</i></th>
                                        <th><i class="material-icons">visibility</i></th>
                                        <th>Create at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($posts as $key => $post)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ str_limit($post->title,'10') }}</td>
                                            <td>{{ $post->user->name }}</td>
                                            <td>{{ $post->favorite_to_users->count() }}</td>
                                            <td>
                                              {{  $post->comments()->count() }}
                                            </td>
                                            <td>{{ $post->view_count }}</td>
                                            <td>{{ $post->created_at->diffForHumans() }}</td>
                                            <td>
                                                
                                                <a href="{{ route('admin.post.show',['id'=>$post->id]) }}" class="btn btn-sm btn-warning waves-effect mb-2">
                                                        <i class="material-icons md-18">visibility</i>
                                                </a>
                                                <button onclick="deleteFavorite({{ $post->id }})" href="{{ route('post.favorite.add',['id'=>$post->id]) }}" class="btn btn-sm btn-danger waves-effect">
                                                        <i class="material-icons">delete</i>
                                                </button>
                                                <form id="remove-form-{{ $post->id }}" action="{{ route('post.favorite.add',['id'=>$post->id]) }}" method="POST" style="display:none;">
                                                    @csrf
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
        function deleteFavorite(id) {
            const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
            })

            swalWithBootstrapButtons({
            title: 'Are you sure?',
            text: "You won't removed favorite post this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
            }).then((result) => {
            if (result.value) {
                // code in here
                event.preventDefault();
                document.getElementById('remove-form-'+id).submit();
            } else if (
                // Read more about handling dismissals
                result.dismiss === swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons(
                'Cancelled',
                'Your emoved favorite post is safe :)',
                'error'
                )
            }
            })
        }


    </script>
@endpush
