<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FICHA PROYECTO</title>
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.css') }}">
    <style>
        table,
        th,
        td {

            border-collapse: collapse;
            padding: 3px;
            border-spacing: 1px;
            vertical-align: top;
            font-size: 9px;

        }

        .tableborder0 {
            border: 2px solid black;
            border-collapse: collapse;
            padding: 3px;
            border-spacing: 1px;
            vertical-align: top;
            font-size: 9px;
        }

        .tableborder1 {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 3px;
            border-spacing: 1px;
            vertical-align: top;
            font-size: 12px;
            text-align: center;
            width: 100px;

            word-wrap: break-word;

        }

        .tableborder2 {
            border: 2px solid black;
            border-collapse: collapse;
            padding: 3px;
            border-spacing: 1px;
            vertical-align: top;
            font-size: 14px;

        }

        .tableborder3 {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 3px;
            border-spacing: 1px;
            vertical-align: top;
            font-size: 12px;
            text-align: left;

        }

        .tableborder4 {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 3px;
            border-spacing: 1px;
            vertical-align: top;
            font-size: 12px;
            text-align: right;

        }

        .headt td {

            height: 30px;
        }

        table,
        th,
        td {
            font-family: 'Gill Sans', 'Gill Sans MT', 'Calibri', 'Trebuchet MS', sans-serif;

        }

        .boton_1 {
            padding: .375rem .75rem;
            border: 1px solid #007bff;
            border-radius: .25rem;
            color: #ffffff;
            background-color: #007bff;
            margin: 4px 2px;
            cursor: pointer;
            text-transform: uppercase;
        }

        .boton_2 {
            padding: .375rem .75rem;
            border: 1px solid #007bff;
            border-radius: .25rem;
            color: #ffffff;
            background-color: #007bff;
            margin: 4px 2px;
            cursor: pointer;
            float: right;
            text-transform: uppercase;
        }

    </style>
</head>

<body>

    <table class="table table-bordered" height="auto" width="100%" style="border: 2px;">
        <thead>
            <tr class="thead-light">

                <th colspan="3" class="tableborder2" colspan="2">
                    <img src="{{ asset('dist/img/anim_logo_01.jpg') }}" height="70px" width="250px">
                    <img src="{{ asset('/dist/img/anim_logo_anim.png') }}" height="70px" width="300px" alt="">

                </th>
                <th colspan="7" class="tableborder2">
                    <h3>FICHA PROYECTO</h3>
                </th>

                <th colspan="2" class="tableborder0">
                    <br> <br> CO-FO-15 <br> REV. 0<br> MAR 16
                </th>
            </tr>

        </thead>
    </table>

    <table class="table table-bordered" width="100%">
        <tr>
            <?php
            $filas = 2;
            $entidades = '';
            ?>
            @foreach ($Proyectos as $Proyecto)
                <?php
                $filas++;
                $entidades = $entidades . $Proyecto->nombre . ' - ';
                ?>
            @endforeach
            <?php $entidades = trim($entidades, '- '); ?>
            <td colspan="3" rowspan="{{ $filas }}" class="tableborder1">
                <b> {{ $entidades }} </b>
            </td>


            <td colspan="9" class="tableborder1" style="background-color: rgb(0, 102, 255);color: #ffffff;"><b>RELACIÓN
                    CONVENIOS</b></td>


        <tr>
            <td colspan="2" class="tableborder1"><b>NUMERO DEL CONVENIO</b> </td>
            <td colspan="2" class="tableborder1"><b>FECHA TERMINACIÓN</b> </td>
            <td colspan="2" class="tableborder1"><b>FECHA TERMINACIÓN ACTUAL</b> </td>
            <td colspan="2" class="tableborder1"><b>VALOR CONVENIO</b> </td>
            <td colspan="1" class="tableborder1"><b>ESTADO CONVENIO</b> </td>
        </tr>

        @foreach ($Proyectos as $Proyecto)
            <td colspan="2" rowspan="" class="tableborder1"> {{ $Proyecto->numero_contrato }}</td>
            <td colspan="2" class="tableborder1">{{ $Proyecto->fecha_terminacion }}</td>
            <td colspan="2" rowspan="" class="tableborder1">{{ $Proyecto->fecha_terminacion_actual }} </td>
            <td colspan="2" rowspan="" class="tableborder1"> {{ '$' . number_format($Proyecto->valor_actual, 2) }}
            </td>
            <td colspan="1" rowspan="" class="tableborder1">{{ $Proyecto->param_texto_estado_contrato }}</td>


            </tr>
            <tr>
        @endforeach
        </tr>
        <tr>
            <td colspan="12" class="tableborder1" style="background-color: rgb(0, 102, 255);color: #ffffff;">
                <b>PROYECTO</b> </td>

        </tr>
        <tr>
            <td colspan="2" class="tableborder1">
                <b>NOMBRE PROYECTO</b>
            </td>

            <td colspan="3" class="tableborder1">
                <b>COORDINADOR</b>
            </td>
            <td colspan="2" class="tableborder1">
                <b>LIDER</b>
            </td>
            <td colspan="5" class="tableborder1">
                <b>DESCRIPCIÓN DEL PROYECTO</b>
            </td>
        </tr>

        <tr>
            <td colspan="2" class="tableborder1">
                @if ($Proyectos->count() > 0)
                    {{ $Proyecto->nombre_proyecto }}
                @endif
            </td>

            <td colspan="3" class="tableborder1">
                @if ($personas->count() > 0)
                    {{ $personas[0]->coordinador }}
                @endif
            </td>
            <td colspan="2" class="tableborder1">
                @if ($personas->count() > 0)
                    {{ $personas[0]->Lider }}
                @endif
            </td>
            <td colspan="5" class="tableborder1">
                @if ($Proyectos->count() > 0)
                    {{ $Proyecto->objeto_proyecto }}
                @endif
            </td>

        </tr>

        <tr>

            <td colspan="12" rowspan="" class="tableborder1" style="background-color: rgb(0, 102, 255);color: #ffffff;">
                <b>LICENCIAS</b></td>
        </tr>
        <tr>
            <td colspan="4" class="tableborder1"><b>TIPO DE LICENCIA</b> </td>
            <td colspan="4" class="tableborder1"><b>FECHA DE EXPEDICIÓN</b> </td>
            <td colspan="4" class="tableborder1"><b>FECHA TERMINACIÓN</b> </td>
        </tr>
        @foreach ($licencias as $licencia)
            <tr>
                <td colspan="4" class="tableborder1">{{ $licencia->param_tipo_licencia_texto }}</td>
                <td colspan="4" class="tableborder1">{{ $licencia->fecha_expedicion }}</td>
                <td colspan="4" class="tableborder1">{{ $licencia->fecha_terminacion }}</td>
            </tr>
        @endforeach



        <tr>
            <td colspan="12" class="tableborder1" style="background-color: rgb(0, 102, 255);color: #ffffff;">
                <b>RELACIÓN CONTRATOS </b>
            </td>
        </tr>

        <tr>
            <td colspan="3" class="tableborder1">
                <b>NOMBRE CONTRATISTA</b>
            </td>
            <td colspan="1" class="tableborder1">
                <b> No. CONTRATO</b>
            </td>
            <td colspan="3" class="tableborder1">
                <b> OBJETO CONTRATO</b>
            </td>
            <td colspan="1" class="tableborder1">
                <b>VALOR</b>
            </td>
            <td colspan="1" class="tableborder1">
                <b> FECHA INICIO</b>
            </td>
            <td colspan="1" class="tableborder1">
                <b>FECHA TERMINACIÓN</b>
            </td>
            <td colspan="1" class="tableborder1">
                <b>FECHA TERMINACIÓN ACTUAL</b>
            </td>
            <td colspan="1" class="tableborder1">
                <b> ESTADO</b>
            </td>
        </tr>
        <?php $valor = 0; ?>
        @foreach ($contratos as $contrato)
            <tr>
                <td colspan="3" class="tableborder1">
                    {{ $contrato->nombre }}
                </td>
                <td colspan="1" class="tableborder1">
                    {{ $contrato->numero_contrato }}
                </td>
                <td colspan="3" class="tableborder1">
                    {{ $contrato->objeto_contrato }}
                </td>
                <td colspan="1" class="tableborder1">
                    {{ '$' . number_format($contrato->valor_actual, 2) }}
                    <?php $valor = $valor + $contrato->valor_actual; ?>
                </td>
                <td colspan="1" class="tableborder1">
                    {{ $contrato->fecha_inicio }}
                </td>
                <td colspan="1" class="tableborder1">
                    {{ $contrato->fecha_terminacion }}
                </td>
                <td colspan="1" class="tableborder1">
                    {{ $contrato->fecha_terminacion_actual }}
                </td>
                <td colspan="1" class="tableborder1">
                    {{ $contrato->param_texto_estado_contrato }}
                </td>
            </tr>
        @endforeach

        <tr>
            <td colspan="3" class="tableborder1">
                <b>TOTAL</b>
            </td>
            <td colspan="1" class="tableborder1">

            </td>
            <td colspan="3" class="tableborder1">

            </td>
            <td colspan="1" class="tableborder1">
                {{ '$' . number_format($valor, 2) }}
            </td>
            <td colspan="1" class="tableborder1">

            </td>
            <td colspan="1" class="tableborder1">

            </td>
            <td colspan="1" class="tableborder1">

            </td>
            </td>
            <td colspan="1" class="tableborder1">

            </td>
        </tr>

        <tr>
            <td colspan="12" class="tableborder1" style="background-color: rgb(0, 102, 255);color: #ffffff;">
                <b>CARACTERISTICAS ASOCIADAS</b></td>

        </tr>
        <tr>
            <td colspan="6" class="tableborder1"><b>NOMBRE</b></td>
            <td colspan="6" class="tableborder1"><b>DESCRIPCIÓN</b></td>

        </tr>
        @foreach ($caracteristicas as $caracteristica)
            <tr>
                <td colspan="6" class="tableborder1">{{ $caracteristica->param_tipo_proyecto_caracteristica_texto }}
                </td>
                <td colspan="6" class="tableborder1">{{ $caracteristica->decripcion_proyecto }}</td>
            </tr>

        @endforeach
        <tr>
            <td colspan="12" class="tableborder1" style="background-color: rgb(0, 102, 255);color: #ffffff;"><b>RECURSOS
                    FINANCIEROS</b></td>

        </tr>
        <tr>
            <td colspan="2" class="tableborder1"><b>NOMBRE DEL PAD</b></td>
            <td class="tableborder1"><b>VALOR DEFINIDO</b></td>
            <td class="tableborder1"><b>VALOR APORTADO</b></td>
            <td colspan="2" class="tableborder1"><b>VALOR PENDIENTE POR RECAUDAR</b></td>
            <td class="tableborder1"><b>VALOR RENDIMIENTOS FINANCIEROS</b></td>
            <td class="tableborder1"><b>VALOR TOTAL PROYECTO</b></td>
            <td class="tableborder1"><b>VALOR COMPROMETIDO</b></td>
            <td colspan="2" class="tableborder1"><b>VALOR PAGOS</b></td>
            <td class="tableborder1"><b>DISPONIBLE PROYECTO</b></td>

        </tr>
        @php
            
            $t1 = 0;
            $t2 = 0;
            $t3 = 0;
            $t4 = 0;
            $t5 = 0;
            $t6 = 0;
            $t7 = 0;
            $t8 = 0;
            
        @endphp
        @foreach ($recursos as $value)

            @php
                
                $t1 = $t1 + $value->valor_definido;
                $t2 = $t2 + $value->valor_aportado;
                $t3 = $t3 + ($value->valor_definido - $value->valor_aportado);
                $t4 = $t4 + $value->valor_rendimientos;
                $t5 = $t5 + ($value->valor_definido + $value->valor_rendimientos);
                $t6 = $t6 + $value->valor_comprometido;
                $t7 = $t7 + $value->valor_pagos;
                $t8 = $t8 + ($value->valor_definido + $value->valor_rendimientos - $value->valor_comprometido);
              
            @endphp

            <tr>
                <td colspan="2" class="tableborder1">
                    {{ $value->numero_contrato }}
                </td>
                <td class="tableborder1">
                    $ {{ number_format($value->valor_definido, 2) }}
                </td>
                <td class="tableborder1">
                    $ {{ number_format($value->valor_aportado, 2) }}
                </td>
                <td colspan="2" class="tableborder1">
                    $ {{ number_format($value->valor_definido - $value->valor_aportado, 2) }}
                </td>
                <td class="tableborder1">
                    $ {{ number_format($value->valor_rendimientos, 2) }}
                </td>
                <td class="tableborder1">
                    $ {{ number_format($value->valor_definido + $value->valor_rendimientos, 2) }}
                </td>
                <td class="tableborder1">
                    $ {{ number_format($value->valor_comprometido, 2) }}
                </td>
                <td colspan="2" class="tableborder1">
                    $ {{ number_format((int)$value->valor_pagos, 2) }}
                </td>
                <td class="tableborder1">
                    $
                    {{ number_format($value->valor_definido + $value->valor_rendimientos - $value->valor_comprometido, 2) }}
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="2" class="tableborder1"><b>TOTALES: </b></td>
            <td class="tableborder1">$ {{ number_format($t1, 2) }}</td>
            <td class="tableborder1">$ {{ number_format($t2, 2) }}</td>
            <td colspan="2" class="tableborder1">$ {{ number_format($t3, 2) }}</td>
            <td class="tableborder1">$ {{ number_format($t4, 2) }}</td>
            <td class="tableborder1">$ {{ number_format($t5, 2) }}</td>
            <td class="tableborder1">$ {{ number_format($t6, 2) }}</td>
            <td colspan="2" class="tableborder1">$ {{ number_format($t7, 2) }}</td>
            <td class="tableborder1">$ {{ number_format($t8, 2) }}</td>

        </tr>

        <tr>
            <td colspan="12" class="tableborder1"></td>
        </tr>

        </tr>
        <tr>
            <td colspan="2" class="tableborder1"><b>NOMBRE CONTRATISTA</b></td>
            <td colspan="2" class="tableborder1"><b>NÚMERO DEL CONTRATO</b></td>
            <td colspan="2" class="tableborder1"><b>VALOR CONTRATO</b></td>
            <td colspan="2" class="tableborder1"><b>PORCENTAJE EJECUTADO</b></td>
            <td colspan="2" class="tableborder1"><b>VALOR PAGO</b></td>
            <td colspan="2" class="tableborder1"><b>SALDO</b></td>
        </tr>
        @php
            $valorT = 0;
            $porcentajeT = 0;
            $pagoT = 0;
            $saldoT = 0;
        @endphp
        
        @foreach ($contratos as $contrato)
            @php
           
                $valorT = $valorT = $valorT + $contrato->valor_actual;
                if ($contrato->pagos == 0) {
                    $porcentajeT = $porcentajeT + 0;
                }else{
                    $porcentajeT = $porcentajeT + (($contrato->pagos / $contrato->valor_actual) * 100);
                }
                $pagoT = $pagoT + $contrato->pagos;
                $saldoT = $saldoT + ($contrato->valor_actual - $contrato->pagos);
            @endphp
            <tr>
                <td colspan="2" class="tableborder1">
                    {{ $contrato->nombre }}
                </td>
                <td colspan="2" class="tableborder1">
                    {{ $contrato->numero_contrato }}
                </td>

                <td colspan="2" class="tableborder1">
                    $ {{ number_format($contrato->valor_actual, 2) }}
                </td>
                <td colspan="2" class="tableborder1">
                    @if ($contrato->pagos == 0)
                        0.00 %
                    @else
                        {{ number_format(($contrato->pagos / $contrato->valor_actual) * 100, 2) }} %
                    @endif
                </td>
                <td colspan="2" class="tableborder1">
                  
                    $ {{ number_format($contrato->pagos, 2) }}
                </td>
                <td colspan="2" class="tableborder1">
                    $ {{ number_format($contrato->valor_actual - $contrato->pagos, 2) }} 
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="2" class="tableborder1"><b>TOTALES</b></td>
            <td colspan="2" class="tableborder1"></td>
            <td colspan="2" class="tableborder1"> <b>$ {{ number_format($valorT, 2) }} </b></td>
            <td colspan="2" class="tableborder1">
              <b>
                @if($porcentajeT == 0)
                    0.00 %
                @else
                  {{ number_format(($porcentajeT/count($contratos)), 2) }} %
                @endif 
              </b>
            </td>
            <td colspan="2" class="tableborder1"> <b>$ {{ number_format($pagoT, 2) }} </b></td>
            <td colspan="2" class="tableborder1"> <b>$ {{ number_format($saldoT, 2) }} </b></td>
        </tr>

        <tr>
            <td colspan="12" class="tableborder1"></td>

        </tr>
        <tr>
            <td colspan="12" class="tableborder1" style="background-color: rgb(0, 102, 255);color: #ffffff;">
                <b>SEGUIMIENTO PORCENTAJE DE AVANCE</b> </td>

        </tr>

        <tr>
            <td colspan="3" rowspan="2" class="tableborder1"><b>ETAPA</b></td>
            <td colspan="3" class="tableborder1"><b>AVANCE</b></td>
            <td colspan="1" class="tableborder1"><b>INDICADOR %</b></td>
            <td colspan="5" class="tableborder1"><b>AVANCE FINANCIERO</b></td>
        </tr>

        <tr>
            <td colspan="1" class="tableborder1">PROGRAMADO</td>
            <td colspan="2" class="tableborder1">EJECUTADO</td>
            <td colspan="1" rowspan="2" class="tableborder1"></td>
            <td colspan="3" class="tableborder1">PROGRAMADO</td>
            <td colspan="3" class="tableborder1">EJECUTADO</td>

        </tr>
        <tr>


        </tr>
        <?php $fila = 0; ?>
        @foreach ($tecnicos as $tecnico)
            <?php $fila = $fila + 1; ?>
        @endforeach
        <?php $i = 1; ?>
        @foreach ($tecnicos as $tecnico)
            <tr>
                <td colspan="3" rowspan="1" class="tableborder1">{{ $tecnico->param_tipo_fase_texto }} </td>
                <td colspan="1" class="tableborder1">{{ number_format($tecnico->porcentaje_programado, 2) }}%</td>
                <td colspan="2" class="tableborder1">{{ number_format($tecnico->porcentaje_ejecutado, 2) }}%</td>
                <?php $semaforo = $tecnico->porcentaje_programado - $tecnico->porcentaje_ejecutado; ?>
                @if ($semaforo <= 5)
                    <td colspan="1" class="tableborder1" bgcolor="green"></td>

                @elseif ($semaforo<=10) <td colspan="1" class="tableborder1" bgcolor="yellow">
                        </td>
                    @else
                        <td colspan="1" class="tableborder1" bgcolor="red"></td>
                @endif
                @if ($i == 1)
                    @if ($sum_prog > 0)
                        <td colspan="3" rowspan="{{ $fila }}" class="tableborder1">
                            {{ round(($sum_prog / $valor) * 100, 2) }}% </td>
                    @else
                        <td colspan="3" rowspan="{{ $fila }}" class="tableborder1"> 0% </td>
                    @endif

                    @if ($sum_eject > 0)
                        <td colspan="3" rowspan="{{ $fila }}" class="tableborder1">
                            {{ round(($sum_eject / $valor) * 100, 2) }}% </td>
                    @else
                        <td colspan="3" rowspan="{{ $fila }}" class="tableborder1"> 0% </td>
                    @endif
                @endif

            </tr>
            <?php $i = $i + 1; ?>
        @endforeach


    </table>

    <div class="row">
        <div class="col-6">
            <!-- general form elements disabled -->
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <canvas id="myChart" width="1000px" height="300px"></canvas>
                            <canvas id="myChart_1" width="1000px" height="150%"></canvas>

                        </div>
                    </div>
                </div>

            </div>


        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <table class="table table-bordered" width="100%">

        <tr>
            <td colspan="12" class="tableborder1" style="background-color: rgb(0, 102, 255);color: #ffffff;"><b>GESTIÓN
                    SEMANA</b></td>

        </tr>
        <tr>
            <td colspan="1" class="tableborder1"><b>FECHA</b> </td>
            <td colspan="11" class="tableborder1"><b>ACCIONES REALIZADAS</b></td>
        </tr>



        @foreach ($bitacoras as $bitacora)
            @foreach ($bitacora as $detalle)
                <tr>
                    <td colspan="1" class="tableborder1">
                        {{ $detalle->fecha }}
                    </td>
                    <td colspan="11" class="tableborder1">
                        <p align="left"> {{ $detalle->Descripcion_gestion }}</p>
                    </td>
                </tr>
            @endforeach
        @endforeach
        <tr>
            <td colspan="12" class="tableborder1" style="background-color: rgb(0, 102, 255);color: #ffffff;"><b>GESTIÓN
                    SEMANA (REPORTADA EN COMITÉ ANTERIOR)</b></td>

        </tr>
        <tr>
            <td colspan="1" class="tableborder1"><b>FECHA</b> </td>
            <td colspan="11" class="tableborder1">
                <b>ACCIONES REALIZADAS</b>
            </td>
        </tr>


        @foreach ($bitacoras_anterior as $bitacora)
            @foreach ($bitacora as $detalle)
                <tr>
                    <td colspan="1" class="tableborder1">
                        {{ $detalle->fecha }}
                    </td>
                    <td colspan="11" class="tableborder1">
                        <p align="left"> {{ $detalle->Descripcion_gestion }}</p>
                    </td>
                </tr>
            @endforeach
        @endforeach

        <tr>
            <td colspan="12" class="tableborder1"></td>
        </tr>
        <tr>
            <td colspan="12" class="tableborder1" style="background-color: rgb(0, 102, 255);color: #ffffff;"><b>GESTIÓN
                    SOCIAL</b> </td>

        </tr>

        <?php $id_gestion_social = ''; ?>
        @foreach ($gestiones_sociales as $gestion_social)
            <tr>
                <td colspan="12" class="tableborder1" style="background-color: #888"><b>CONTRATO</b> </td>
            </tr>
            <tr>
                <td colspan="3" class="tableborder1"><b>No</b></td>
                <td colspan="3" class="tableborder1"><b>FECHA</b></td>
                <td colspan="3" class="tableborder1"><b>CONTRATO</b></td>
                <td colspan="3" class="tableborder1"><b>RESPONASABLE</b></td>
            </tr>
            <tr>
                <td colspan="3" class="tableborder1">{{ $gestion_social->consecutivo }}</td>
                <td colspan="3" class="tableborder1">{{ $gestion_social->fecha_informe }}</td>
                <td colspan="3" class="tableborder1">{{ $gestion_social->numero_contrato }}</td>
                <td colspan="3" class="tableborder1">{{ $gestion_social->name }}</td>
            </tr>
            <tr>
                <td colspan="12" class="tableborder1"><b>CARACTERISTICAS</b> </td>

            </tr>

            <tr>
                <td colspan="3" class="tableborder1"><b>CARACTERISTICAS</b></td>
                <td colspan="3" class="tableborder1"><b>VALOR</b></td>
                <td colspan="6" class="tableborder1"><b>OBSERVACIONES</b></td>
            </tr>
            @foreach ($gestiones_sociales_detalles as $gestiones_sociales_detalle)

                @if ($gestiones_sociales_detalle->id_gestion_social == $gestion_social->id_gestion_social)
                    <tr>
                        <td colspan="3" class="tableborder1">
                            {{ $gestiones_sociales_detalle->param_caracteristicas_texto }}</td>
                        <td colspan="3" class="tableborder1">{{ $gestiones_sociales_detalle->valor }}</td>
                        <td colspan="6" class="tableborder1">
                            <p align="left">{{ $gestiones_sociales_detalle->observaciones }}</p>
                        </td>
                    </tr>
                @endif
            @endforeach
            <tr>
                <td colspan="12" class="tableborder1"><b>BITACORA GESTION SOCIAL</b> </td>
            </tr>
            <tr>
                <td colspan="3" class="tableborder1"><b>FECHA</b></td>
                <td colspan="6" class="tableborder1"><b>DESCRIPCIÓN DE GESTIÓN</b></td>
                <td colspan="3" class="tableborder1"><b>VINCULO</b></td>
            </tr>
            @foreach ($gestiones_sociales_bitacora as $gestion_bitacora)
                @if ($gestion_bitacora->id_gestion_social == $gestion_social->id_gestion_social)
                    <tr>
                        <td colspan="3" class="tableborder1">{{ $gestion_bitacora->fecha }}</td>
                        <td colspan="6" class="tableborder1">
                            <p align="left"></p>{{ $gestion_bitacora->descripcion_gestion }}
                        </td>
                        <td colspan="3" class="tableborder1">
                            <p>{{ $gestion_bitacora->vinculo }}</p>
                        </td>
                    </tr>
                @endif
            @endforeach
        @endforeach
        <tr>
            <td colspan="12" class="tableborder1"></td>
        </tr>

        <tr>
            <td colspan="12" class="tableborder1" style="background-color: rgb(0, 102, 255);color: #ffffff;"><b>GESTIÓN
                    AMBIENTAL</b> </td>
        </tr>
        @foreach ($gestiones_ambientales as $gestiones_ambiental)
            <tr>
                <td colspan="12" class="tableborder1"><b>CONTRATO</b> </td>
            </tr>
            <tr>
                <td colspan="3" class="tableborder1"><b>No</b></td>
                <td colspan="3" class="tableborder1"><b>FECHA</b></td>
                <td colspan="3" class="tableborder1"><b>CONTRATO</b></td>
                <td colspan="3" class="tableborder1"><b>RESPONASABLE</b></td>
            </tr>

            <tr>
                <td colspan="3" class="tableborder1">{{ $gestiones_ambiental->consecutivo }}</td>
                <td colspan="3" class="tableborder1">{{ $gestiones_ambiental->fecha_informe }}</td>
                <td colspan="3" class="tableborder1">{{ $gestiones_ambiental->numero_contrato }}</td>
                <td colspan="3" class="tableborder1">{{ $gestiones_ambiental->name }}</td>
            </tr>

            <tr>
                <td colspan="12" class="tableborder1"><b>FUENTES DE MATERIALES</b> </td>
            </tr>

            <tr>
                <td colspan="2" class="tableborder1"><b>DEDPARTAMENTO</b></td>
                <td colspan="2" class="tableborder1"><b>MUNICIPIO</b></td>
                <td colspan="2" class="tableborder1"><b>UBICACIÓN</b></td>
                <td colspan="2" class="tableborder1"><b>PERMISO MINERO</b></td>
                <td colspan="2" class="tableborder1"><b>PERMISO AMBIENTAL</b></td>
                <td colspan="2" class="tableborder1"><b>OBSERVACIONES</b></td>
            </tr>
            @foreach ($gestiones_ambientales_fuentes as $gestiones_ambiental_fuente)

                @if ($gestiones_ambiental->id_gestiones_ambientales == $gestiones_ambiental_fuente->id_gestiones_ambientales)
                    <tr>
                        <td colspan="2" class="tableborder1">{{ $gestiones_ambiental_fuente->nombre_departamento }}
                        </td>
                        <td colspan="2" class="tableborder1">{{ $gestiones_ambiental_fuente->nombre_municipio }}</td>
                        <td colspan="2" class="tableborder1">{{ $gestiones_ambiental_fuente->ubicacion }}</td>
                        <td colspan="2" class="tableborder1">{{ $gestiones_ambiental_fuente->permiso }}</td>
                        <td colspan="2" class="tableborder1">{{ $gestiones_ambiental_fuente->FuenteMateriales }}</td>
                        <td colspan="2" class="tableborder1">{{ $gestiones_ambiental_fuente->observaciones }}</td>
                    </tr>


                @endif
            @endforeach
            <tr>
                <td colspan="12" class="tableborder1"><b>PERMISOS AMBIENTALES</b> </td>
            </tr>
            <tr>
                <td colspan="3" class="tableborder1"><b>TIPO DE PERMISO</b></td>
                <td colspan="3" class="tableborder1"><b>DOCUMENTO SOPORTE</b></td>
                <td colspan="3" class="tableborder1"><b>SEGUIMIENTO</b></td>
                <td colspan="3" class="tableborder1"><b>OBSERVACIONES</b></td>
            </tr>
            @foreach ($gestiones_ambientales_permisos as $gestiones_ambientales_permiso)

                @if ($gestiones_ambiental->id_gestiones_ambientales == $gestiones_ambientales_permiso->id_gestiones_ambientales)
                    <tr>
                        <td colspan="3" class="tableborder1">
                            {{ $gestiones_ambientales_permiso->param_tipo_permiso_text }}</td>
                        <td colspan="3" class="tableborder1">{{ $gestiones_ambientales_permiso->documento_soporte }}
                        </td>
                        <td colspan="3" class="tableborder1">{{ $gestiones_ambientales_permiso->seguimiento }}</td>
                        <td colspan="3" class="tableborder1">{{ $gestiones_ambientales_permiso->observaciones }}</td>
                    </tr>
                @endif
            @endforeach
            <tr>
                <td colspan="12" class="tableborder1"><b>BITACORA GESTION AMBIENTAL</b> </td>
            </tr>
            <tr>
                <td colspan="3" class="tableborder1"><b>FECHA</b></td>
                <td colspan="6" class="tableborder1"><b>DESCRIPCIÓN DE GESTIÓN</b></td>
                <td colspan="3" class="tableborder1"><b>VINCULO</b></td>
            </tr>
            @foreach ($gestiones_ambientales_bitacora as $gestion_bitacora)
                @if ($gestiones_ambiental->id_gestiones_ambientales == $gestion_bitacora->id_gestion_ambiental)
                    <tr>
                        <td colspan="3" class="tableborder1">{{ $gestion_bitacora->fecha }}</td>
                        <td colspan="6" class="tableborder1">
                            <p align="left"></p>{{ $gestion_bitacora->descripcion_gestion }}
                        </td>
                        <td colspan="3" class="tableborder1">
                            <p>{{ $gestion_bitacora->vinculo }}</p>
                        </td>
                    </tr>
                @endif
            @endforeach
        @endforeach
        <tr>
            <td colspan="12" class="tableborder1"></td>
        </tr>

        <tr>
            <td colspan="12" class="tableborder1" style="background-color: rgb(0, 102, 255);color: #ffffff;"><b>GESTIÓN
                    DE CALIDAD Y SEGURIDAD INDUSTRIAL</b> </td>
        </tr>
        @foreach ($calidad_seguridad_industriales as $calidad_seguridad_industrial)
            <tr>
                <td colspan="12" class="tableborder1"><b>CONTRATO</b> </td>
            </tr>
            <tr>
                <td colspan="3" class="tableborder1"><b>No</b></td>
                <td colspan="3" class="tableborder1"><b>FECHA</b></td>
                <td colspan="3" class="tableborder1"><b>CONTRATO</b></td>
                <td colspan="3" class="tableborder1"><b>RESPONASABLE</b></td>
            </tr>

            <tr>
                <td colspan="3" class="tableborder1">{{ $calidad_seguridad_industrial->consecutivo }}</td>
                <td colspan="3" class="tableborder1">{{ $calidad_seguridad_industrial->fecha_informe }}</td>
                <td colspan="3" class="tableborder1">{{ $calidad_seguridad_industrial->numero_contrato }}</td>
                <td colspan="3" class="tableborder1">{{ $calidad_seguridad_industrial->name }}</td>
            </tr>

            <tr>
                <td colspan="12" class="tableborder1"><b>CONTROL DE INSPECCIÓN DE ENSAYOS</b> </td>
            </tr>


            @foreach ($calidad_seguridad_industriales_inspecciones as $calidad_seguridad_industriales_inspeccion)
                @if ($calidad_seguridad_industrial->id_calidad_seguridad_industrial == $calidad_seguridad_industriales_inspeccion->id_calidad_seguridad_industrial)
                    <tr>
                        <td colspan="3" class="tableborder1"><b>CONTROL DE INSPECCIÓN DE ENSAYOS</b></td>
                        <td colspan="2" class="tableborder1"><b>TIPO DE PRUEBA</b></td>
                        <td colspan="2" class="tableborder1"><b>FECHA DE TOMA DE LA PRUEBA</b></td>
                        <td colspan="2" class="tableborder1"><b>UNIDAD EJECUTORA</b></td>
                        <td colspan="3" class="tableborder1"><b>NOMBRE ESPECIALISTA</b></td>

                    </tr>
                    <tr>
                        <td colspan="3" class="tableborder1">
                            {{ $calidad_seguridad_industriales_inspeccion->control_inspeccion_ensayos }}</td>
                        <td colspan="2" class="tableborder1">
                            {{ $calidad_seguridad_industriales_inspeccion->param_tipo_prueba_texto }}</td>
                        <td colspan="2" class="tableborder1">
                            {{ $calidad_seguridad_industriales_inspeccion->fecha_toma_prueba }}</td>
                        <td colspan="2" class="tableborder1">
                            {{ $calidad_seguridad_industriales_inspeccion->unidad_ejecutora }}</td>
                        <td colspan="3" class="tableborder1">
                            {{ $calidad_seguridad_industriales_inspeccion->nombre_especialista }}</td>

                    </tr>
                    <tr>
                        <td colspan="3" class="tableborder1"><b>LOCALIZACIÓN</b></td>
                        <td colspan="3" class="tableborder1"><b>RESULTADOS DE LA PRUEBA</b></td>
                        <td colspan="3" class="tableborder1"><b>FECHA RESULTADO DE LA PRUEBA</b></td>
                        <td colspan="3" class="tableborder1"><b>RECOMENDACIONES</b></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="tableborder1">
                            {{ $calidad_seguridad_industriales_inspeccion->localizacion }}</td>
                        <td colspan="3" class="tableborder1">
                            {{ $calidad_seguridad_industriales_inspeccion->resultados_prueba }}</td>
                        <td colspan="3" class="tableborder1">
                            {{ $calidad_seguridad_industriales_inspeccion->fecha_resultado_prueba }}</td>
                        <td colspan="3" class="tableborder1">
                            {{ $calidad_seguridad_industriales_inspeccion->recomendaciones }}</td>
                    </tr>
                @endif
            @endforeach
            <tr>
                <td colspan="12" class="tableborder1"><b>CONTROL DE EQUIPOS EN OBRA</b> </td>
            </tr>

            <tr>
                <td colspan="2" class="tableborder1"><b>CONTROL DE EQUIPOS EN OBRA</b></td>
                <td colspan="4" class="tableborder1"><b>OBSERVACIONES</b></td>
                <td colspan="2" class="tableborder1"><b>ACTIVIDAD O LABOR REALIZADA</b></td>
                <td colspan="2" class="tableborder1"><b>EQUIPO UTILIZADO</b></td>
                <td colspan="2" class="tableborder1"><b>NOMBRE ESPECIALISTA</b></td>
            </tr>
            @foreach ($calidad_seguridad_industriales_obras as $calidad_seguridad_industriales_obra)
                @if ($calidad_seguridad_industrial->id_calidad_seguridad_industrial == $calidad_seguridad_industriales_obra->id_calidad_seguridad_industrial)
                    <tr>
                        <td colspan="2" class="tableborder1">
                            {{ $calidad_seguridad_industriales_obra->control_equipos_obra }}</td>
                        <td colspan="4" class="tableborder1">
                            {{ $calidad_seguridad_industriales_obra->recomendaciones }}</td>
                        <td colspan="2" class="tableborder1">
                            {{ $calidad_seguridad_industriales_obra->actividad_labor_realizada }}</td>
                        <td colspan="2" class="tableborder1">
                            {{ $calidad_seguridad_industriales_obra->equipo_utilizado }}</td>
                        <td colspan="2" class="tableborder1">
                            {{ $calidad_seguridad_industriales_obra->nombre_especialista }}</td>
                    </tr>
                @endif
            @endforeach
            <tr>
                <td colspan="12" class="tableborder1"><b>CONTROL DE SEGURIDAD INDUSTRIAL</b> </td>
            </tr>

            <tr>
                <td colspan="3" class="tableborder1"><b>ACCIDENTE LABORAL O INCIDENTE</b></td>
                <td colspan="2" class="tableborder1"><b>TIPO</b></td>
                <td colspan="2" class="tableborder1"><b>FECHA</b></td>
                <td colspan="3" class="tableborder1"><b>PLAN DE MEJORA O LECCIÓN APRENDIDA</b></td>
                <td colspan="2" class="tableborder1"><b>ADOPTADO</b></td>
            </tr>
            @foreach ($calidad_seguridad_industriales_Seguridad as $calidad_seguridad_industriales_Segu)
                @if ($calidad_seguridad_industrial->id_calidad_seguridad_industrial == $calidad_seguridad_industriales_Segu->id_calidad_seguridad_industrial)
                    <tr>
                        <td colspan="3" class="tableborder1">{{ $calidad_seguridad_industriales_Segu->accidente }}
                        </td>
                        <td colspan="2" class="tableborder1">
                            {{ $calidad_seguridad_industriales_Segu->param_tipo_accidente_texto }}</td>
                        <td colspan="2" class="tableborder1">{{ $calidad_seguridad_industriales_Segu->fecha }}</td>
                        <td colspan="3" class="tableborder1">
                            {{ $calidad_seguridad_industriales_Segu->plan_mejora_leccion_aprendida }}</td>
                        @if ($calidad_seguridad_industriales_Segu->adoptado == 1)
                            <td colspan="2" class="tableborder1">NO</td>
                        @else
                            <td colspan="2" class="tableborder1">SI</td>
                        @endif
                    </tr>
                @endif
            @endforeach
            <tr>
                <td colspan="12" class="tableborder1"><b>ACTIVIDADES REALIZADAS</b> </td>
            </tr>

            <tr>
                <td colspan="6" class="tableborder1"><b>DE MEDIDA PREVENTIVA</b></td>
                <td colspan="6" class="tableborder1"><b>ACTIVIDADES DE HIGIENE Y SEGURIDAD INDUSTRIAL</b></td>
            </tr>
            @foreach ($calidad_seguridad_industriales_actividades as $calidad_seguridad_industriales_actividad)
                @if ($calidad_seguridad_industrial->id_calidad_seguridad_industrial == $calidad_seguridad_industriales_actividad->id_calidad_seguridad_industrial)
                    <tr>
                        <td colspan="6" class="tableborder1">
                            {{ $calidad_seguridad_industriales_actividad->de_medida_preventiva }}</td>
                        <td colspan="6" class="tableborder1">
                            {{ $calidad_seguridad_industriales_actividad->actividades_higiene_seguridad_industrial }}
                        </td>
                    </tr>
                @endif
            @endforeach
        @endforeach
        <tr>
            <td colspan="12" class="tableborder1"></td>
        </tr>


        <tr>
            <th colspan="4" class="tableborder1" width="80" height="100">
                <br>
                <br>
                <br>
                _______________________________________________________
                <br>
                @if ($personas->count() > 0)
                    {{ $personas[0]->coordinador }}
                @endif <br>Coordinador del Proyecto
            </th>
            <th colspan="4" class="tableborder1" width="80" height="100">
                <br>
                <br>
                <br>
                _______________________________________________________
                <br>
                @if ($personas->count() > 0)
                    {{ $personas[0]->Lider }}
                @endif <br>Lider del Proyecto
            </th>
            <th colspan="4" class="tableborder1" width="80" height="100">
                <br>
                <br>
                <br>
                _______________________________________________________
                <br>
                @if ($personas->count() > 0)
                    {{ $personas[0]->Supervisor }}
                @endif <br>Supervisor del Proyecto
            </th>
        </tr>
        <tr>
            <td colspan="3" class="tableborder1"><b>FECHA DEL REPORTE</b></td>
            <td colspan="3" class="tableborder1">{{ $fecha_reporte }}</td>
            <td colspan="3" class="tableborder1"><b>HORA DEL REPORTE</b></td>
            <td colspan="3" class="tableborder1">{{ $hora_reporte }}</td>
        </tr>



    </table><br>

    <table class="table table-bordered" width="100%">
        <thead>
            <tr>
                <td colspan="12" class="tableborder1" style="background-color: rgb(0, 102, 255);color: #ffffff;">
                    <b>REGISTRO FOTOGRAFICO</b> </td>
            </tr>
            <tr>
                <td colspan="3" class="tableborder1"><b>FECHA DEL REGISTRO</b></td>
                <td colspan="9" class="tableborder1"><b>IMAGEN</b></td>
            </tr>
        </thead>
        @foreach ($bitacoras_anterior as $bitacora)
            @foreach ($bitacora as $detalle)
                @if ($detalle->image == null || $detalle->image == '')
                @else
                    <tr>
                        <td colspan="3" class="tableborder1"><b>{{ $detalle->fecha }}</b></td>
                        <td colspan="9" class="tableborder1">
                            <img src="{{ asset('images/informes_semanales/' . $detalle->image) }}" id="image-preview"
                                width="400">`;
                        </td>
                    </tr>
                @endif

            @endforeach
        @endforeach
        @foreach ($bitacoras as $bitacora)
            @foreach ($bitacora as $detalle)
                @if ($detalle->image == null || $detalle->image == '')
                @else
                    <tr>
                        <td colspan="3" class="tableborder1"><b>{{ $detalle->fecha }}</b></td>
                        <td colspan="9" class="tableborder1">
                            <img src="{{ asset('images/informes_semanales/' . $detalle->image) }}" id="image-preview"
                                width="400">`;
                        </td>
                    </tr>
                @endif

            @endforeach
        @endforeach
    </table>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

    <script type="text/javascript">
        var ctx = document.getElementById('myChart').getContext('2d');


        @php
        $datosArray = [];
        
        $i = 0;
        
        @endphp

        var dynamicColors = function() {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            return "rgb(" + r + "," + g + "," + b + ")";
        };

        var etapa = ""
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    @foreach ($fechas_array as $key => $fecha)
                        '{{ $fecha }} ',
                    @endforeach
                ],
                datasets: [
                    @php
                    foreach ($datos_procesos_array as $key_fase => $value_fase) {
                        echo "{
                                    label:'$key_fase',
                                    borderColor:   dynamicColors(),
                                    backgroundColor: 'rgb(51, 153, 255)',
                                    fill: false,
                                    data: [
                                      ";
                        $acumulado = 0;
                        foreach ($fechas_array as $key_array => $valor_array) {
                            if (isset($value_fase[$key_array])) {
                                $acumulado += $value_fase[$key_array];
                                echo "'$acumulado',";
                            } else {
                                if ($acumulado == 0) {
                                    echo ',';
                                } else {
                                    if ($acumulado >= 100 || $key_array > $id_semana_parametrica) {
                                        echo ',';
                                    } else {
                                        echo "'$acumulado',";
                                    }
                                }
                            }
                        }
                        echo "
                                    ]
                    
                                  },";
                    }
                    
                    @endphp

                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: false
                        }
                    }]
                }
            }
        });




        var ctx = document.getElementById('myChart_1').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    @foreach ($fechas_array as $key_graf2 => $fecha_key_graf2)
                        '{{ $fecha_key_graf2 }} ',
                    @endforeach
                ],
                datasets: [
                    @php
                    foreach ($datos_semaforo_array as $key_semaforo => $value_semaforo) {
                        echo "{
                                    label:'',
                                    borderColor:   dynamicColors(),
                                    backgroundColor: '$key_semaforo',
                                    fill: false,
                                    data: [
                                      ";
                        $acumulado_prog = 0;
                        $acumulado_ejec = 0;
                        foreach ($fechas_array as $key_array_2 => $valor_array_2) {
                            if (isset($value_semaforo[$key_array_2])) {
                                echo "'1',";
                            } else {
                                echo ',';
                            }
                        }
                        echo "
                                    ]
                    
                                  },";
                    }
                    
                    @endphp

                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: false
                        }
                    }]
                }
            }
        });

    </script>

    <div class="row" id="prin_button">
        <div class="col">
            <button type="button" class="boton_1" onclick="javascript:print()"> Imprimir</button>
            <a href="{{ route('informe_seguimiento_proyectos.informe_seguimiento_index') }}" type="button"
                class="boton_2" name="regresar" vuale="regresar">Regresar</a>

        </div>
    </div>


</body>

</html>
