<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Laravel Shop :: Administrative Panel</title>
		<!-- Google Font: Source Sans Pro -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="{{ asset('assets-front/fontawesome/css/all.min.css') }}">
		<!-- Theme style -->
		<link rel="stylesheet" href="{{ asset('assets-admin/bootstrap/css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets-admin/css/custom.css') }}">
        <link rel="stylesheet" href="{{ asset('assets-admin/css/signin.css') }}">
	</head>
	<body>
		<div class="form-signin w-100 m-auto">
			<!-- /.login-logo -->
            @include('admin.messages')
			<div class="card rounded-1">
			  	<div class="card-header text-center rounded-0 bg-primary">
					<a href="{{ route('home') }}" class="h4 text-white">Administrative Panel</a>
			  	</div>
			  	<div class="card-body m-auto h-25">
					<p class="login-box-msg text-center">Sign in to start your session</p>
					<form action="{{ route('admin.authenticate') }}" method="POST">
                        @csrf
				  		<div class="input-group rounded-1 mb-3">
							<input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
							<span class="input-group-text btn-primary" id="basic-addon2"><i class="fa fa-envelope"></i></span>
                            @error('email')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
				  		</div>
				  		<div class="input-group rounded-1 mb-3">
							<input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
							<span class="input-group-text btn-primary" id="basic-addon2"><i class="fa fa-lock"></i></span>
                            @error('password')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
				  		</div>
				  		<div class="row">
							<!-- <div class="col-8">
					  			<div class="icheck-primary">
									<input type="checkbox" id="remember">
									<label for="remember">
						  				Remember Me
									</label>
					  			</div>
							</div> -->
							<!-- /.col -->
							<div class="col-12">
					  			<button type="submit" class="btn btn-primary border-0 rounded-1 btn-block">
                                    Se connectez
                                    <i class="fa fa-sign-in text-white"></i>
                                </button>
                            </div>
							<!-- /.col -->
				  		</div>
					</form>
			  	</div>
			  	<!-- /.card-body -->
			</div>
			<!-- /.card -->
		</div>
		<!-- ./wrapper -->
		<!-- jQuery -->
		<script src="{{ asset('assets-admin/plugins/jquery/jquery.min.js') }}"></script>
		<!-- Bootstrap 4 -->
		<script src="{{ asset('assets-admin/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
		<!-- AdminLTE App -->
		<script src="{{ asset('assets-admin/js/adminlte.min.js') }}"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="{{ asset('assets-admin/js/demo.js') }}"></script>
	</body>
</html>
