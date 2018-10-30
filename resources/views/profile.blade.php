@extends('layouts.frontend.app')

@section('title')
    {{ $author->name }}    
@endsection

@push('css')
<link href="{{ asset('assets/frontend/css/author/styles.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/frontend/css/author/responsive.css') }}" rel="stylesheet">
	<style type="text/css">
        .favorite_posts{
            color: firebrick;
        }
    </style>
@endpush

@section('content')

    <div class="slider display-table center-text">
		<h1 class="title display-table-cell"><b> Post By {{ $author->name }}    </b></h1>
	</div><!-- slider -->

	<section class="blog-area section">
		<div class="container">

			<div class="row">
				<div class="col-lg-8 col-md-12">
					<div class="row">
						@if ($posts->count() > 0)
							@foreach ($posts as $post)
								<div class="col-md-6 col-sm-12">
									<div class="card h-100">
										<div class="single-post post-style-1">

											<div class="blog-image"><img src="{{ Storage::disk('public')->url('post/'.$post->image) }}" alt="Blog Image"></div>

											<a class="avatar" href="{{ route('author.profile',$post->user->username) }}"><img src="{{ Storage::disk('public')->url('profile/'.$post->user->image) }}" alt="Profile Image"></a>

											<div class="blog-info">

												<h4 class="title"><a href="{{ route('post.details',$post->slug) }}"><b>{{ $post->title }}</b></a></h4>

												<ul class="post-footer">
													<li>
														@guest
															<a href="javascript:void(0);" onclick="toastr.info('To add favorite list. You need to login first.','Info',{
																closeButton: true,
																progressBar: true,
															})"><i class="ion-heart"></i>{{ $post->favorite_to_users->count() }}</a>
														@else
															<a href="javascript:void(0);" onclick="document.getElementById('favorite-form-{{ $post->id }}').submit();"
															class="{{ !Auth::user()->favorite_posts->where('pivot.post_id',$post->id)->count()  == 0 ? 'favorite_posts' : ''}}"><i class="ion-heart"></i>{{ $post->favorite_to_users->count() }}</a>
				
															<form id="favorite-form-{{ $post->id }}" method="POST" action="{{ route('post.favorite.add',$post->id) }}" style="display: none;">
																@csrf
															</form>
														@endguest
													</li>
													<li><a href="#"><i class="ion-chatbubble"></i>{{ $post->comments->count() }}</a></li>
													<li><a href="#"><i class="ion-eye"></i>{{ $post->view_count }}</a></li>
												</ul>

											</div><!-- blog-info -->
										</div><!-- single-post -->
									</div><!-- card -->
								</div><!-- col-md-6 col-sm-12 -->
							@endforeach
						@else
						<div class="col-md-12 col-sm-12">
								<div class="card h-100">
									<div class="single-post post-style-1">
										<div class="blog-info">

											<h4 class="title">Sory, No post not found !</h4>

										</div><!-- blog-info -->
									</div><!-- single-post -->
								</div><!-- card -->
							</div><!-- col-md-6 col-sm-12 -->
						@endif
					</div><!-- row -->

					{{-- <a class="load-more-btn" href="#"><b>LOAD MORE</b></a> --}}

				</div><!-- col-lg-8 col-md-12 -->

				<div class="col-lg-4 col-md-12 ">

					<div class="single-post info-area ">
						<div class="about-area">
							<h4 class="title"><b>ABOUT {{ $author->name }}</b></h4>
							<p>{!!  $author->about !!}</p>
							<p> <strong>Join :</strong> {{ $author->created_at->toDateString() }}</p>
							<p> <strong>Total post :</strong> {{ $author->posts->count() }}</p>
						</div>

						<div class="subscribe-area">

							<h4 class="title"><b>SUBSCRIBE</b></h4>
							<div class="input-area">
								<form method="POST" action="{{ route('subsriber.store') }}">
									@csrf
									<input class="email-input" type="text" name="email" placeholder="Enter your email">
									<button class="submit-btn" type="submit"><i class="icon ion-ios-email-outline"></i></button>
								</form>
							</div>

						</div><!-- subscribe-area -->

						<div class="tag-area">

							<h4 class="title"><b>TAG CLOUD</b></h4>
							<ul>
								@foreach ($post->tags as $tag)
									<li><a href="{{ route('tag.posts',$tag->slug) }}">{{ $tag->name }}</a></li>
								@endforeach
							</ul>

						</div><!-- subscribe-area -->

					</div><!-- info-area -->

				</div><!-- col-lg-4 col-md-12 -->
			</div><!-- row -->

		</div><!-- container -->
    </section><!-- section -->
    
@endsection

@push('js')
    
@endpush