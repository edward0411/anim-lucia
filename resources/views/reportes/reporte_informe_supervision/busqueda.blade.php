<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.css') }}">
    <title>Constancia de Disponibilidad Recursos</title>
    <style type="text/css">
        H2 {
            text-align: center;
            font-size: 14px;
        }

        H3 {
            text-align: center;
            font-size: 12px;
        }

        H4 {
            text-align: center;
            font-size: 11px;
            margin: 0;
        }

        H5 {
            text-align: center;
            font-size: 9px;
            margin: 0;
        }

        p {
            font-size: 12px;
        }

        body {
            font-size: 12px;
            font-family: Arial, Helvetica, sans-serif;

        }

        table {
            border-collapse: collapse;
        }



        @page {
            size: A4;
            margin: 11mm 17mm 17mm 17mm;
        }

        @media print {
            footer {
                position: fixed;
                bottom: 0;
                width: 100%;
                text-align: center;
            }

            header {
                position: initial;
                top: 0;
            }

            .content-block,
            p {
                page-break-inside: avoid;
            }

            table {
                border-collapse: collapse;
            }

            .tr-title {
                background-color: #cbd2d0;

            }

            html,
            body {
                width: 210mm;
                height: 297mm;
            }
        }

    </style>
</head>

<body>
    <header>
        <table class="table table-bordered" height="auto" width="100%" border="1">
            <tr>
                <td colspan="3" width="15%" style="border-right:0px;">
                    <img src="{{ asset('dist/img/anim_logo_01.jpg') }}" height="40px">
                </td>
                <td colspan="3" width="15%" style="border-left:0px;border-right:0px;">
                    <img src="{{ asset('/dist/img/anim_logo_anim.png') }}" height="70px">
                </td>
                <td colspan="14" style="text-align: center;"> <strong>INFORME DE SEGUIMIENTO PROYECTOS</strong></td>
            </tr>
            <tr>
                <td>FECHA:</td>
                <td colspan="2">{{ $fecha_impresion }}</td>
                <td>CORTE:</td>
                <td colspan="16" style="text-align: center;">SEMANA DEL {{ $dia1 }} DE {{ strtoupper($mes1) }}
                    AL {{ $dia2 }} DE {{ strtoupper($mes2) }} DE {{ $anio }}
                </td>
            </tr>
        </table>
        <table class="table table-bordered" height="auto" width="100%" border="1">
            @php
                $i = 1;
            @endphp
            @foreach ($search as $value)
                
                @php
                    $j = 1;
                @endphp
                <tr>
                    <td rowspan="2" style="text-align: center">
                        {{ $i }}
                    </td>
                    <td rowspan="2" colspan="3" style="text-align: center">
                        {{ $value->nombre_proyecto }}
                    </td>
                    <td colspan="2" style="text-align: center">
                        AVANCE
                    </td>
                    <td rowspan="2" style="text-align: center">
                        ESTADO <br> ACTUAL
                    </td>
                    <td rowspan="2" colspan="3" style="text-align: center">
                        ACTIVIDADES / OBSERVACIONES (Último reporte de la Fase en la Bitacora)
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center">
                        PROGRAMADO
                    </td>
                    <td style="text-align: center">
                        EJECUTADO
                    </td>
                </tr>
                @foreach ($value->fases as $fase)
                    <tr>
                        <td>
                            {{ $i }}.{{ $j }}
                        </td>
                        <td colspan="3">
                            {{ $fase->nombre_proyecto_fase }}
                        </td>
                        <td style="text-align: center">
                            {{ round($fase->programado, 2) }}%
                        </td>
                        <td style="text-align: center">
                            {{ round($fase->ejecutado, 2) }}%
                        </td>
                        @php
                            $valor = $fase->programado - $fase->ejecutado;
                        @endphp
                        <td>
                            @if( $valor < 5)
                                 <img src="{{asset('img/check.png')}}" alt="" width="30">
                           
                            @else
                                 <img src="{{asset('img/uncheck.png')}}" alt="" width="30">
                         
                            @endif
                        </td>
                        <td colspan="3">
                           
                            @if(!empty($fase->bitacoras))
                                @foreach ($fase->bitacoras as $registro)
                                    @foreach ($registro as $dato)
                                        -> {{ $dato->Descripcion_gestion }}
                                        <br>
                                    @endforeach
                                @endforeach
                            @else
                                {{__('No Registra Información de Bitacoras.')}}
                            @endif
                        </td>
                    </tr>
                    @php
                    $j++;
                @endphp
                @endforeach
                @php
                    $i++;
                @endphp
            @endforeach

        </table>
    </header>

    <hr>
   
</body>

</html>
