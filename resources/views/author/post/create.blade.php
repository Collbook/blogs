@extends('layouts.backend.app')

@section('title','Create Post')

@push('css')
<!-- Bootstrap Select Css -->
    <link href="{{ asset('assets/backend/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />
@endpush


@section('content')

<div class="container-fluid">
        <div class="block-header">
            <a href="{{ route('author.post.index') }}" class="btn bg-blue waves-effect">
                    <i class="material-icons">arrow_back</i>
                    <span>Back to list</span>
            </a>
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
                                Add New Post
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
                            <label for="tag">Post Title</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control" placeholder="Enter your post name">
                                </div>
                            </div>
                            <br>
                            <label for="tag">Featured Image</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="file" id="image" name="image" value="{{ old('image') }}" class="form-control" placeholder="Enter your image file">
                                </div>
                            </div>
                            <br>
                            <div class="demo-checkbox">
                                <input type="checkbox" id="publish" name="status" value="1" />
                                <label for="publish">Publish</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Category and Tags
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
                                <div class="form-group">
                                    <div class="form-line {{ $errors->has('categories') ? 'focused error' : '' }}">
                                        <label for="form-label">Select Categories</label>
                                        <select class="form-control show-tick" id="categories" name="categories[]" data-live-search="true" tabindex="-98" multiple>
                                            @foreach ($categories as $categorie)
                                                <option value="{{ $categorie->id }}">{{ $categorie->name }}</option>
                                            @endforeach

                                           
                                      
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group" style="padding-top: 5px;">
                                    <div class="form-line {{ $errors->has('tags') ? 'focused error' : '' }}">
                                        <label for="tag">Select Tags</label>
                                        <select class="form-control show-tick" id="tags" name="tags[]" data-live-search="true" tabindex="-98" multiple>
                                            @foreach ($tags as $tag)
                                                <option value="{{ $tag->id }}" >{{ $tag->name }}</option>
                                            @endforeach                                           
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-sm btn-danger m-t-15 waves-effect ">
                                    Back
                                </button>
                                <button type="submit" class="btn btn-primary m-t-15 waves-effect pull-right">Publish</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Vertical Layout -->

            <!-- Vertical Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               Body
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
                            <textarea name="body" id="tinymce" cols="30" rows="10"></textarea>
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
   </script>
@endpush
