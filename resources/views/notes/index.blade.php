@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Administración','Usuarios'],
                'title'=>'Notas',
                'activeMenu'=>'5' 
              ])

@section('content')

<div class="card card-primary shadow">
    <div class="card-header">
        <h3 class="card-title">Crear Notas</h3>
    </div>
    <!-- /.card-header -->
    <form role="form" method="POST"  action="{{route('notes.store')}}"  accept-charset="UTF-8"  enctype="multipart/form-data">
        @csrf
        @method('POST')

        {{-- @if (Session::has('success'))
        <div class="alert alert-success alert-block shadow">
            <button type="button" class="close" data-dismiss="alert">×</button>	
                <strong>{{Session::get('success') }}</strong>        
        </div> --}}
         {{-- {{ var_dump(  $success) }}
         {{ Session::forget('success') }}
         {{ var_dump(  Session::get('success') ) }} --}}
        {{-- @endif --}}

        <div class="card-body">
            
            <div class="form-row">
                <div class="col-md-3">
                  <!-- text input -->
                    <div class="form-group">
                        <label>Titulo</label>
                        <input type="text" name="title" id="title"  class="form-control" placeholder="Titulo" value="{{old('title') ?? '' }}" >
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                    <label>Contenido</label>
                    <input type="text" name="content" id="content"  class="form-control" placeholder="Nota" value="{{old('content') ?? '' }}" >
                  </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12">
                    <!-- text input -->
                      <div class="form-group">
                          <label>Ruta</label>
                          <input type="file" name="document" id="document"  class="form-control" placeholder="Seleccione" >
                      </div>
                  </div>
  
            </div>
        
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary" name="guardar" vuale="guardar" >Guardar</button>
            <a href="{{ route('roles.index') }}"  type="button" class="btn btn-default float-right"  name="cancelar" vuale="cancelar"  >Cancelar</a>
        </div>
    </form>
</div>
  <!-- /.card -->


    <table>
        <thead>
            <th>ID</th>
            <th>Título</th>
            <th>Contenido</th>
            <th>Soporte</th>
            <th>Acción</th>

        </thead>
        <tbody>
            @foreach ($notes as $note)
                <tr>
                    <td>{{ $note->id }}</td>
                    <td>{{ $note->title }}</td>
                    <td>{{ $note->content }}</td>

                    <td><a href="{{ asset('/storage/'.$note->document) }}" target="_blank" rel="noopener noreferrer">{{$note->document}}</a> </td>
                    
                    <td>
                        @can('destroy_notes')
                            <a href="{{ route('notes.destroy', $note->id) }}">Eliminar nota</a>
                        @else
                            Usted no puede eliminar esta nota
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endsection
