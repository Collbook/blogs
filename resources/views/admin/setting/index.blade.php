@extends('layouts.backend.app')

@section('title','Settings')

@push('css')

@endpush

@section('content')

<div class="container-fluid">

    <!-- #END# Tabs With Only Icon Title -->
    <!-- Tabs With Icon Title -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Settings Profile
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
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#home_with_icon_title" data-toggle="tab" aria-expanded="false">
                                <i class="material-icons">home</i> Update Profile
                            </a>
                        </li>
                        <li role="presentation" class="">
                            <a href="#change_password_with_icon_title" data-toggle="tab" aria-expanded="false">
                                <i class="material-icons">face</i> Password
                            </a>
                        </li>
                        
                        <li role="presentation" class="">
                            <a href="#change_logo_with_icon_title" data-toggle="tab" aria-expanded="false">
                                <i class="material-icons">account_box</i>Update Logo
                            </a>
                        </li>
                        
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="home_with_icon_title">                            
                            @include('layouts.backend.partial.message')
                            <form method="POST" action="{{ route('admin.profile.update',['id'=>Auth::user()->id]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <label for="email_address">Name</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="name" name="name" class="form-control" value="{{ Auth::user()->name }}" placeholder="Please Enter your name">
                                    </div>
                                </div>
                                <label for="email_address">Email</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="email" id="email" name="email" class="form-control" value="{{ Auth::user()->email }}" placeholder="Enter your email address">
                                    </div>
                                </div>

                                <label for="email_address">Avatar</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="file" id="image" value="{{URL::asset('profile/'.Auth::user()->image)}}" name="image" class="form-control" placeholder="Please enter your image">
                                    </div>
                                </div>

                                <label for="email_address">About</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <textarea name="about" id="tinymce" cols="30" rows="10"></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary m-t-15 waves-effect">Update Profile</button>
                            </form>
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="change_password_with_icon_title">
                            @include('layouts.backend.partial.message')
                            <form method="POST" action="{{ route('admin.password.update',['id'=>Auth::user()->id]) }}">
                                @csrf
                                @method('PUT')
                                <label for="password">Old Password</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="password" name="old_password" class="form-control" placeholder="Enter your old password">
                                    </div>
                                </div>
                                
                                <label for="password">New Password</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="password" name="password" class="form-control" placeholder="Enter your password">
                                    </div>
                                </div>

                                <label for="password">Confirm New Password confirmation</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="Enter your password">
                                    </div>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary m-t-15 waves-effect">Update Password</button>
                            </form>
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="change_logo_with_icon_title">                            
                            @include('layouts.backend.partial.message')
                            <form method="POST" action="{{ route('admin.logo.update',['id'=>Auth::user()->id]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                    <label for="email_address">Change logo</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="file" value="" name="image" class="form-control" placeholder="Logo your company">
                                        </div>
                                    </div>
                                <button type="submit" class="btn btn-primary m-t-15 waves-effect">Update</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Tabs With Icon Title -->
</div>

@endsection



@push('js')
   
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
