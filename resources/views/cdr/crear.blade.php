@if($action == 1)
 @php
        $vars=[ 'breadcrum' => ['Financiero','Generar Disponibilidad de Recursos'],
                        'title'=>' Generar Disponibilidad de Recursos',
                        'activeMenu'=>'18'
                    ]
 @endphp
@else
    @php
        $vars=[ 'breadcrum' => ['Financiero','Edición Disponibilidad de Recursos'],
                        'title'=>' Edición Disponibilidad de Recursos',
                        'activeMenu'=>'18'
                    ]
    @endphp 
@endif

@extends('layouts.app',$vars)
     
@section('content')


    <div class="row">
        <div class="col-12">
            <!-- general form elements disabled -->
            <div class="card card-primary shadow">
                <div class="card-header">
                @if($action == 1)
                   <h3 class="card-title">Información General - CDR</h3>
                @else
                  <h3 class="card-title">Información General - CDR</h3>
               @endif
                  
                </div>
                <!-- /.card-header -->
                @if($action == 1)
                <form role="form" method="POST"  action="{{route('cdr.store')}}">
                @else
                <form role="form" method="POST"  action="{{route('cdr.update')}}">
                    <input type="hidden" name="id_cdr" value="{{$cdr['id']}}">
               @endif
               
                    @csrf
                    <div class="card-body">

                        <div class="form-row">
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Fecha de Creación</label>
                                    <input type="hidden" name="fecha" value="{{$fecha}}">
                                    <input type="text" class="form-control" value="{{$fecha}}" disabled>
                                 </div>
                              </div>

                              @if($action == 1)
                              <div class="col-md-9">
                                <div class="form-group">
                                    <label>Objeto CDR *</label>
                                    <input type="text" class="form-control" name="objecto_cdr" id="objecto_cdr" required>
                                </div>
                              </div>
                              @else
                              <div class="col-md-9">
                                <div class="form-group">
                                    <label>Objeto CDR*</label>
                                    <input type="text" class="form-control" name="objecto_cdr" value="{{$cdr['objeto_cdr']}}" id="objecto_cdr" required>
                                </div>
                               </div>
                              @endif
                        </div>
                      <!-- /.form-row -->
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        @if($action == 1)
                        <button type="submit" class="btn btn-sm btn-primary" name="guardar" vuale="guardar" >Guardar</button>
                        @else
                          <button type="submit" class="btn btn-sm btn-primary" name="Actualizar" vuale="Actualizar" >Actualizar</button>
                        @endif
                        
                        
                        <a href="{{route('cdr.index')}}"  type="button" class="btn btn-sm btn-default float-right"  name="cancelar" vuale="cancelar"  >Cancelar</a>
                    </div>
                </form>
            </div>
              <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

@endsection


@section('script')

<script type="text/javascript">

</script>

@endsection



