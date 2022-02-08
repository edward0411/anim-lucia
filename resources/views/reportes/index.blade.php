@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Reportes','Reporte Detallado'],
                'title'=>'Reporte Detallado',
                'activeMenu'=>'23'
              ])

@section('content')


    <div class="row">
        <div class="col-12">
            <!-- general form elements disabled -->


            <div class="card card-primary shadow">

            <div class="card-header">
                <h3 class="card-title">Listado de Reportes</h3>
            </div>
         <div class="card_body">
             <div class="form-row">
              <div class="col-lg-12">
                 <div class="card-header">
                      <h3 class="card-title" style="color:#0072C6;border:0px;"><b>Reportes Modulo Técnico</b></h3>
                  </div>
                <div class="info-box">
                  <div class="info-box-content">
                   
                  @can('reportes.listado_reportes.consulta_seguimiento_proyecto.ver')
                  <a href="{{route('informe_seguimiento_proyectos.informe_seguimiento_index')}}" class="btn btn-outline-primary btn-sm btn-block">Ficha Proyecto <i class="fas fa-arrow-circle-right"></i></a>
                  @endcan 
                  @can('reportes.listado_reportes.reporte_proyectos_fases.ver')
                  <a href="{{route('reportes.reporte_proyectos_fases.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte Programación Proyectos <i class="fas fa-arrow-circle-right"></i></a>
                  @endcan
                  @can('reportes.listado_reportes.reporte_proyectos_actividades_planeacion.ver')
                  <a href="{{route('reportes.reporte_proyectos_actividades_planeacion.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte planeación proyectos<i class="fas fa-arrow-circle-right"></i></a>
                  @endcan
                  @can('reportes.listado_reportes.reporte_proyectos_caracteristicas.ver')
                  <a href="{{route('reportes.reporte_proyectos_caracteristicas.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte proyectos caracteristicas <i class="fas fa-arrow-circle-right"></i></a>
                  @endcan
                  @can('reportes.listado_reportes.reporte_proyectos.ver')
                  <a href="{{route('reportes.reporte_proyectos.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte basico proyectos <i class="fas fa-arrow-circle-right"></i></a>
                  @endcan
                  <!--eliminar segun solicitus de Carlos Neysa en actualización de reportes
                  @can('reportes.listado_reportes.reporte_proyectos_actividades.ver')
                  <a href="{{route('reportes.reporte_proyectos_actividades.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte de proyectos actividades <i class="fas fa-arrow-circle-right"></i></a> 
                  @endcan
                  -->
                  @can('reportes.listado_reportes.reporte_proyectos_convenios.ver')
                  <a href="{{route('reportes.reporte_proyectos_convenios.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte de proyectos convenios <i class="fas fa-arrow-circle-right"></i></a>
                  @endcan
                    
                  <a href="{{route('reportes.reporte_avance_ejecucion.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte de programación y ejecución general de actividades<i class="fas fa-arrow-circle-right"></i></a>
                  <a href="{{route('reportes.reporte_ejecucion_actualizada.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte de programación y ejecución detallado de actividades<i class="fas fa-arrow-circle-right"></i></a>
                  <a href="{{route('reportes.reporte_proyectos_licencias.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte proyectos licencias <i class="fas fa-arrow-circle-right"></i></a>
                  <a href="{{route('reportes.informe_supervision.index')}}" class="btn btn-outline-primary btn-sm btn-block">Informe de seguimiento proyectos<i class="fas fa-arrow-circle-right"></i></a>
                   
                </div>
                <div class="info-box-content">
                  
                    <a href="{{route('reportes.reporte_gestion_ambiental_fuentes.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte de gestión ambiental fuentes de materiales <i class="fas fa-arrow-circle-right"></i></a>
                    <a href="{{route('reportes.reporte_gestiones_sociales.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte de gestión social <i class="fas fa-arrow-circle-right"></i></a>
                    <a href="{{route('reportes.reporte_control_seguridad_industrial.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte control de seguridad industrial <i class="fas fa-arrow-circle-right"></i></a>
                    <a href="{{route('reportes.reporte_gestion_ambiental_permisos.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte de gestión ambiental de permisos <i class="fas fa-arrow-circle-right"></i></a>
                    <a href="{{route('reportes.reporte_control_calidad.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte control de calidad <i class="fas fa-arrow-circle-right"></i></a>
                    <!--Segun solicitud de Cros Neysa
                    <a href="{{route('reportes.reporte_control_actividades_realizadas.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte Calidad y Seguridad Industrial<i class="fas fa-arrow-circle-right"></i></a>  
                    <a href="{{route('reportes.reporte_pesos_porcentuales_actividades.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte Seguimiento Sin Pesos Porcentuales<i class="fas fa-arrow-circle-right"></i></a>
                    -->
                    <a href="{{route('reportes.reporte_avance_porcentual_proyectos.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte ejecutivo ejecución proyectos <i class="fas fa-arrow-circle-right"></i></a>
                    <a href="{{route('reportes.reporte_personas_asignadas_proyectos.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte personas asignadas proyectos <i class="fas fa-arrow-circle-right"></i></a>
                    <a href="{{route('reportes.reporte_bitacoras_proyectos.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte bitacora proyectos <i class="fas fa-arrow-circle-right"></i></a>
                    <a href="{{route('reportes.reporte_balance_proyectos_contratos.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte balance proyectos contratos <i class="fas fa-arrow-circle-right"></i></a>

                </div>
                </div>

              </div>
                <div class="col-lg-12">
                  <div class="card-header">
                    <h3 class="card-title" style="color:#0072C6;border:0px;text-align:center;" ><b>Reportes modulo contractual</b></h3>
                </div>
                    <div class="info-box">
                      <div class="info-box-content">
                        
                       @can('reportes.listado_reportes.reporte_detallado_convenios.ver')
                        <a href="{{route('reportes.reporte_detallado_convenio.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte detallado de convenios <i class="fas fa-arrow-circle-right"></i></a>
                        @endcan
                        @can('reportes.listado_reportes..reporte_detallado_contrato_derivado.ver')
                        <a href="{{route('reportes.reporte_detallado_contrato_derivados.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte detallado de contrato derivado <i class="fas fa-arrow-circle-right"></i></a>
                        @endcan
                       @can('reportes.listado_reportes..reporte_detallado_pad.ver')
                        <a href="{{route('reportes.reporte_detallado_pads.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte detallado de PADS <i class="fas fa-arrow-circle-right"></i></a>
                        @endcan
                       @can('reportes.listado_reportes.reporte_convenios_entidades.ver')
                        <a href="{{route('reportes.reporte_convenio_entidades.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte de convenios y entidades <i class="fas fa-arrow-circle-right"></i></a>
                        @endcan
                        @can('reportes.listado_reportes.reporte_terceros.ver')
                        <a href="{{route('reportes.reporte_terceros.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte de terceros <i class="fas fa-arrow-circle-right"></i></a> 
                        @endcan
                                         
                       </div>
                       <div class="info-box-content">
                       
                        @can('reportes.listado_reportes.reporte_convenio_contrato_tercero.ver')
                        <a href="{{route('reportes.reporte_convenio_contratos_terceros.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte convenio contrato tercero <i class="fas fa-arrow-circle-right"></i></a>
                        @endcan
                        @can('reportes.listado_reportes.reporte_terceros_cuentas_bancarias.ver')
                        <a href="{{route('reportes.reporte_terceros_cuentas_bancarias.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte de terceros cuentas bancarias <i class="fas fa-arrow-circle-right"></i></a>
                        @endcan                    
                        @can('reportes.listado_reportes.reporte_contratos_polizas.ver')
                        <a href="{{route('reportes.reporte_contrato_polizas.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte Contratos Polizas <i class="fas fa-arrow-circle-right"></i></a>
                        @endcan
                        
                        <a href="{{route('reportes.reporte_consolidado_contratos.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte de consolidado de Contratos <i class="fas fa-arrow-circle-right"></i></a>
                        <a href="{{route('reportes.reporte_vencimiento_contratos.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte Vencimiento de Contratos <i class="fas fa-arrow-circle-right"></i></a>

                       </div>
                    </div>
                  </div>
             </div>
             <div class="col-lg-12">
              <div class="card-header">
                <h3 class="card-title" style="color:#0072C6;border:0px;text-align:center;"><b>Reportes modulo financiero</b></h3>
            </div>
              <div class="info-box">
                <div class="info-box-content">
                    @can('reportes.listado_reportes.reporte_obligaciones_movimientos.ver')
                    <a href="{{route('reportes.reporte_obligaciones_movimientos.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte obligaciones movimientos <i class="fas fa-arrow-circle-right"></i></a>
                    @endcan                    
                    @can('reportes.listado_reportes.reporte_endosos_movimientos.ver')
                    <a href="{{route('reportes.reporte_endosos_movimientos.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte endosos movimientos <i class="fas fa-arrow-circle-right"></i></a>
                    @endcan
                    @can('reportes.listado_reportes.reporte_rps_movimientos.ver')
                    <a href="{{route('reportes.reporte_rps_movimientos.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte RPS movimientos <i class="fas fa-arrow-circle-right"></i></a>                                         
                    @endcan
                    <a href="{{route('reportes.reporte_saldos_por_pagar.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte Contratos saldos por pagar <i class="fas fa-arrow-circle-right"></i></a>
                </div>
                 <div class="info-box-content">
                    @can('reportes.listado_reportes.reporte_patrimonios_movimientos.ver')
                    <a href="{{route('reportes.reporte_patrimonios_movimientos.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte patrimonios movimientos <i class="fas fa-arrow-circle-right"></i></a>
                    @endcan
                    @can('reportes.listado_reportes.reporte_cdr_movimientos.ver')
                    <a href="{{route('reportes.reporte_cdr_movimientos.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte CDR movimientos <i class="fas fa-arrow-circle-right"></i></a>
                    @endcan
                    <a href="{{route('reportes.reporte_pads_consolidado.index')}}" class="btn btn-outline-primary btn-sm btn-block">Reporte Consolidado Pads<i class="fas fa-arrow-circle-right"></i></a>
                 </div>
              </div>
            </div>
         </div>

        </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

@endsection







