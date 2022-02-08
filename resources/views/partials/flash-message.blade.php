@if (Session::get('success')!= null)
<div class="alert alert-success alert-block shadow">
	<button type="button" class="close" data-dismiss="alert">×</button>	
        <strong>{{ Session::get('success') }}</strong>        
</div>
 
 {{-- {{ var_dump(  Session::get('success') ) }}
 {{ Session::forget('success') }}
 {{ var_dump(  Session::get('success') ) }} --}}
@endif


@if ($message = Session::get('error'))
<div class="alert alert-danger alert-block shadow">
	<button type="button" class="close" data-dismiss="alert">×</button>	
        <strong>{{ $message }}</strong>
</div>
{{ Session::forget('error') }}
@endif


@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-block shadow">
	<button type="button" class="close" data-dismiss="alert">×</button>	
	<strong>{{ $message }}</strong>
</div>
@endif


@if ($message = Session::get('info'))
<div class="alert alert-info alert-block shadow">
	<button type="button" class="close" data-dismiss="alert">×</button>	
	<strong>{{ $message }}</strong>
</div>
@endif


@if ($errors->any())
<div class="alert alert-danger  alert-block  shadow">
	<button type="button" class="close" data-dismiss="alert">×</button>	
    <li> Revise los siquientes errores:</li>
    @foreach ($errors->all() as $error)
            <li>{{ $error }}  </li>
        @endforeach

</div>
@endif
{{-- {{ $request->session()->flush() }} --}}
