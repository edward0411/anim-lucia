@extends('layouts.app_nologin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-3">
              <div class="login-logo">
                    <a href="../../index.html"><img src="/dist/img/anim_logo_anim.png" alt="ANIM Logo" width="180"></a>
              </div>
  <!-- /.login-logo -->
        </div>
        <div class="col-lg-3">
          <div class="login-logo">
                <a href="../../index.html"><img src="/dist/img/lucia_logo.png" alt="ANIM Logo" width="150"></a>
          </div>
<!-- /.login-logo -->
    </div>
        
        <div class="col-lg-6 login-forma">
              <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg"><font size="2">Ingrese su correo electrónico</font></p>
      @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        
  
      <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="input-group mb-3">
          <input type="email" class="form-control form-control form-control form-control-sm mb-0  @error('email') is-invalid @enderror" placeholder="Correo electrónico" id="email"  name="email" required autocomplete="email" autofocus >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
          @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        
        <div class="row">
          <!-- /.col -->
          <div class="col">
            <button type="submit" class="btn btn-primary btn-sm">Enviar link de cambio de clave</button>
            <a href="{{route('login')}}" class="btn btn-primary btn-sm" >Regresar al login</a>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.login-card-body -->
  </div><!-- /.card -->
        </div><!--login-forma-->
        <div class="col-lg-12">
          <div class="card-body login-card-body">
              <p class="login-box-msg"><font size="2">Para mejorar le experiencia en nuestro sitio asegúrese de usar:</font></p>
          </div>
      </div>
      <div class="col-lg-3">
          <div class="login-logo">
              <a href="../../index.html"><img src="{{ asset('/dist/img/logo_gobierno.png') }}" alt="" width="180"></a>
          </div>
      </div>
      <div class="col-lg-3">
          <div class="login-logo">
              <a href="../../index.html"><img src="{{ asset('/dist/img/cromo.png') }}" alt="" width="30">
                  <h6>Google Chrome</h6>
              </a>
          </div>
      </div>
      <div class="col-lg-3">
          <div class="login-logo">
              <a href="../../index.html"><img src="{{ asset('/dist/img/mozilla.png') }}" alt="" width="30">
                  <h6>Mozilla Firefox</h6>
              </a>
          </div>
      </div>
      <div class="col-lg-3">
          <div class="login-logo">
              <a href="../../index.html"><img src="{{ asset('/dist/img/edge.png') }}" alt="" width="30">
                  <h6>Microsoft Edge</h6>
              </a>
          </div>
      </div>
  </div>
    </div><!--row-->
</div><!--container-->



@endsection
