<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.css') }}">
    <style>
        table,
        th,
        td {

            border-collapse: collapse;
            padding: 3px;
            border-spacing: 1px;
            vertical-align: top;
            font-size: 5px;
            font-family: 'Gill Sans', 'Gill Sans MT', 'Calibri', 'Trebuchet MS', sans-serif;
        } 

        .sinBorde .tdclass_titulo{ 
            border:1px solid #000;
            font-size: 11px;}

        .sinBorde .tdclass_campos{ 
            border:1px solid #000;
            font-size: 5px;
            
            }

    </style>
</head>
<body>
    <div style=" position: relative;width:100%">
        <div style="padding-bottom: 5px; width:25%; float: right; position: relative;">
            <div style="padding-bottom: 5px; width:70%; float: left; position: relative;">
                <img src="{{ asset('dist/img/anim_logo_01.jpg') }}" height="25px" width="100px" style="float: right;padding:3px;">
            </div>
            <div style="padding-bottom: 5px; width:30%; float: left; position: relative;">
                <img src="{{ asset('/dist/img/anim_logo_anim.png') }}"  height="30px" width="100px" style="float: rigth; padding-left:3px;">
            </div>  
        </div>
    </div>
    <div style="float: left; position: relative;width:76%">
        <div style="padding-bottom: 5px; width:100%">
            <table class="table table-bordered" height="auto" width="100%">
                <thead>
    
                    <tr class="thead-light sinBorde">
                        <td style="width: 24%; vertical-align:middle;" align="center" ></td>
                        <td style="width: 76%; vertical-align:middle;" align="center" class="tdclass_titulo"><b>FORMATO INSTRUCCIÓN DE PAGOS Y CAUSACIONES</b> </td>
                     
                    </tr>
                    
                </thead>        
            </table>
        </div>
        <div style="padding-bottom: 5px; width:100%">
            <table class="table table-bordered" height="auto" width="100%">
                <thead>
    
                    <tr class="thead-light sinBorde">
                        <td style="width: 8%; vertical-align:middle; background-color:#888;" align="center"  class="tdclass_campos" ><b>FECHA</b> </td>
                        <td style="width: 7%; vertical-align:middle;" align="center"  class="tdclass_campos">{{$obligacion->fecha}}</td>
                        <td style="width: 8%; vertical-align:middle;" align="center" ></td>
                        <td style="width: 12%; vertical-align:middle; background-color:#888;" align="center"  class="tdclass_campos"><b> CODIGO FIDEICOMISO</b></td>
                        <td style="width: 5%; vertical-align:middle;" align="center"  class="tdclass_campos">{{$obligacion->codigo_fideicomiso}}</td>
                        <td style="width: 4%; vertical-align:middle;" align="center" ></td>
                        <td style="width: 9%; vertical-align:middle; background-color:#888;" align="center"  class="tdclass_campos"><b>N° DE ORDEN</b> </td>
                        <td style="width: 10%; vertical-align:middle;" align="center"  class="tdclass_campos">{{$obligacion->numero_orden_apf}}</td>
                        <td style="width: 5%; vertical-align:middle;" align="center" ></td>
                        <td style="width: 10%; vertical-align:middle; background-color:#888;" align="center"  class="tdclass_campos"><b>INSTRUCCIÓN</b> </td>
                        <td style="width: 21%; vertical-align:middle;" align="center"  class="tdclass_campos">{{$obligacion->instruccion}}</td>
                        
                    </tr>
                    <tr class="thead-light sinBorde">
                        <td style="width: 15%; vertical-align:middle; background-color:#888;" align="center"  class="tdclass_campos" colspan="2"><b>NOMBRE FIDEICOMISO</b> </td>
                        <td style="width: 25%; vertical-align:middle;" align="center"  class="tdclass_campos" colspan="3">{{$obligacion->numero_contrato}}</td>
                        <td style="width: 4%; vertical-align:middle;" align="center" ></td>
                        <td style="width: 9%; vertical-align:middle; background-color:#888;" align="center"  class="tdclass_campos"><b>TIPO ORDEN</b> </td>
                        <td style="width: 10%; vertical-align:middle;" align="center"  class="tdclass_campos">{{$obligacion->tipo_orden}}</td>
                        <td style="width: 5%; vertical-align:middle;" align="center" ></td>
                        <td style="width: 10%; vertical-align:middle; background-color:#888;" align="center"  class="tdclass_campos"><b>VALOR DE LA ORDEN</b> </td>
                        <td style="width: 21%; vertical-align:middle;" align="center"  class="tdclass_campos">$ {{number_format($obligacion->valor_orden,2)}}</td>
                        
                    </tr>
                    
                </thead>
            </table>
        </div>
    </div>
    <div style="padding-bottom: 5px; width:23%; float: right; position: relative;">
            <img src="{{ asset('dist/img/logo_colpatria.png') }}" height="55px" width="180" style="float: right;padding:3px;">        
    </div>
    <table class="table table-bordered" height="auto" width="100%" border="1">
        <thead>

            <tr class="thead-light">
                <td style="width: 6%; vertical-align:middle; background-color:	#B8B8B8;" align="center"><b>NOMBRE DE BANCO - CUENTA ORIGEN</b> </td>
                <td style="width: 6%; vertical-align:middle; background-color:	#B8B8B8;" align="center"><b>CUENTA ORIGEN</b> </td>
                <td style="width: 6%; vertical-align:middle; background-color:	#B8B8B8;" align="center"><b>TIPO DE MOVIMIENTO</b> </td>
                <td style="width: 3%; vertical-align:middle; background-color:	#B8B8B8;" align="center"><b>CONCEPTO CONTABLE</b> </td>
                <td style="width: 6%; vertical-align:middle; background-color:	#B8B8B8;" align="center"><b>ID TERCERO</b> </td>
                <td style="width: 4%; vertical-align:middle; background-color:	#B8B8B8;" align="center"><b>NOMBRE TERCERO</b> </td>
                <td style="width: 3%; vertical-align:middle; background-color:	#B8B8B8;" align="center"><b>PREFIJO FACTURA</b> </td>
                <td style="width: 4%; vertical-align:middle; background-color:	#B8B8B8;" align="center"><b>N° FACTURA</b> </td>
                <td style="width: 3%; vertical-align:middle; background-color:	#B8B8B8;" align="center"><b>FECHA FACTURA</b> </td>
                <td style="width: 8%; vertical-align:middle; background-color:	#B8B8B8;" align="center"><b>VALOR</b> </td>
                <td style="width: 3%; vertical-align:middle; background-color:	#B8B8B8;" align="center"><b>MULTIPLE BENEFICIARIO</b> </td>
                <td style="width: 4%; vertical-align:middle; background-color:	#B8B8B8;" align="center"><b>TIPO ID BENEF.</b> </td>
                <td style="width: 4%; vertical-align:middle; background-color:	#B8B8B8;" align="center"><b>ID BENEFICIARIO</b> </td>
                <td style="width: 8%; vertical-align:middle; background-color:	#B8B8B8;" align="center"><b>NOMBRE BENEFICIARIO</b> </td>
                <td style="width: 4%; vertical-align:middle; background-color:	#B8B8B8;" align="center"><b>FORMA DE PAGO</b> </td>
                <td style="width: 4%; vertical-align:middle; background-color:	#B8B8B8;" align="center"><b>BANCO DESTINO</b> </td>
                <td style="width: 4%; vertical-align:middle; background-color:	#B8B8B8;" align="center"><b>TIPO DE CUENTA</b> </td>
                <td style="width: 6%; vertical-align:middle; background-color:	#B8B8B8;" align="center"><b>CUENTA DESTINO BENEFICIARIO</b> </td>
                <td style="width: 8%; vertical-align:middle; background-color:	#B8B8B8;" align="center"><b>DESCRIPCION DEL PAGO</b> </td>
                <td style="width: 4%; vertical-align:middle; background-color:	#B8B8B8;" align="center"><b>CIUDAD DONDE SE ADQUIRIO EL BIEN O SERVICIO</b>  </td>
                <td style="width: 2%; vertical-align:middle; background-color:	#B8B8B8;" align="center"><b>CENTRO DE COSTO</b> </td>
            </tr>
        </thead>
        <tbody>
            @foreach($obligacion->pagos as $pago)
            <tr>
                <td>
                   {{$pago->nombre_banco}}
                </td>
                <td>
                   {{$pago->numero_cuenta}}
                </td>
                <td>
                   {{$pago->tipo_movimiento}}
                </td>
                <td>
                   {{$pago->concepto_contable}}
                </td>
                <td>
                   {{$pago->identificacion_tercero}}
                </td>
                <td>
                   {{$pago->nombre_tercero}}
                </td>
                <td>
                   {{$pago->prefijo_factura}}
                </td>
                <td>
                   {{$pago->factura}}
                </td>
                <td>
                   {{ substr($pago->fecha_factura,0, -9)}}
                </td>
                <td>
                   $ {{number_format($pago->valor_endoso,2)}}
                </td>
                <td>
                   {{$pago->multiple_beneficiario}}
                </td>
                <td>
                   {{$pago->tipo_identificacion_beneficiario}}
                </td>
                <td>
                   {{$pago->identificacion_beneficiario}}
                </td>
                <td>
                   {{$pago->nombre_beneficiario}}
                </td>
                <td>
                   {{$pago->forma_pago}}
                </td>
                <td>
                   {{$pago->banco_destino}}
                </td>
                <td>
                   {{$pago->tipo_cuenta}}
                </td>
                <td>
                   {{$pago->cuenta_destino_beneficiario}}
                </td>
                <td>
                   {{$pago->observaciones}}
                </td>
                <td>
                   {{$pago->ciudad_tributacion}}
                </td>
                <td>
                   {{$pago->centro_costo}}
                </td>
            </tr>
            @endforeach
            @php
                $files = 15;

                $rest = $files - count($obligacion->pagos);

            @endphp
            @if($rest > 0)
                @for($i = 0; $i < $rest; $i++)
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endfor
            @endif
        </tbody>
    </table>

    <div style=" position: relative;width:100%">
        <div style="float: left; position: relative;width:25%; padding:15px; padding-left:60px">
            <table class="table table-bordered" height="auto" width="100%" border="1" >
                <tr >
                    <td colspan="2">
                       <br>
                       <br>
                       <br>
                       <br>
                       <br>
                       <br>
                       <br>
                       <br>
                    </td>
                </tr>
                <tr>
                    <td style="width: 20%; vertical-align:middle;" align="left">NOMBRE</td>
                    <td style="width: 80%;"></td>
                </tr>
                <tr>
                    <td style="width: 20%; vertical-align:middle;" align="left">CARGO</td>
                    <td style="width: 80%;"></td>
                </tr>
            </table>
        </div>
        <div style="float: left; position: relative;width:25%; padding:15px; padding-left:50px">
            <table class="table table-bordered" height="auto" width="100%" border="1">
                <tr>
                    <td colspan="2">
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                       <br>
                    </td>
                </tr>
                <tr>
                    <td style="width: 20%; vertical-align:middle;" align="left">NOMBRE</td>
                    <td style="width: 80%;"></td>
                </tr>
                <tr>
                    <td style="width: 20%; vertical-align:middle;" align="left">CARGO</td>
                    <td style="width: 80%;"></td>
                </tr>
            </table>
        </div >
        <div style="float: left; position: relative; width:25%; padding:15px; padding-left:45px">
            <table class="table table-bordered" height="auto" width="100%" border="1">
                <tr>
                    <td colspan="2">
                        <br>
                       <br>
                       <br>
                       <br>
                       <br>
                       <br>
                       <br>
                       <br>
                    </td>
                </tr>
                <tr>
                    <td style="width: 20%; vertical-align:middle;" align="left">NOMBRE</td>
                    <td style="width: 80%;"></td>
                </tr>
                <tr>
                    <td style="width: 20%; vertical-align:middle;" align="left">CARGO</td>
                    <td style="width: 80%;"></td>
                </tr>
            </table>
        </div >
       
    </div>
</body>
</html>