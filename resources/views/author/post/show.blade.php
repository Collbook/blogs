@extends('layouts.backend.app')

@section('title','Detail Post')

@push('css')

@endpush


@section('content')

<div class="container-fluid">
        <div class="block-header">
            <a href="{{ route('author.post.index') }}" class="btn bg-blue waves-effect">
                    <i class="material-icons">arrow_back</i>
                    <span>Back to list</span>
            </a>

            @if ($post->is_approved == false)

                <button class="btn bg-green waves-effect pull-right" disabled>
                    <i class="material-icons">lock</i>
                    <span>Not Approved</span>
                </button>
            @else
                <a  class="btn bg-green waves-effect pull-right">
                    <i class="material-icons">done</i>
                    <span>Approved</span>
                </a>
            @endif
            
        </div>
        @include('layouts.backend.partial.message')
        <form method="POST" action="{{ route('author.post.store') }}" enctype="multipart/form-data">
            @csrf
            <!-- Vertical Layout -->
            <div class="row clearfix">
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               {{$post->title}}
                               <small>Posted by <strong> <a href="#">{{ $post->user->name }}</a></strong> on {{ $post->created_at->toFormattedDateString() }}</small>
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="{{ route('author.post.edit',['id'=>$post->id]) }}" class=" waves-effect waves-block">Edit Post</a></li>
                                        <li><a href="javascript:void(0);" class=" waves-effect waves-block">Another action</a></li>
                                        <li><a href="javascript:void(0);" class=" waves-effect waves-block">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            {!! $post->body !!}
                        </div>
                    </div>
                </div>
                {{-- caterogy --}}
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan">
                            <h2>
                               Category
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);" class=" waves-effect waves-block">Action</a></li>
                                        <li><a href="javascript:void(0);" class=" waves-effect waves-block">Another action</a></li>
                                        <li><a href="javascript:void(0);" class=" waves-effect waves-block">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                               @foreach ($categories as $category)
                                   <span class="label bg-cyan">{{ $category->name }}</span>
                               @endforeach
                        </div>
                    </div>
                </div>

                {{-- tags --}}
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 offset-lg-4 offset-md-4">
                    <div class="card">
                        <div class="header bg-green">
                            <h2>
                                Category
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);" class=" waves-effect waves-block">Action</a></li>
                                        <li><a href="javascript:void(0);" class=" waves-effect waves-block">Another action</a></li>
                                        <li><a href="javascript:void(0);" class=" waves-effect waves-block">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                                @foreach ($tags as $tag)
                                    <span class="label bg-green">{{ $tag->name }}</span>
                                @endforeach
                        </div>
                    </div>
                </div>

                {{-- image future --}}
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 offset-lg-4 offset-md-4 pull-right">
                        <div class="card">
                            <div class="header bg-amber">
                                <h2>
                                    Futured Image
                                </h2>
                                <ul class="header-dropdown m-r--5">
                                    <li class="dropdown">
                                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                            <i class="material-icons">more_vert</i>
                                        </a>
                                        <ul class="dropdown-menu pull-right">
                                            <li><a href="javascript:void(0);" class=" waves-effect waves-block">Action</a></li>
                                            <li><a href="javascript:void(0);" class=" waves-effect waves-block">Another action</a></li>
                                            <li><a href="javascript:void(0);" class=" waves-effect waves-block">Something else here</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="body">
                                    <img class="img-responsive thumbnail" src="{{ Storage::disk('public')->url('post/'.$post->image) }}" alt="">
                            </div>
                        </div>
                    </div>
    
            </div>
            <!-- #END# Vertical Layout -->
        </form>
    </div>
@endsection

@push('js')
 <!-- Select Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
<!-- TinyMCE -->
   <script src="{{ asset('assets/backend/plugins/tinymce/tinymce.js') }}"></script>

   <script>
        $(function () {
            // CKEditor
            // CKEDITOR.replace('ckeditor');
            // CKEDITOR.config.height = 300;

            //TinyMCE
            tinymce.init({
                selector: "textarea#tinymce",
                theme: "modern",
                height: 300,
                plugins: [
                    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                    'searchreplace wordcount visualblocks visualchars code fullscreen',
                    'insertdatetime media nonbreaking save table contextmenu directionality',
                    'emoticons template paste textcolor colorpicker textpattern imagetools'
                ],
                toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                toolbar2: 'print preview media | forecolor backcolor emoticons',
                image_advtab: true
            });
            tinymce.suffix = ".min";
            tinyMCE.baseURL = '{{ asset('assets/backend/plugins/tinymce') }}';
        });

        // respon to admin post pending
        function responPost(id) {
            const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
            })

            swalWithBootstrapButtons({
            title: 'Are you sure?',
            text: "You won't delele post this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
            }).then((result) => {
            if (result.value) {
                // code in here
                event.preventDefault();
                document.getElementById('apply-form-'+id).submit();
            } else if (
                // Read more about handling dismissals
                result.dismiss === swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons(
                'Cancelled',
                'Your imaginary file is safe :)',
                'error'
                )
            }
            })
        }
   </script>
@endpush

