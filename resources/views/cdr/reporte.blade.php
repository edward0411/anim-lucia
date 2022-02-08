<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset("plugins/datatables-buttons/css/buttons.bootstrap4.css") }}">
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
            H4{ 
             text-align: center;
             font-size: 11px;
             margin: 0;
            }
            H5{ 
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

            .content-block, p {
                page-break-inside: avoid;
            }
            table {
                border-collapse: collapse;
            }

            .tr-title {
                background-color :#cbd2d0;

            }

            html, body {
                width: 210mm;
                height: 297mm;
            }
            }
    </style>
</head>
<body>
    <header>
        <table >
            <tr>
                <td colspan="2">
                    <img src="{{ asset('dist/img/anim_logo_01.jpg') }}"  height="40px" width="200" style="margin-right: 10;">
                </td>
                <td colspan="2">
                    <img src="{{ asset('/dist/img/anim_logo_anim.png') }}"  height="70px" width="220px"  style="margin-left: 10px;">
                </td>
                <td colspan="4"> </td>
            </tr>
        </table>
    </header>

    <hr>
    <table class="table table-bordered" height="auto" width="100%" >
        <tr>
            <td colspan="8" >   
          
                 <strong><h2>Constancia de Disponibilidad Recursos</h2> </strong> 
                 <p>De acuerdo con lo previsto en el Manual Operativo del Contrato de Mercantil Irrevocable de administración y Pagos N° 102
                 de 2016, suscrito entre la Agencia Nacional Inmobiliaria Virgilio Barco Vargas y la Fiduciaria Colpatria S.A., La Agencia como encargada de la asignación
                 de recursos emite constancia de disponibilidad presupuestal en los siguientes términos: 
                 </p>
                 <strong><h3>Constancia {{$id}}</h3> </strong> 
           
            </td>
        </tr>
        <tr>
            <td style="padding: 5px;">
                <strong>Fecha:</strong>
            </td>
            <td style="text-align: left;" colspan="7">

               {{$fecha_sistema}}
               
            </td>
        </tr>
        <tr>
            <td  style="padding: 5px;">
                <strong>Objeto:</strong>
            </td>
            <td style="text-align: left;" colspan="7">

                {{$datos->objeto_cdr}}
               
            </td>
        </tr>
    </table >
    <hr>

    @php
    $valor_total = 0;
    @endphp

    @foreach($datos->pads as $pad)
        <table class="table table-bordered" height="auto" width="100%">
        <tr>
                <td style="padding: 5px;"  width="12%">
                    <strong>FID N°:</strong>
                </td>
                <td style="text-align: left;" colspan="7">

                    {{$pad['codigo_fid']}}
                
                </td>
            </tr>
            <tr>
                <td  style="padding: 5px;">
                    <strong>Patrimonio:</strong>
                </td>
                <td style="text-align: left;" colspan="7">
                  {{$pad['numero_contrato']}}
                </td>
            </tr>
        </table>
            @foreach($pad['cuentas'] as $cuenta)

            
            <table class="table table-bordered" height="auto" width="100%" border="1"> 
                    <tr bgcolor="#cbd2d0" class="tr-title">
                        <td style="text-align: right;" width="12%">
                            Cuenta
                        </td>
                        <td style="text-align: left;" colspan="3" width="44%">
                            Nombre Cuenta
                        </td>
                        <td style="text-align: right;"  width="11%">
                            Fch Vto Conv
                        </td>
                        <td style="text-align: right;" colspan="2" width="22%">
                            Valor
                        </td>
                        <td style="text-align: left;"  width="11%">
                            Observaciones
                        </td>
                    </tr>


                    <tr>
                        <td style="text-align: right;" width="12%">
                            {{$cuenta['numero_de_cuenta']}}
                        </td>
                        <td style="text-align: left;" colspan="3" width="44%">
                            {{$cuenta['descripcion_cuenta']}}
                        </td>
                        <td style="text-align: right;"  width="11%">
                           {{$pad['fecha_vto_convenio']}}
                        </td>
                        <td style="text-align: right;" colspan="2" width="22%">
                        $ {{number_format($cuenta['valor'],2)}}
                        </td>
                        <td style="text-align: left;"  width="11%">
                            {{$cuenta['Observaciones']}}
                        </td>
                    </tr>
                    @php
                        $valor_total = $valor_total + $cuenta['valor'];
                    @endphp
                   
                </table>
            @endforeach
    @endforeach
                <table class="table table-bordered" height="auto" width="100%" border="1">
                     <tr>
                        <td colspan="4" style="text-align: right; padding: 15px;"  width="56%">
                            <strong>Totales</strong>
                        </td>
                        <td style="text-align: right;" colspan="3"  width="33%">
                            <strong>{{number_format($valor_total,2)}}</strong>
                        </td>
                        <td >

                        </td>
                    </tr>
                </table>
    
    
    <p>
        <em>
            Nota: para efectos de programación y ejecución de pagos tenga en cuenta la fecha de vencimiento de cada unos de los PAD´s.
        </em>
    </p>
    <p>
       {{$fecha_impresion}}
    </p>

    <h3>
          Constancia expedida por:
    </h3>

    <br>
    <br>
    <br>
    <strong><h2 style="margin: 0;">{{$usuario}}</h2> </strong>
    <h4>ASESOR EXPERTO G3 GRADO 05 </h4>
    <h4>AGENCIA NACIONAL INMOBILIARIA VIRGILIO BARCO VARGAS</h4>
    <br>
    <br>
     <footer>
      <h5>Conmutador (57 1) 5 55 30 01 | Avda Carrera 45 # 108-27, Torre 3 Piso 20 Oficina 2001</h5>
      <h5>Bogotá - Colombia</h5>
      <h5>www.agenciavirgiliobarco.gov.co</h5>
    </footer>
</body>
</html>