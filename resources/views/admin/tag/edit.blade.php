@extends('layouts.backend.app')

@section('title','Create tag')

@push('css')
 <!-- JQuery DataTable Css -->
   
@endpush

<style type="text/css">
.table-responsive {
    min-height: .01%;
    overflow-x: hidden;
}
</style>

@section('content')

<div class="container-fluid">
        <div class="block-header">
            <a href="{{ route('admin.tag.index') }}" class="btn bg-blue waves-effect">
                    <i class="material-icons">arrow_back</i>
                    <span>Back to list</span>
            </a>
        </div>
        <!-- Vertical Layout -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Edit Tag
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
                        @include('layouts.backend.partial.message')
                        <form method="POST" action="{{ route('admin.tag.update',['id'=>$tag->id]) }}') }}">
                            @csrf
                            @method('PUT')
                            <label for="tag">Tag name</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="tag" name="tag" class="form-control" value="{{ $tag->name }}" placeholder="Enter your tag name">
                                </div>
                            </div>
                            
                            <br>
                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Vertical Layout -->
    </div>
@endsection

@push('js')
    <!-- Jquery DataTable Plugin Js -->

@endpush
