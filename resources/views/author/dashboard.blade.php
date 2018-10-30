@extends('layouts.backend.app')

@section('title','Dashboard')

@push('css')
    
@endpush

@section('content')
<div class="container-fluid">
    <div class="block-header">
        <h2>DASHBOARD</h2>
    </div>

    <!-- Widgets -->
    <div class="row clearfix">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-pink hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">playlist_add_check</i>
                </div>
                <div class="content">
                    <div class="text">TOTAL POSTS</div>
                    <div class="number count-to" data-from="0" data-to="{{ $posts->count() }}" data-speed="15" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-cyan hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">favorite</i>
                </div>
                <div class="content">
                    <div class="text">TOTAL FAVORITE</div>
                    <div class="number count-to" data-from="0" data-to="{{ Auth::user() ->favorite_posts()->count()}}" data-speed="1000" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-light-green hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">library_books</i>
                </div>
                <div class="content">
                    <div class="text">PENDING POSTS</div>
                    <div class="number count-to" data-from="0" data-to="{{ $total_pending_posts }}" data-speed="1000" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-orange hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">person_add</i>
                </div>
                <div class="content">
                    <div class="text">TOTAL VIEWS</div>
                    <div class="number count-to" data-from="0" data-to="{{ $all_views }}" data-speed="1000" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Widgets -->


    <div class="row clearfix">
        <!-- Task Info -->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>TOP 5 POPULAR POSTS</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-hover dashboard-task-infos">
                            <thead>
                            <tr>
                                <th>Rank List</th>
                                <th>Title</th>
                                <th>Views</th>
                                <th>Favorite</th>
                                <th>Comments</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($popular_posts as $key=>$post)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ str_limit($post->title,30) }}</td>
                                        <td>{{ $post->view_count }}</td>
                                        <td>{{ $post->favorite_to_users_count }}</td>
                                        <td>{{ $post->comments_count }}</td>
                                        <td>
                                            @if($post->status == true)
                                                <span class="label bg-green">Published</span>
                                            @else
                                                <span class="label bg-red">Pending</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Task Info -->

    </div>

    <!-- CPU Usage -->
    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="header">
                    <div class="row clearfix">
                        <div class="col-xs-12 col-sm-6">
                            <h2>CPU USAGE (%)</h2>
                        </div>
                        <div class="col-xs-12 col-sm-6 align-right">
                            <div class="switch panel-switch-btn">
                                <span class="m-r-10 font-12">REAL TIME</span>
                                <label>OFF<input type="checkbox" id="realtime" checked><span class="lever switch-col-cyan"></span>ON</label>
                            </div>
                        </div>
                    </div>
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
                    <div id="real_time_chart" class="dashboard-flot-chart"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# CPU Usage -->

</div>

@endsection

@push('js')
     <!-- Jquery CountTo Plugin Js -->
     <script src="{{ asset('assets/backend/plugins/jquery-countto/jquery.countTo.js') }}"></script>

     <!-- Morris Plugin Js -->
     <script src="{{ asset('assets/backend/plugins/raphael/raphael.min.js') }}"></script>
     <script src="{{ asset('assets/backend/plugins/morrisjs/morris.js') }}"></script>
    
     <!-- ChartJs -->
     <script src="{{ asset('assets/backend/plugins/chartjs/Chart.bundle.js') }}"></script>
    
     <!-- Flot Charts Plugin Js -->
     <script src="{{ asset('assets/backend/plugins/flot-charts/jquery.flot.js') }}"></script>
     <script src="{{ asset('assets/backend/plugins/flot-charts/jquery.flot.resize.js') }}"></script>
     <script src="{{ asset('assets/backend/plugins/flot-charts/jquery.flot.pie.js') }}"></script>
     <script src="{{ asset('assets/backend/plugins/flot-charts/jquery.flot.categories.js') }}"></script>
     <script src="{{ asset('assets/backend/plugins/flot-charts/jquery.flot.time.js') }}"></script>
    
     <!-- Sparkline Chart Plugin Js -->
     <script src="{{ asset('assets/backend/plugins/jquery-sparkline/jquery.sparkline.js') }}"></script>
    
     <!-- Custom Dashboard Js -->
     <script src="{{ asset('assets/backend/js/pages/index.js') }}"></script>
@endpush
