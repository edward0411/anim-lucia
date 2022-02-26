    <?php

    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Support\Facades\Route;


    Auth::routes();
    
    // Route::group(['middleware' => ['auth:api']], function () {
    //     Route::get('test', function () {
    //         $user = \Auth::user();
    //         return $user;
    //     });
    // });

    
    // Route::middleware('auth:api')->get('api/user', function(Request $request) {
    //     return $request->user();
    // });

    
    Route::get('/api/auth/login','ApiTokenController@login');
    
    // Route::get('/api/auth/login', function(Request $request) {
    //     return "Hola mundo";
    // });



   

    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/logout', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');

 Route::group(['prefix' => 'api', 'middleware' => 'auth:api'],function(){
        Route::get('query/pads','ProyectosApiController@get_pads');
    
    
    
    Route::get('query/tablas/{nombretabla}','ProyectosApiController@get_reporte_tabla');
    Route::get('query/convenios','ProyectosApiController@get_convenios');
    Route::get('query/convenios_partes_participantes','ProyectosApiController@get_convenios_partes_participantes');

    //Route::get('query/pads','ProyectosApiController@get_pads');

    Route::get('query/contratos','ProyectosApiController@get_contratos');
    Route::get('query/contratos_polizas','ProyectosApiController@get_contratos_polizas');
    Route::get('query/contratos_supervision','ProyectosApiController@get_contratos_supervision');


    Route::get('query/terceros','ProyectosApiController@get_terceros');
    Route::get('query/contratos_fechas','ProyectosApiController@get_contratos_fechas');
    Route::get('query/contratos_terceros','ProyectosApiController@get_contratos_terceros');


    Route::get('query/proyectos','ProyectosApiController@get_proyectos');
    Route::get('query/proyectos_caracteristicas','ProyectosApiController@get_proyectos_caracteristicas');
    Route::get('query/proyectos_convenios','ProyectosApiController@get_proyectos_convenios');
    Route::get('query/proyectos_fases','ProyectosApiController@get_fases');
    Route::get('query/proyectos_actividades','ProyectosApiController@get_actividades');
    Route::get('query/proyectos_actividades_planeacion','ProyectosApiController@get_actividades_planeacion');
    Route::get('query/proyectos_ejecucion_a_hoy','ProyectosApiController@get_ejecucion_a_hoy');


    Route::get('query/patrimonios_movimientos','ProyectosApiController@get_reporte_patrimonios_movimientos');
    Route::get('query/cdr_movimientos','ProyectosApiController@get_reporte_cdr_movimientos');
    Route::get('query/rps_movimientos','ProyectosApiController@get_reporte_rps_movimientos');
    Route::get('query/obligaciones_movimientos','ProyectosApiController@get_reporte_obligaciones_movimientos');
    Route::get('query/endosos_movimientos','ProyectosApiController@get_reporte_endosos_movimientos');
    
});



    Route::group(['prefix' => 'sistema', 'middleware' => 'auth'],function(){

    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/listado/reportes','HomeController@index_reportes')->name('reportes.index');

    //////////////////MODULO ADMINISTRADOR////////////////////////

    /////cambiar contraseña //////////////

    Route::get('users/cambiarcontrasena', 'userController@cambiarcontrasena')->name('usuarios.cambiar.contrasena')->middleware('can:submenu.administrador.cambiar_contrasena');
    Route::post('users/cambiarcontrasenastore', 'userController@cambiarcontrasenastore')->name('usuarios.cambiar.contrasena.store')->middleware('can:submenu.administrador.cambiar_contrasena');

    ///////Parametricas ////////////////
    Route::get('ver/parametricas','ParametricasController@index')->name('parametricas.index')->middleware('can:administracion.parametricas.ver');
    Route::get('/crear/parametricas','ParametricasController@crear')->name('parametricas.crear')->middleware('can:administracion.parametricas.crear');
    Route::post('/store.parametricas','ParametricasController@store')->name('parametricas.store')->middleware('can:administracion.parametricas.crear');
    Route::get('/editar/parametricas/{id}','ParametricasController@editar')->name('parametricas.editar')->middleware('can:administracion.parametricas.editar');
    Route::post('/update.parametricas','ParametricasController@update')->name('parametricas.update')->middleware('can:administracion.parametricas.editar');
    Route::get('/inactivar/parametricas/{id}','ParametricasController@inactivar')->name('parametricas.inactivar')->middleware('can:administracion.parametricas.activar/inavctivar');
    Route::get('/activar/parametricas/{id}', 'ParametricasController@activar')->name('parametricas.activar')->middleware('can:administracion.parametricas.activar/inavctivar');
    Route::get('/consultar/get_info/parametricas_padres', 'ParametricasController@get_info_parametricas_padres')->name('parametricas.get_info_consultar')->middleware('can:administracion.parametricas.crear');


    /////////Personas/////////
    Route::get('ver/personas','PersonasController@index')->name('personas.index')->middleware('can:administracion.personas.ver');
    Route::get('/crear/personas','PersonasController@crear')->name('personas.crear')->middleware('can:administracion.personas.crear');
    Route::post('/store.personas','PersonasController@store')->name('personas.store')->middleware('can:administracion.personas.crear');
    Route::get('/editar/personas/{id}','PersonasController@editar')->name('personas.editar')->middleware('can:administracion.personas.editar');
    Route::post('/update.personas','PersonasController@update')->name('personas.update')->middleware('can:administracion.personas.editar');
    Route::get('/inactivar/personas/{id}','PersonasController@inactivar')->name('personas.inactivar')->middleware('can:administracion.personas.activar/inavctivar');
    Route::get('/activar/personas/{id}', 'PersonasController@activar')->name('personas.activar')->middleware('can:administracion.personas.activar/inavctivar');

    /////////Usuarios/////////

    Route::get('users', 'userController@index')->name('usuarios.index')->middleware('can:administracion.usuarios.ver');
    Route::post('users/create', 'userController@store')->name('usuarios.store')->middleware('can:administracion.usuarios.crear');
    Route::get('users/{id}/destroy', 'userController@destroy')->name('usuarios.inactivar')->middleware('can:administracion.usuarios.inactivar');
    Route::get('users/{id}/restore', 'userController@restore')->name('usuarios.activar')->middleware('can:administracion.usuarios.activar');

    /////////Roles/////////

    Route::get('roles', 'rolesController@index')->name('roles.index')->middleware('can:administracion.roles.ver');
    Route::post('roles/create', 'rolesController@store')->name('roles.store')->middleware('can:administracion.roles.crear');
    Route::get('roles/{id}/destroy', 'rolesController@destroy')->name('roles.inactivar')->middleware('can:administracion.roles.inactivar');
    Route::get('roles/{id}/restore', 'rolesController@restore')->name('roles.activar')->middleware('can:administracion.roles.activar');
    Route::get('roles/{idrole}/permision', 'rolesController@permisosindex')->name('roles.permision')->middleware('can:administracion.roles.permisos');
    Route::post('roles/permision/create', 'rolesController@permisosstore')->name('roles.pemision.store')->middleware('can:administracion.roles.permisos');


    //////////////////MODULO CONTRACTUAL////////////////////////

    /////////Terceros///////
    Route::get('/crear/terceros','TercerosController@crear')->name('terceros.crear')->middleware('can:modulo_contractual.terceros.crear');
    Route::get('ver/terceros','TercerosController@index')->name('terceros.index')->middleware('can:modulo_contractual.terceros.ver');
    Route::post('/store.terceros','TercerosController@store')->name('terceros.store')->middleware('can:modulo_contractual.terceros.crear');
    Route::get('editar/terceros/{id}','TercerosController@editar')->name('terceros.editar')->middleware('can:modulo_contractual.terceros.editar');
    Route::post('/update.terceros','TercerosController@update')->name('terceros.update')->middleware('can:modulo_contractual.terceros.editar');
    Route::get('informacion/terceros/{id}','TercerosController@ver_terceros')->name('terceros.ver_terceros')->middleware('can:modulo_contractual.terceros.ver');
    Route::get('/inactivar/terceros/{id}','TercerosController@inactivar')->name('terceros.inactivar')->middleware('can:modulo_contractual.terceros.activar/inavctivar');
    Route::get('/activar/terceros/{id}', 'TercerosController@activar')->name('terceros.activar')->middleware('can:modulo_contractual.terceros.activar/inavctivar');

    /////////Terceros cuentas bancarias /////////
    Route::get('crear/terceros_cuentas_bancarias','TercerosCunetasBancariasController@crear')->name('terceros_cuentas_bancarias.crear')->middleware('can:modulo_contractual.terceros_cuentas_bancarias.crear');
    Route::get('ver/terceros_cuentas_bancarias','TercerosCunetasBancariasController@index')->name('terceros_cuentas_bancarias.index')->middleware('can:modulo_contractual.terceros_cuentas_bancarias.ver');
    Route::post('store/terceros_cuentas_bancarias','TercerosCunetasBancariasController@store_cuenta')->name('terceros_cuentas_bancarias.store')->middleware('can:modulo_contractual.terceros_cuentas_bancarias.crear');
    Route::get('editar/terceros_cuentas_bancarias/{id}','TercerosCunetasBancariasController@editar')->name('terceros_cuentas_bancarias.editar')->middleware('can:modulo_contractual.terceros_cuentas_bancarias.editar');
    Route::post('update/terceros_cuentas_bancarias','TercerosCunetasBancariasController@update')->name('terceros_cuentas_bancarias.update')->middleware('can:modulo_contractual.terceros_cuentas_bancarias.editar');
    Route::get('informacion/terceros_cuenta_bancarias/{id}','TercerosCunetasBancariasController@ver_cuentas_bancarias')->name('terceros_cuentas_bancarias.ver_cuentas_bancarias')->middleware('can:modulo_contractual.terceros_cuentas_bancarias.ver');
    Route::get('/inactivar/terceros_cuenta_bancarias/{id}','TercerosCunetasBancariasController@inactivar')->name('terceros_cuentas_bancarias.inactivar')->middleware('can:modulo_contractual.terceros_cuentas_bancarias.activar/inavctivar');
    Route::get('/activar/terceros_cuenta_bancarias/{id}', 'TercerosCunetasBancariasController@activar')->name('terceros_cuentas_bancarias.activar')->middleware('can:modulo_contractual.terceros_cuentas_bancarias.activar/inavctivar');


    ////////Terceros intregrantes consorcio
    Route::post('/store/terceros_integrantes','TercerosController@terceros_integrantes_store')->name('terceros_integrantes.store')->middleware('can:modulo_contractual.terceros.integrantes.crear');
    Route::get('/api/terceros_integrantes','TercerosController@get_infointegrantes_por_tercero')->name('terceros_intregrantes.get_info_por_terceros')->middleware('can:modulo_contractual.terceros.integrantes.ver');
    Route::post('store/terceros_integrantes/editar','TercerosController@terceros_integrantes_store')->name('terceros_integranres.editar_integrante')->middleware('can:modulo_contractual.terceros.integrantes.editar');
    Route::get('/api/terceros_integrantes/delete','TercerosController@delete_info_integrante')->name('terceros_integrantes.delete_info_integrante')->middleware('can:modulo_contractual.terceros.integrantes.eliminar');



    //////Contratos_convenios ///////
    Route::get('ver/contratos_convenios','Contratos_informacionController@index_convenios')->name('contratos_convenios.index')->middleware('can:modulo_contractual.registro_convenios.ver');
    Route::post('store/contratos_convenios','Contratos_informacionController@store_convenios')->name('contratos_convenios.store_convenios')->middleware('can:modulo_contractual.registro_convenios.crear');

    //////Contratos_pdas///////
    Route::get('ver/contratos_pdas','Contratos_informacionController@index_pdas')->name('contratos_pdas.index')->middleware('can:modulo_contractual.registro_pad.ver');


    //////Contratos_informacion ///////
    Route::get('ver/contratos_informacion','Contratos_informacionController@index_informacion')->name('contratos_informacion.index_informacion')->middleware('can:modulo_contractual.contratacion_derivada.ver');
    Route::get('/crear/contratos_informacion/{id}/{id_tipo_contrato}','Contratos_informacionController@crear_informacion')->name('contratos_informacion.crear_informacion')->middleware('can:modulo_contractual.contratacion_derivada.crear');
    Route::get('editar/contratos_informacion','Contratos_informacionController@editar_informacion')->name('contratos_informacion.editar_informacion');
    Route::get('vers/contratos_informacion/{id}/{id_tipo_contrato}','Contratos_informacionController@ver_informacion')->name('contratos_informacion.ver_informacion');
    Route::post('crear/contratos_informacion','Contratos_informacionController@store_informacion')->name('contratos_informacion.store_informacion');
    Route::get('/api/contratos/','Contratos_informacionController@get_info_contrato')->name('contratos_informacion.get_info_contrato');
    Route::get('/delete/contratos_informacion/{id}','Contratos_informacionController@delete')->name('contratos.delete');


    /////////Contratos_certificado_disponibilidad ////////
    Route::get('/crear/contratos_certificado','Contratos_certificadoController@crear_certificado')->name('contratos_certificado.crear_certificado');
    Route::get('ver/contratos_certificado','Contratos_certificadoController@index_certificado')->name('contratos_certificado.index_certificado');


    /////////contratos_cdrs ////////
    Route::get('/api/cdrs_movimiento/','Contratos_cdrsController@get_movimiento_cdr')->name('contratos_cdr.get_movimiento_cdr');
    Route::post('/crear/contratos_cdr/','Contratos_cdrsController@store')->name('contratos_cdr.store');


    /////////contratos_terceros ////////
    Route::get('/api/terceros/','Contratos_tercerosController@get_info_terceros')->name('contratos_terceros.get_info_terceros');
    Route::post('/crear/contratos_terceros/','Contratos_tercerosController@store')->name('contratos_terceros.store');
    Route::post('/crear/convenios_partes/','Contratos_tercerosController@storePartesConvenio')->name('convenios_partes.store');
    Route::get('/api/terceros/delete','Contratos_tercerosController@delete_info_terceros')->name('contratos_terceros.delete_info_terceros');


    /////////contratos_supervisores ////////
    Route::post('/crear/contratos_supervisores/','Contratos_supervisoresController@store')->name('contratos_supervisores.store');
    Route::get('/api/supservisores/delete','Contratos_supervisoresController@delete')->name('contratos_supervisores.delete');


    /////////contratos_comnites ////////
    Route::post('/crear/contratos_comites/','Contratos_comitesController@store')->name('contratos_comites.store');
    Route::get('/api/contratos_comites/delete','Contratos_comitesController@delete')->name('contratos_comites.delete');


    /////////contratos_fechas ////////
    Route::post('/crear/contratos_fechas/','Contratos_fechasController@store')->name('contratos_fechas.store');
    Route::get('/get_info/contratos_fechas/','Contratos_fechasController@get_info')->name('contratos_fechas.get_info_valores');
    Route::get('/update/contratos_fechas/','Contratos_fechasController@update_contratos')->name('contratos_fechas.update');


    /////////contratos_otrosi ////////
    Route::post('/crear/contratos_otrosi/','Contratos_otrosiController@store')->name('contratos_otrosi.store');
    Route::get('/api/contratos_otrosi/','Contratos_otrosiController@get_info_por_contrato')->name('contratos_otrosi.get_info_por_contrato');
    Route::get('/api/contratos_otrosi/delete','Contratos_otrosiController@delete_info_otrosi')->name('contratos_otrosi.delete_info_otrosi');
    Route::get('/api/contratos_otrosi/edit','Contratos_otrosiController@edit_info_otrosi')->name('contratos_otrosi.edit_info_otrosi');


    /////////contratos_polizas ////////
    Route::get('/api/contratos_polizas/','Contratos_polizasController@get_info_por_contrato')->name('contratos_polizas.get_info_por_contrato');
    Route::post('/crear/contratos_polizas/','Contratos_polizasController@store')->name('contratos_polizas.store');
    Route::post('/crear/contratos_polizas_amparos/','Contratos_polizasController@amparosstore')->name('contratos_polizas_amparos.store');
    Route::get('/api/polizas_amparos/','Contratos_polizasController@get_amparos_por_poliza')->name('contratos_polizas_amparos.get_por_poliza');
    Route::get('/api/contratos_polizas/delete','Contratos_polizasController@delete_info_polizas')->name('contratos_polizas_amparos.delete_info_polizas');
    Route::get('/api/contratos_polizas_amparos/delete','Contratos_polizasController@delete_info_polizas_amparos')->name('contratos_polizas_amparos.delete_info_polizas_amparos');


    ///////Contratos Terminaciones ////
    Route::post('/crear/contratos_terminaciones/','ContratosTerminacionController@store')->name('contratos_terminaciones.store');
    Route::get('/get_info/contratos_terminaciones/','ContratosTerminacionController@get_info')->name('contratos_terminacion.get_info');


    ///////Contratos Liquidaciones ///////////
    Route::post('/crear/contratos_liquidaciones/','ContratosLiquidacionController@store')->name('contratos_liquidaciones.store');
    Route::get('/get_info/contratos_liquidaciones/','ContratosLiquidacionController@get_info')->name('contratos_liquidaciones.get_info');


    ///////Contratos Afectación///////////
    Route::get('/cdr_get_info/contratos_afectacion/','ContratosAfectacionFinancieraController@get_info_cdr')->name('contratos_afectacion.get_info_cdr');
    Route::get('/afectacion_get_info/contratos_afectacion/','ContratosAfectacionFinancieraController@get_info_afectacion')->name('contratos_afectacion.get_info_afectacion');
    Route::post('/crear/contratos_afectacion/','ContratosAfectacionFinancieraController@store')->name('contratos_afectacion.store');


    //////////////////////////////////////MODULO FINANCIERO///////////////////////////////////////////////


    //////Consultas Obligaciones Estados //////
    Route::get('ver/consaulta_obligaciones_estados','ConsultaObligacionesEstadosController@index')->name('consulta_obligaciones_estados.index')->middleware('can:submenu.modulo_financiero.estado_obligaciones');
    Route::post('store/consaulta_obligaciones_estados','ConsultaObligacionesEstadosController@store')->name('consulta_obligaciones_estados.store')->middleware('can:modulo_financiero.consulta_obligaciones.consultar');


    ////////Patrimonios////////
    Route::get('ver/patrimonio','PatrimoniosController@index')->name('patrimonios.index')->middleware('can:modulo_financiero.patrimonios.ver');
    Route::get('/crear/patrimonio','PatrimoniosController@crear')->name('patrimonios.crear')->middleware('can:modulo_financiero.patrimonios.crear');
    Route::post('/store/patrimonio','PatrimoniosController@store')->name('patrimonios.store')->middleware('can:modulo_financiero.patrimonios.crear');
    Route::get('editar/patrimonio/{id}','PatrimoniosController@editar')->name('patrimonios.editar')->middleware('can:modulo_financiero.patrimonios.editar');
    Route::post('update/patrimonio','PatrimoniosController@update')->name('patrimonios.update')->middleware('can:modulo_financiero.patrimonios.editar');
    Route::get('/crear_informacion/patrimonio/{id}','PatrimoniosController@crear_informacion')->name('patrimonios.crear_informacion')->middleware('can:modulo_financiero.patrimonios.ver.detalle');
    Route::get('/plan_financiero/patrimonio/{id}','PatrimoniosController@plan_financiero')->name('patrimonios.plan_financiero')->middleware('can:modulo_financiero.patrimonios.plan_financiero.ver');


    ///////////Cuentas patrimonios////////////////////////////
    Route::post('/store/cuenta_patrimonio','PatrimoniosController@patrimonios_cuentas_store')->name('patrimonios.crear_cuenta')->middleware('can:modulo_financiero.patrimonios.cuentas.crear');
    Route::post('/store/cuenta_patrimonio/editar','PatrimoniosController@patrimonios_cuentas_store')->name('patrimonios.editar_cuenta')->middleware('can:modulo_financiero.patrimonios.cuentas.editar');
    Route::get('/api/cuenta_patrimonio/delete','PatrimoniosController@delete_info_cuenta')->name('patrimonios_cuentas.delete_info_cuenta')->middleware('can:modulo_financiero.patrimonios.cuentas.eliminar');
    Route::get('/api/cuenta_patrimonio','PatrimoniosController@get_infocuenta_por_patrimonio')->name('patrimonios_cuentas.get_info_por_patrimonio')->middleware('can:modulo_financiero.patrimonios.cuentas.ver');


    ////////////cuentas_movimientos////////////////
    Route::get('/api/cuenta_patrimonio_movimientos','PatrimoniosController@get_infocuenta_por_patrimonio_movimientos')->name('patrimonio.cuenta_movimientos')->middleware('can:modulo_financiero.patrimonios.cuentas.movimientos.ver');
    Route::post('/store/movimientos_cuenta_patrimonio','PatrimoniosController@patrimonios_cuentas_movimientos_store')->name('cuentas_movimientos.store')->middleware('can:modulo_financiero.patrimonios.cuentas.movimientos.crear');
    Route::post('/store/movimientos_cuenta_patrimonio/editar','PatrimoniosController@patrimonios_cuentas_movimientos_store')->name('patrimonios_cuentas_movimientos.editar')->middleware('can:modulo_financiero.patrimonios.cuentas.movimientos.editar');
    Route::get('/api/movimiento_cuenta_patrimonio','PatrimoniosController@get_infomovimientos_por_cuenta')->name('patrimonios_cuentas_movimientos.get_info_por_cuenta')->middleware('can:modulo_financiero.patrimonios.cuentas.movimientos.ver');
    Route::get('/api/rendimiento_cuenta_patrimonio','PatrimoniosController@get_inforendimientos_por_cuenta')->name('patrimonios_cuentas_rendimientos.get_info_por_cuenta')->middleware('can:modulo_financiero.patrimonios.cuentas.movimientos.ver');
    Route::get('/api/movimiento_cuenta_patrimonio/delete','PatrimoniosController@delete_info_movimiento')->name('patrimonios_cuentas_movimiento.delete_info_movimiento')->middleware('can:modulo_financiero.patrimonios.cuentas.movimientos.eliminar');
    Route::post('/store/rendimientos_cuenta_patrimonio','PatrimoniosController@patrimonios_cuentas_rendimientos_store')->name('patrimonios_cuentas_rendimientos.store')->middleware('can:modulo_financiero.patrimonios.cuentas.movimientos.crear');
    Route::post('/store/rendimientos_cuenta_patrimonio/editar','PatrimoniosController@patrimonios_cuentas_rendimientos_store')->name('patrimonios_cuentas_rendimientos.editar')->middleware('can:modulo_financiero.patrimonios.cuentas.movimientos.editar');
    Route::get('/api/cuenta_saldo','PatrimoniosController@get_infocuenta_saldo')->name('consultar_cuenta_saldo');


    ///////////////////Bitacoras patrimonios ///////
    Route::post('/store/patrimonio/bitacora','PatrimoniosController@patrimonios_bitacora_store')->name('patrimonios_bitacora.store')->middleware('can:modulo_financiero.patrimonios.bitacora.crear');
    Route::post('/store/patrimonio/bitacora/editar','PatrimoniosController@patrimonios_bitacora_store')->name('patrimonios_bitacora.store_edit')->middleware('can:modulo_financiero.patrimonios.bitacora.editar');
    Route::get('/api/patrimonio/bitacoras','PatrimoniosController@get_infobitacora_por_patrimonio')->name('patrimonios_bitacora.get_info_por_patrimonio')->middleware('can:modulo_financiero.patrimonios.bitacora.ver');
    Route::get('/api/patrimonio/delete','PatrimoniosController@delete_info_bitacora')->name('patrimonios_bitacora.delete_info_bitacora')->middleware('can:modulo_financiero.patrimonios.bitacora.eliminar');


    //////////////////Seguimientos Bitacoras ///////////////
    Route::get('/seguimiento_bitacora/patrimonio','PatrimoniosBitacorasSeguimientosController@index_seguimiento')->name('patrimonios.bitacoras.index_seguimiento');
    Route::post('/store/patrimonio/seguimiento_bitacora','PatrimoniosBitacorasSeguimientosController@seguimiento_store')->name('patrimonios.bitacoras.seguimiento_store')->middleware('can:modulo_financiero.patrimonios.bitacora.seguimiento.crear');
    Route::post('/store/patrimonio/seguimiento_bitacora/editar','PatrimoniosBitacorasSeguimientosController@seguimiento_store')->name('patrimonios.bitacoras.seguimiento_store_editar')->middleware('can:modulo_financiero.patrimonios.bitacora.seguimiento.editar');
    Route::get('/api/patrimonio/segumiento_bitacora','PatrimoniosBitacorasSeguimientosController@get_infoseguimiento_por_bitacora')->name('patrimonios.bitacoras.get_info_por_seguimiento')->middleware('can:modulo_financiero.patrimonios.bitacora.seguimiento.ver');
    Route::get('/api/patrimonio/seguimiento_bitacora/delete','PatrimoniosBitacorasSeguimientosController@delete_info_seguimiento')->name('patrimonios.bitacoras.delete_info_seguimiento')->middleware('can:modulo_financiero.patrimonios.bitacora.seguimiento.eliminar');


    ////////////////////Gestion de CDR////////////////////
    Route::get('ver/cdr','CdrController@index')->name('cdr.index')->middleware('can:modulo_financiero.gestion_cdr.ver');
    Route::get('/crear/cdr','CdrController@crear')->name('cdr.crear')->middleware('can:modulo_financiero.gestion_cdr.crear');
    Route::get('/editar/cdr/{id}','CdrController@editar')->name('cdr.editar')->middleware('can:modulo_financiero.gestion_cdr.editar');
    Route::get('/reporte/cdr/{id}','CdrController@reporte')->name('cdr.reporte')->middleware('can:modulo_financiero.gestion_cdr.editar');
    Route::post('/store/cdr','CdrController@store')->name('cdr.store')->middleware('can:modulo_financiero.gestion_cdr.crear');
    Route::post('/update/cdr','CdrController@update')->name('cdr.update')->middleware('can:modulo_financiero.gestion_cdr.editar');
    Route::post('/delete/cdr','CdrController@delete')->name('cdr.delete')->middleware('can:modulo_financiero.gestion_cdr.eliminar');


    /////////////////CDR_cuentas////////////
    Route::get('/cdr/cuentas/{id}','CdrCuentasController@index')->name('cdr.cuentas.index')->middleware('can:modulo_financiero.gestion_cdr.cuentas.ver');
    Route::get('/cdr/cuentas/','CdrCuentasController@index_get')->name('cdr.cuentas.index_get')->middleware('can:modulo_financiero.gestion_cdr.cuentas.ver');
    Route::get('/api/cdr_cuentas','CdrCuentasController@get_infocuentas_por_cdr')->name('cdr_cuentas.get_info_por_cdr')->middleware('can:modulo_financiero.gestion_cdr.cuentas.ver');
    Route::post('/cdr/cuentas/store','CdrCuentasController@store')->name('cdr.cuentas.store')->middleware('can:modulo_financiero.gestion_cdr.cuentas.guardar');
    Route::get('/api/cdr/cuenta/delete','CdrCuentasController@delete_relacion_cuenta')->name('cdr_cuenta.delete')->middleware('can:modulo_financiero.gestion_cdr.cuentas.eliminar');


    ////////////////////movimientos de CDR/////////////
    Route::post('/movimientos/cdr/store','CdrMovimientosController@store')->name('cdr.movimientos.store')->middleware('can:modulo_financiero.gestion_cdr.cuentas.historial.crear');
    Route::get('/api/movimientos/cdr','CdrMovimientosController@get_infomovimientos_por_cdr')->name('cdr_cuentas_movimientos.get_info_por_cdr')->middleware('can:modulo_financiero.gestion_cdr.cuentas.historial.crear');
    Route::get('/api/cdr/consultarValores','CdrMovimientosController@get_infoValores_por_cdr')->name('cdr_cuentas_movimientos.get_info_valores_por_cdr');
    Route::get('/api/movimientos/delete','CdrMovimientosController@delete_info_operacion')->name('cdp_movimientos.delete_info_movimiento')->middleware('can:modulo_financiero.gestion_cdr.cuentas.historial.eliminar');
    Route::post('/movimientos/cdr/store/editar','CdrMovimientosController@store')->name('cdr_cuenta_movimientos.editar')->middleware('can:modulo_financiero.gestion_cdr.cuentas.historial.editar');
    Route::get('/movimientos/cdr/historial','CdrMovimientosController@index')->name('cdr_movimientos_cuentas_historial')->middleware('can:modulo_financiero.gestion_cdr.cuentas.historial.ver');


    ////////RPS//////////////////////////////////////
    Route::get('/cdr/rps/{id}','CdrRpsController@index')->name('cdr.rps.index')->middleware('can:modulo_financiero.gestion_cdr.rps.ver');
    Route::post('/cdr/rps/store','CdrRpsController@store')->name('cdr.rps.store')->middleware('can:modulo_financiero.gestion_cdr.rps.crear');
    Route::post('/cdr/rps/update','CdrRpsController@store')->name('cdr.rps.update')->middleware('can:modulo_financiero.gestion_cdr.rps.editar');
    Route::get('/rps/delete','CdrRpsController@delete')->name('cdr.rps.delete')->middleware('can:modulo_financiero.gestion_cdr.rps.eliminar');
    Route::get('/api/rps/get_info','CdrRpsController@get_info_rp')->name('cdr_rps.get_info_por_cdr')->middleware('can:modulo_financiero.gestion_cdr.rps.ver');


    //////////////////RPS cuentas//////////////////////////////////////
    Route::get('/rps/cuentas','RpsCuentasController@index')->name('rps_cuentas.index')->middleware('can:modulo_financiero.gestion_cdr.rps.cuentas.ver');
    Route::post('/rps/cuentas/store','RpsCuentasController@store')->name('cdr.rps.cuentas.store')->middleware('can:modulo_financiero.gestion_cdr.rps.cuentas.crear');
    Route::get('/api/rps/get_info_cuentas_relacionadas','RpsCuentasController@get_info_cuentas')->name('get_info_cuentas_relacionadas_rp');
    Route::get('/api/rps/cuentas/get_info_pendiente','RpsCuentasController@get_info_cuentas_pendiente_comprometer')->name('rp_cuentas_consultar_pendiente_comprometer');
    Route::get('/rps/cuentas/delete','RpsCuentasController@delete')->name('cdr_rps_cuentas.delete')->middleware('can:modulo_financiero.gestion_cdr.rps.cuentas.eliminar');


    ///////////RPS Movimientos/////////////////////////////
    Route::get('/rps/movimientos','RpsMovimientosController@index')->name('rps_movimientos.index')->middleware('can:modulo_financiero.gestion_cdr.rps.cuentas.operaciones.ver');
    Route::post('/rps/movimientos/store','RpsMovimientosController@store')->name('cdr.rps.movientos.store')->middleware('can:modulo_financiero.gestion_cdr.rps.cuentas.operaciones.crear');
    Route::get('/api/rps/cuentas/get_info_rp_cuentas','RpsMovimientosController@get_info_por_rp')->name('rps.get_info_por_rp_cuenta');
    Route::get('/api/rps/cuentas/movimientos/get_info_consultar_valor_asignado','RpsMovimientosController@get_info_consultar_valor_disponible')->name('rp_cuentas_movimientos_consultar_valor_disponible');
    Route::post('/rps/movimientos/update','RpsMovimientosController@store')->name('cdr_rps_cuentas_movimientos.update')->middleware('can:modulo_financiero.gestion_cdr.rps.cuentas.operaciones.editar');
    Route::get('/rps/movimientos/delete','RpsMovimientosController@delete')->name('cdr_rps_cuentas_movimientos.delete')->middleware('can:modulo_financiero.gestion_cdr.rps.cuentas.operaciones.eliminar');


    ////////////////Movimientos pagos ////////////////////////
    Route::get('/rps/movimientos/obligacion/pagos','ObligacionesPagosController@index')->name('cdr.rps.movimientos.obligaciones_pagos.index')->middleware('can:modulo_financiero.gestion_cdr.rps.cuentas.pagos.ver');
    Route::post('/rps/cuentas/pagos','ObligacionesPagosController@rp_cuenta_pagos_store')->name('rp_cuentas_pago_store')->middleware('can:modulo_financiero.gestion_cdr.rps.cuentas.pagos.crear');
    Route::get('/rps/cuentas/pagos/delete','ObligacionesPagosController@rp_cuenta_pagos_delete')->name('rp_cuentas_pagos_delete')->middleware('can:modulo_financiero.gestion_cdr.rps.cuentas.pagos.eliminar');
    Route::get('/rps/cuentas/pagos/change_state','ObligacionesPagosController@rp_cuenta_pagos_change_state')->name('rp_cuentas_pagos_change_state')->middleware('can:modulo_financiero.gestion_cdr.rps.cuentas.pagos.cambiar_estado');
    Route::get('/api/cuentas/pagos/get_info','ObligacionesPagosController@get_info_rp_cuenta_pagos')->name('rps_cuentas_pagos_get_info');
    Route::get('/api/cuentas/pagos/consultar_valores','ObligacionesPagosController@get_info_rp_cuenta_pagos_consultar_valores')->name('rps_cuentas_pagos_valores');
    Route::get('/api/cuentas/obl/reporte','ObligacionesPagosController@reporte_obl')->name('rps_cuentas_obl_pagos_reporte');


    ///////////////////////Endosos////////
    Route::get('/rps/movimientos/obligacion/pagos/endosos','EndososController@index')->name('rps.cuentas.obl_pagos.endosos.index');
    Route::post('/rps/movimientos/obligacion/pagos/endosos','EndososController@endosos_store')->name('cdr.rps.movimientos.obligaciones_pagos.endosos.endosos_store');
    Route::get('/api/cuentas/pagos/endosos/get_info','EndososController@get_info_endosos')->name('rps_cuentas_pagos_endosos_get_info');
    Route::get('/api/cuentas/pagos/endosos/delete','EndososController@delete_endoso')->name('rps_cuentas_pagos_endosos_delete');
    Route::get('/api/cuentas/pagos/endosos/cuentas_terceros','EndososController@get_cuentas_terceros')->name('rps_cuentas_pagos_endosos_cuentas_terceros');


    ///////Consulta terceros////////
    Route::get('ver/consulta_terceros','ConsultaTercerosController@index')->name('consulta_terceros.index')->middleware('can:submenu.modulo_financiero.consulta_terceros');
    Route::post('/store/consulta_terceros','ConsultaTercerosController@store')->name('consulta_terceros.store')->middleware('can:modulo_financiero.consulta_terceros.consultar');


    ///////Patrimonios plantillas plan///////
    Route::post('/store/patrimonios/plantillas_plan','PatrimoniosPlantillasPlanController@store_plan_financiero')->name('patrimonios.store_plan_financiero');
    Route::post('/store/patrimonios/plantillas_plan/relacion_cdrs','PatrimoniosPlantillasPlanController@store_relacion_plan_financiero')->name('patrimonios.store_relacion_plan_financiero_cdrs');
    Route::get('/patrimonios/plan_financiero/view/{id}','PatrimoniosPlantillasPlanController@view_plan_financiero')->name('patrimonios.plan_financiero.view');
    Route::get('/patrimonios/plan_financiero/edit/{id}','PatrimoniosPlantillasPlanController@edit_plan_financiero')->name('plan_financiero.edit');
    Route::get('/patrimonios/plan_financiero/edit_cdrs/{id}','PatrimoniosPlantillasPlanController@edit_cdr_plan_financiero')->name('plan_financiero.edit_relacion_cdr');
    Route::get('/api/plantillas_plan','PatrimoniosController@get_patrimonio_plan_financiero')->name('patrimonio.get_patrimonio_plan_financiero');
    Route::get('/patrimonio/errors/{id}','PatrimoniosPlantillasPlanController@restore_view')->name('patrimonios.plan_financiero.restore_values');
    Route::get('/patrimonio/plan/edit_part/{id}/{tipo}/{id_patrimonio}','PatrimoniosPlantillasPlanController@edit_part')->name('patrimonios.plan_financiero.edit_part');
    Route::post('/patrimonio/plan/update_part','PatrimoniosPlantillasPlanController@update_part')->name('patrimonios.plan_financiero.update_part');
    Route::get('/patrimonio/plan/delete_part/{id}/{tipo}/{id_patrimonio}','PatrimoniosPlantillasPlanController@delete_part')->name('patrimonios.plan_financiero.delete_part');
    Route::get('/patrimonio/plan/new_nivel/{id}/{tipo}/{id_patrimonio}','PatrimoniosPlantillasPlanController@new_nivel')->name('patrimonios.plan_financiero.new_nivel');
    Route::post('/patrimonio/plan/store_part','PatrimoniosPlantillasPlanController@store_part')->name('patrimonios.plan_financiero.store_part');
    Route::post('/patrimonio/plan/update_subniveles_cdrs','PatrimoniosPlantillasPlanController@update_subs_cdrs')->name('patrimonios.plan_financiero.update_subniveles_cdrs');


    ////////Plantillas pagos ///////
    Route::get('/rps/plantillas_pagos','PlantillasPagosController@index')->name('cdr.rps.plantillas_pagos.index');
    Route::post('/rps/plantillas_pagos/store','PlantillasPagosController@store')->name('cdr.rps.plantillas_pagos.store');
    Route::get('/rps/plantillas_pagos/edit/{id}','PlantillasPagosController@edit')->name('cdr.rps.plantillas_pagos.edit');
    Route::get('/rps/plantillas_pagos/delete/{id}','PlantillasPagosController@delete')->name('cdr.rps.plantillas_pagos.delete');
    Route::post('/rps/plantillas_pagos/update','PlantillasPagosController@update')->name('cdr.rps.plantillas_pagos.update');
    Route::get('/api/pagos_rp/get_info','PlantillasPagosController@get_info_pagos_rp')->name('cdr.rps.plantillas_pagos.get_info_pagos_rp');
    Route::get('/api/pagos_rp/id_plantilla','PlantillasPagosController@get_info_id_plantilla')->name('cdr.rps.plantillas_pagos.get_value_plantilla');
   

    ////////Carga Masiva /////
    Route::get('ver/carga_masiva','CargaMasivaController@index')->name('carga_masiva.index');
    Route::post('store/carga_masiva','CargaMasivaController@store')->name('carga_masiva.store');


    ////////Plan de pagos//////
    Route::get('/rps/movimientos/obligacion/pagos/plan_pagos','PlanPagosController@index')->name('cdr.rps.movimientos.obligaciones_pagos.plan_pagos.index');


    ////////////////////////////Compromisos///////
    Route::get('ver/compromisos','CompromisosController@index')->name('compromisos.index');
    Route::get('/crear/compromisos','CompromisosController@crear')->name('compromisos.crear');
    Route::get('/agregar_pagos/compromisos','CompromisosController@agregar_pagos')->name('compromisos.agregar_pagos');
    Route::post('/store.compromisos','CompromisosController@store')->name('compromisos.store');


    /////////////////Plantilla plan financiero///////
    Route::get('ver/plantillas_plan_financiero','Plantillas_plan_financieroController@index')->name('plantillas_plan_financieros.index');
    Route::get('/crear/plantillas_plan_financiero','Plantillas_plan_financieroController@crear')->name('plantillas_plan_financieros.crear');
    Route::post('/store/plantillas_plan_financiero','Plantillas_plan_financieroController@store')->name('plantillas_plan_financieros.store');
    Route::get('/editar/plantillas_plan_financiero/{id}','Plantillas_plan_financieroController@editar')->name('plantillas_plan_financieros.editar');
    Route::post('/update/plantillas_plan_financiero','Plantillas_plan_financieroController@update')->name('plantillas_plan_financieros.update');
    Route::post('/destroy/plantillas_plan_financiero','Plantillas_plan_financieroController@destroy')->name('plantillas_plan_financieros.destroy');

    //////////////////////////////MODULO TECNICO//////////////////////////

    ////////////////////Proyectos //////////////////
    Route::get('ver/proyectos','ProyectosController@index')->name('proyectos.index')->middleware('can:modulo_tecnico.gestion_proyectos.ver');
    Route::get('crear/proyectos','ProyectosController@crear')->name('proyectos.crear')->middleware('can:modulo_tecnico.gestion_proyectos.crear');
    Route::get('crear_info/proyectos/{id}','ProyectosController@crear_info')->name('proyectos.crear_info')->middleware('can:modulo_tecnico.gestion_proyectos.ver');
    Route::get('editar/proyectos/{id}','ProyectosController@editar')->name('proyectos.editar')->middleware('can:modulo_tecnico.gestion_proyectos.editar');
    Route::get('delete/proyectos/{id}','ProyectosController@delete')->name('proyectos.delete');
    Route::post('/store/proyectos','ProyectosController@store')->name('proyectos.store')->middleware('can:modulo_tecnico.gestion_proyectos.crear');

    Route::get('ver/proyectos/principales','Proyecto_principalController@index')->name('proyectos.principales.index')->middleware('can:modulo_tecnico.gestion_proyectos.ver');
    Route::get('consultar/proyectos/principales','Proyecto_principalController@get_info_proyectos')->name('proyectos_principales.get_info');
    Route::post('/store/proyectos_principales','Proyecto_principalController@store')->name('proyectos_principales.store')->middleware('can:modulo_tecnico.gestion_proyectos.crear');
    Route::get('delete/proyectos/principales','Proyecto_principalController@delete')->name('proyectos_principales.delete');

    /////////Proyectos convenios///////
    Route::post('store_convenios/proyectos','ProyectosConveniosController@convenios_store')->name('proyectos.convenios_store');
    Route::get('get_api/proyectos/convenios','ProyectosConveniosController@get_info_convenios')->name('proyectos.convenios_get_info');
    Route::get('delete/proyectos/convenios','ProyectosConveniosController@delete_convenios')->name('proyectos.convenios_delete');


    /////////Proyectos caracteristicas ///////////
    Route::post('store_caracteristicas/proyectos','ProyectosCaracteristicasController@caracteristicas_store')->name('proyectos.caracteristicas_store');
    Route::get('get_api_caracteristicas/proyectos','ProyectosCaracteristicasController@caracteristicas_get_info')->name('proyectos.caracteristicas_get_info');
    Route::get('delete/caracteristicas/proyectos','ProyectosCaracteristicasController@delete_caracteristicas')->name('proyectos.caracteristicas_delete');

    /////////Proyectos Licencias  /////////
    Route::post('store_licencias/proyectos','ProyectosLicenciasController@licencias_store')->name('proyectos.licencias_store');
    Route::get('get_api_licencias/proyectos','ProyectosLicenciasController@licencias_get_info')->name('proyectos.licencias_get_info');
    Route::get('delete/licencias/proyectos','ProyectosLicenciasController@delete_licencias')->name('proyectos.licencias_delete');


    ////////////Proyectos personas/////////////////
    Route::post('store_personas/proyectos','ProyectosPersonasController@personas_store')->name('proyectos.personas_store');
    Route::get('get_api_personas/proyectos','ProyectosPersonasController@personas_get_info')->name('proyectos.personas_get_info');
    Route::get('delete/personas/proyectos','ProyectosPersonasController@delete_personas')->name('proyectos.personas_delete');


    ////// Fases del proyecto//////
    Route::get('ver/fases','FasesController@index')->name('fases.index')->middleware('can:modulo_tecnico.gestion_proyectos.ver');
    Route::get('crear/fases/{id}','FasesController@crear')->name('fases.crear')->middleware('can:modulo_tecnico.gestion_proyectos.crear');
    Route::get('editar/fases','FasesController@editar')->name('fases.editar')->middleware('can:modulo_tecnico.gestion_proyectos.ver');
    Route::post('/store/fases','FasesController@store')->name('fases.store')->middleware('can:modulo_tecnico.gestion_proyectos.crear');
    Route::get('get_api_fases/fases','FasesController@fase_get_info')->name('fases.fase_get_info');
    Route::get('delete/fase','FasesController@delete_fase')->name('fases.delete')->middleware('can:modulo_tecnico.gestion_proyectos.eliminar');
    Route::get('fase/traer','FasesController@traer')->name('fases.traer');
    Route::get('fase/clonar','FasesController@clonar')->name('fases.clonar');
    Route::get('fase/consultar','FasesController@consultar')->name('fases.consultar');


    ////////Fases actividades//////
    Route::get('crear/fase_actividad','FasesActividadesController@crear')->name('fases.actividades.crear')->middleware('can:modulo_tecnico.gestion_proyectos.ver');
    Route::post('store/fase_actividad','FasesActividadesController@fases_actividades_store')->name('fases.actividades.store')->middleware('can:modulo_tecnico.gestion_proyectos.crear');
    Route::get('delete/fase_actividad','FasesActividadesController@delete_fases_actividades')->name('fases.actividades_delete')->middleware('can:modulo_tecnico.gestion_proyectos.eliminar');
    Route::get('get_api_fases_actividad/fase_actividad','FasesActividadesController@fases_actividades_get_info')->name('fases.actividades_get_info')->middleware('can:modulo_tecnico.gestion_proyectos.ver');


    ////////Actividades - Planeacion//////
    Route::get('crear/fase_actividad_planeacion','FasesSemanasActividadesController@crear')->name('fases.actividades.planeacion.crear')->middleware('can:modulo_tecnico.gestion_proyectos.crear');
    Route::get('delete_planeacion/fase_actividad_planeacion','FasesSemanasActividadesController@delete_planeacion')->name('fases.actividades.delete_planeacion')->middleware('can:modulo_tecnico.gestion_proyectos.eliminar');
    Route::get('delete_semana_plan/fase_actividad_planeacion','FasesSemanasActividadesController@delete_planeacion_semana')->name('fases.actividades.delete_semana_planeacion')->middleware('can:modulo_tecnico.gestion_proyectos.eliminar');
    Route::get('suspend_semana_plan/fase_actividad_planeacion','FasesSemanasActividadesController@suspend_planeacion_semana')->name('fases.actividades.suspend_semana_planeacion')->middleware('can:modulo_tecnico.gestion_proyectos.eliminar');
    Route::post('store/fase_actividad_planeacion','FasesSemanasActividadesController@fases_actividades_planeacion_store')->name('fases.actividades.planeacion.store')->middleware('can:modulo_tecnico.gestion_proyectos.crear');
    Route::get('delete/fase_actividad_planeacion','FasesSemanasActividadesController@delete_fases_actividades')->name('fases.actividades.planeacion_delete')->middleware('can:modulo_tecnico.gestion_proyectos.eliminar');
    Route::get('get_api_fase_actividad_planeacion/fase_actividad_planeacion','FasesSemanasActividadesController@fases_actividades_get_info')->name('fases.actividades.planeacion_get_info')->middleware('can:modulo_tecnico.gestion_proyectos.ver');


    ////////Fases relaciones contratos /////////
    Route::post('store_relacion_contrato/fases','FasesRelacionesContratosController@relacion_contrato_store')->name('fases.store_relacion_contrato')->middleware('can:modulo_tecnico.gestion_proyectos.crear');
    Route::get('get_api_relacion_contrato/fases','FasesRelacionesContratosController@relacion_contrato_get_info')->name('fases.relacion_contrato_get_info')->middleware('can:modulo_tecnico.gestion_proyectos.ver');
    Route::get('delete/relacion_contrato/fases','FasesRelacionesContratosController@delete_relacion_contrato')->name('fases.relacion_contrato_delete')->middleware('can:modulo_tecnico.gestion_proyectos.eliminar');


    /////////Fases planes //////
    Route::post('/store/fases_planes','FasesPlanesController@fases_planes_store')->name('fases.fases_planes_store')->middleware('can:modulo_tecnico.gestion_proyectos.crear');
    Route::get('get_api_fases_planes/fases','FasesPlanesController@fases_planes_get_info')->name('fases.fases_planes_get_info')->middleware('can:modulo_tecnico.gestion_proyectos.ver');
    Route::get('delete/fases_planes/fases','FasesPlanesController@delete_fases_planes')->name('fases.fases_planes_delete')->middleware('can:modulo_tecnico.gestion_proyectos.eliminar');


    ///////////Conciliaciones //////////
    Route::get('/crear/conciliaciones','ConciliacionesController@crear')->name('conciliaciones.crear');


    //////////////////////////////////Informes de seguimiento - Ejecucion///////////////////////////
    Route::get('ver/informe_semanal','InformeSemanalController@index')->name('informe_semanal.index');
    Route::get('crear/informe_semanal','InformeSemanalController@crear_informe_semanal')->name('informe_semanal.crear_informe_semanal');
    Route::get('crear/informe_ejecucion/{id_semana}/{id_fase}','InformeSemanalController@crear_ejecucion_semanal')->name('informe_semanal.crear_ejecucion_semanal')->middleware('can:modulo_tecnico.informe_seguimiento.ejecucion.crear');
    Route::post('/store.informe_semanal','InformeSemanalController@store')->name('informe_semanal.store')->middleware('can:modulo_tecnico.informe_seguimiento.ejecucion.crear');
    Route::get('get_api_informe_semanal','InformeSemanalController@fases_Informe_semanal_bitacora_get_info')->name('informe_semanal.bitacora_get_info');
    Route::post('/store.informe_semanal_bitacora','InformeSemanalController@store_bitacora')->name('informe_semanal_bitacora.store')->middleware('can:modulo_tecnico.informe_seguimiento.ejecucion.crear');
    Route::get('delete/informe_semanal_bitacora','InformeSemanalController@delete_fases_Informe_semanal_bitacora')->name('informe_semanal_bitacora.delete');
    Route::post('get_store_ejecucion_extra','InformeSemanalController@store_ejecucion_extra')->name('informe_semanal.store_ejecucion_extra')->middleware('can:modulo_tecnico.informe_seguimiento.ejecucion.crear');
   

    ///////Interventoria / Gestion Ambiental///////
    Route::get('ver/interventoria/gestion_ambiental','GestionAmbientalesController@index')->name('gestion_ambientales.index');
    Route::get('crear/interventoria/gestion_ambiental','GestionAmbientalesController@crear')->name('gestion_ambientales.crear')->middleware('can:modulo_tecnico.informe_seguimiento.ambiental.editar');
    Route::get('ver_informacion/gestion_ambiental/{id}','GestionAmbientalesController@crear_info')->name('gestion_ambientales.crear_info')->middleware('can:modulo_tecnico.informe_seguimiento.ambiental.editar');
    Route::get('editar/interventoria/gestion_ambiental/{id}','GestionAmbientalesController@editar')->name('gestion_ambientales.editar')->middleware('can:modulo_tecnico.informe_seguimiento.ambiental.editar');
    Route::post('store/interventoria/gestion_ambiental','GestionAmbientalesController@store')->name('gestion_ambientales.store')->middleware('can:modulo_tecnico.informe_seguimiento.ambiental.editar');
    Route::get('get_api_gestion_ambiental','GestionAmbientalesController@gestion_ambiental_get_info')->name('gestion_ambientales_get_info')->middleware('can:modulo_tecnico.informe_seguimiento.ambiental.editar');


    ///////Interventoria / Gestion Ambiental / Fuente_materiales///////
    Route::post('store/gestion_ambiental/fuente_materiales','Gestiones_ambientales_fuente_materialesController@fuente_materiales_store')->name('gestion_ambientales.fuente_materiales.store')->middleware('can:modulo_tecnico.informe_seguimiento.ambiental.crear');
    Route::get('delete/gestion_ambiental/fuente_materiales','Gestiones_ambientales_fuente_materialesController@delete_fuente_materiales')->name('gestion_ambientales.fuente_materiales_delete')->middleware('can:modulo_tecnico.informe_seguimiento.ambiental.eliminar');
    Route::get('get_api_gestion_ambiental/fuente_materiales','Gestiones_ambientales_fuente_materialesController@fuente_materiales_get_info')->name('gestion_ambientales.Fuente_materiales_get_info')->middleware('can:modulo_tecnico.informe_seguimiento.ambiental.ver');


    ///////Interventoria / Gestion Ambiental / Permisos ambientales///////
    Route::post('store/gestion_ambiental/permisos_ambientales','Gestiones_ambientales_permisos_ambientalesController@permisos_ambientales_store')->name('gestion_ambientales.permisos_ambientales.store')->middleware('can:modulo_tecnico.informe_seguimiento.ambiental.crear');
    Route::get('delete/gestion_ambiental/permisos_ambientales','Gestiones_ambientales_permisos_ambientalesController@delete_permisos_ambientales')->name('gestion_ambientales.permisos_ambientales_delete')->middleware('can:modulo_tecnico.informe_seguimiento.ambiental.eliminar');
    Route::get('get_api_gestion_ambiental/permisos_ambientales','Gestiones_ambientales_permisos_ambientalesController@permisos_ambientales_get_info')->name('gestion_ambientales.permisos_ambientales_get_info')->middleware('can:modulo_tecnico.informe_seguimiento.ambiental.ver');

    ///////Interventoria / Gestion Ambiental / Bitacora////////////////////
    Route::post('store/gestion_ambiental/bitacora','Gestiones_ambientales_bitacoraController@store_bitacora')->name('gestion_ambiental_bitacora.store')->middleware('can:modulo_tecnico.informe_seguimiento.ambiental.crear');
    Route::get('delete/gestion_ambiental/bitacora','Gestiones_ambientales_bitacoraController@delete_bitacora')->name('gestion_ambientales_bitacora_delete')->middleware('can:modulo_tecnico.informe_seguimiento.ambiental.eliminar');
    Route::get('get_api_gestion_ambiental/bitacora','Gestiones_ambientales_bitacoraController@gestion_bitacora_get_info')->name('gestion_ambientales.bitacoras_get_info')->middleware('can:modulo_tecnico.informe_seguimiento.ambiental.ver');


    ///////Interventoria / Gestion Social ////////
    Route::get('ver/interventoria/gestion_social','GestionSocialController@index')->name('gestion_social.index');
    Route::get('ver_informacion/interventoria/gestion_social/{id}','GestionSocialController@crear_info')->name('gestion_social.crear_info')->middleware('can:modulo_tecnico.informe_seguimiento.social.crear');
    Route::post('store/interventoria/gestion_social','GestionSocialController@store')->name('gestion_social.store')->middleware('can:modulo_tecnico.informe_seguimiento.social.crear');


    ///////Interventoria / Gestion Social / social///////
    Route::post('store/gestion_social/social','Gestiones_sociales_socialesController@sociales_store')->name('gestion_social.social.store')->middleware('can:modulo_tecnico.informe_seguimiento.social.crear');
    Route::get('get_api_gestion/gestion_social/social','Gestiones_sociales_socialesController@sociales_get_info')->name('gestion_social.social_get_info')->middleware('can:modulo_tecnico.informe_seguimiento.social.ver');
    Route::get('delete/gestion_social/social','Gestiones_sociales_socialesController@delete_sociales')->name('gestion_social.social_delete')->middleware('can:modulo_tecnico.informe_seguimiento.social.eliminar');

    //////////////Interventoria / Gestion Social / Bitacora////////////////////
    Route::post('store/gestion_social/bitacora','GestionSocialBitacoraController@store_bitacora')->name('gestion_social_bitacora.store')->middleware('can:modulo_tecnico.informe_seguimiento.social.crear');
    Route::get('delete/gestion_social/bitacora','GestionSocialBitacoraController@delete_bitacora')->name('gestion_social_bitacora_delete')->middleware('can:modulo_tecnico.informe_seguimiento.social.eliminar');
    Route::get('get_api_gestion_social/bitacora','GestionSocialBitacoraController@gestion_bitacora_get_info')->name('gestion_social.bitacoras_get_info')->middleware('can:modulo_tecnico.informe_seguimiento.social.ver');

    //////Interventoria /Gestión de Calidad y Seguridad  Industrial //////
    Route::get('ver/interventoria/calidad_seguridad_industrial','GestionCalidadSeguridadIndustrialController@index')->name('gestion_calidad_seguridad.index');
    Route::get('crear/interventoria/calidad_seguridad_industrial','GestionCalidadSeguridadIndustrialController@crear')->name('gestion_calidad_seguridad.crear')->middleware('can:modulo_tecnico.informe_seguimiento.calidad_seguridad.crear');
    Route::get('ver_informacion/interventoria/calidad_seguridad_industrial/{id}','GestionCalidadSeguridadIndustrialController@crear_info')->name('gestion_calidad_seguridad.crear_info')->middleware('can:modulo_tecnico.informe_seguimiento.calidad_seguridad.crear');
    Route::post('store/interventoria/alidad_seguridad_industrial','GestionCalidadSeguridadIndustrialController@store')->name('gestion_calidad_seguridad.store')->middleware('can:modulo_tecnico.informe_seguimiento.calidad_seguridad.crear');
    Route::get('editar/interventoria/calidad_seguridad_industrial','GestionCalidadSeguridadIndustrialController@editar')->name('gestion_calidad_seguridad.editar')->middleware('can:modulo_tecnico.informe_seguimiento.calidad_seguridad.editar');


    ///////Interventoria / Gestión de Calidad y Seguridad  Industrial  / Control de Inspección de Ensayos///////
    Route::post('store/gestion_ambiental/InspeccionEnsayos','Gestioncalidad_seguridad_industrial_inspeccion_ensayosController@inspeccion_ensayos_store')->name('gestion_calidad_seguridad.inspeccion_ensayos.store')->middleware('can:modulo_tecnico.informe_seguimiento.calidad_seguridad.crear');
    Route::get('delete/gestion_ambiental/InspeccionEnsayos','Gestioncalidad_seguridad_industrial_inspeccion_ensayosController@delete_inspeccion_ensayos')->name('gestion_calidad_seguridad.inspeccion_ensayos_delete')->middleware('can:modulo_tecnico.informe_seguimiento.calidad_seguridad.eliminar');
    Route::get('get_api_gestion_ambiental/InspeccionEnsayos','Gestioncalidad_seguridad_industrial_inspeccion_ensayosController@inspeccion_ensayos_get_info')->name('gestion_calidad_seguridad.inspeccion_ensayos_get_info')->middleware('can:modulo_tecnico.informe_seguimiento.calidad_seguridad.ver');


    ///////Interventoria / Gestión de Calidad y Seguridad  Industrial  / Control de equipos en obra///////
    Route::post('store/gestion_ambiental/ControlEquipos','Gestioncalidad_seguridad_industrial_equiposController@ControlEquipos_store')->name('gestion_calidad_seguridad.ControlEquipos.store')->middleware('can:modulo_tecnico.informe_seguimiento.calidad_seguridad.crear');
    Route::get('get_api_gestion_ambiental/ControlEquipos','Gestioncalidad_seguridad_industrial_equiposController@ControlEquipos_get_info')->name('gestion_calidad_seguridad.ControlEquipos_get_info')->middleware('can:modulo_tecnico.informe_seguimiento.calidad_seguridad.ver');
    Route::get('delete/gestion_ambiental/ControlEquipos','Gestioncalidad_seguridad_industrial_equiposController@delete_control_equipos')->name('gestion_calidad_seguridad.ControlEquipos_delete')->middleware('can:modulo_tecnico.informe_seguimiento.calidad_seguridad.eliminar');

    ///////Interventoria / Gestión de Calidad y Seguridad  Industrial  / Control de seguridad industrial///////
    Route::post('store/gestion_ambiental/SeguridadIndustrial','Gestioncalidad_seguridad_industrial_seguridad_industrialController@seguridadindustrial_store')->name('gestion_calidad_seguridad.SeguridadIndustrial.store')->middleware('can:modulo_tecnico.informe_seguimiento.calidad_seguridad.crear');
    Route::get('get_api_gestion/gestion_ambiental/SeguridadIndustrial','Gestioncalidad_seguridad_industrial_seguridad_industrialController@seguridadindustrial_get_info')->name('gestion_calidad_seguridad.seguridadindustrial_get_info')->middleware('can:modulo_tecnico.informe_seguimiento.calidad_seguridad.ver');
    Route::get('delete/SeguridadIndustrial','Gestioncalidad_seguridad_industrial_seguridad_industrialController@delete_seguridad_industrial')->name('gestion_calidad_seguridad.SeguridadIndustrial_delete')->middleware('can:modulo_tecnico.informe_seguimiento.calidad_seguridad.eliminar');


    ///////Interventoria / Gestión de Calidad y Seguridad  Industrial  / Actividades Realizadas///////
    Route::post('store/gestion_ambiental/ActividadesRealizadas','Gestioncalidad_seguridad_industrial_actividades_realizadasController@ActividadesRealizadas_store')->name('gestion_calidad_seguridad.ActividadesRealizadas.store')->middleware('can:modulo_tecnico.informe_seguimiento.calidad_seguridad.crear');
    Route::get('get_api_gestion/gestion_ambiental/ActividadesRealizadas','Gestioncalidad_seguridad_industrial_actividades_realizadasController@ActividadesRealizadas_get_info')->name('gestion_calidad_seguridad.ActividadesRealizadas_get_info')->middleware('can:modulo_tecnico.informe_seguimiento.calidad_seguridad.ver');



////////////////////////////// INFORME DE SUPERVISION//////////////////////////



   ////////Supervisiones ///////////
   Route::get('ver/supervision','SupervisionesController@index')->name('supervisiones.index')->middleware('can:informes_supervision.revision.supervision.ver');
   Route::get('crear/supervision','SupervisionesController@crear')->name('supervisiones.crear')->middleware('can:informes_supervision.revision.supervision.crear');
   Route::post('/store/supervision','SupervisionesController@store')->name('supervisiones.store')->middleware('can:informes_supervision.revision.supervision.crear');
   Route::get('ver/crear_info/{id}','SupervisionesController@crear_info')->name('supervisiones.crear_info')->middleware('can:informes_supervision.revision.supervision.crear');
   Route::get('editar/supervision/{id}','SupervisionesController@editar')->name('supervisiones.editar')->middleware('can:informes_supervision.revision.supervision.editar');
   Route::post('editar_pago/supervision','SupervisionesController@editar_pago')->name('supervisiones.editar_pago')->middleware('can:informes_supervision.revision.supervision.editar');
   Route::post('editar_incumplimiento/supervision','SupervisionesController@editar_incumplimiento')->name('supervisiones.editar_incumplimiento')->middleware('can:informes_supervision.revision.supervision.editar');

   ////////Supervisiones - actas de suspension ///////////
   Route::post('store/supervision_acta_suspencion','supervision_acta_suspensionesController@supervicion_acta_suspencion_store')->name('supervisiones.acta_suspensiones.store')->middleware('can:informes_supervision.revision.supervision.crear');
   Route::get('delete/supervision_acta_suspencion','supervision_acta_suspensionesController@delete_supervicion_acta_suspencion')->name('supervisiones.acta_suspensiones_delete')->middleware('can:informes_supervision.revision.supervision.eliminar');
   Route::get('get_api_supervision_acta_suspencion','supervision_acta_suspensionesController@supervicion_acta_suspencion_get_info')->name('supervisiones.acta_suspensiones_get_info')->middleware('can:informes_supervision.revision.supervision.ver');

   ////////Supervisiones - Seguimiento tecnico ///////////
   Route::post('store/supervision_seguimiento_tecnicos','supervision_seguimiento_tecnicosController@supervision_seguimiento_tecnicos_store')->name('supervisiones.seguimiento_tecnicos.store')->middleware('can:informes_supervision.revision.supervision.crear');
   Route::get('delete/supervision_seguimiento_tecnicos','supervision_seguimiento_tecnicosController@delete_supervision_seguimiento_tecnicos')->name('supervisiones.seguimiento_tecnicos_delete')->middleware('can:informes_supervision.revision.supervision.eliminar');
   Route::get('get_api_supervision_seguimiento_tecnicos','supervision_seguimiento_tecnicosController@supervision_seguimiento_tecnicos_get_info')->name('supervisiones.seguimiento_tecnicos_get_info')->middleware('can:informes_supervision.revision.supervision.ver');
   Route::get('get_api_supervision_seguimiento_tecnicos_anterior','supervision_seguimiento_tecnicosController@supervision_seguimiento_tecnicos_get_info_anterior')->name('supervisiones.seguimiento_tecnicos_get_info_anterior')->middleware('can:informes_supervision.revision.supervision.ver');


   ////////Supervisiones - Acciones Correctivas ///////////
   Route::post('store/supervision_acciones_correctivas','supervision_acciones_correctivasController@supervision_acciones_correctivas_store')->name('supervisiones.acciones_correctivas.store')->middleware('can:informes_supervision.revision.supervision.crear');
   Route::get('delete/supervision_acciones_correctivas','supervision_acciones_correctivasController@delete_supervision_acciones_correctivas')->name('supervisiones.acciones_correctivas_delete')->middleware('can:informes_supervision.revision.supervision.eliminar');
   Route::get('get_api_supervision_acciones_correctivas','supervision_acciones_correctivasController@supervision_acciones_correctivas_get_info')->name('supervisiones.acciones_correctivas_get_info')->middleware('can:informes_supervision.revision.supervision.ver');


    /////////Reportes anim convenios//////
    Route::get('/consulta/reporte_detallado_convenio','Reportes\ReporteDetalladoConvenioController@index_convenio')->name('reportes.reporte_detallado_convenio.index')->middleware('can:reportes.listado_reportes.reporte_detallado_convenios.ver');
    Route::post('/busqueda/reporte_detallado_convenio','Reportes\ReporteDetalladoConvenioController@busqueda_convenio')->name('reportes.reporte_detallado_convenio.busqueda')->middleware('can:reportes.listado_reportes.reporte_detallado_convenios.ver');


    /////////Reportes anim pads//////
    Route::get('/consulta/reporte_detallado_pad','Reportes\ReporteDetalladoPadsController@index_pad')->name('reportes.reporte_detallado_pads.index')->middleware('can:reportes.listado_reportes..reporte_detallado_pad.ver');
    Route::post('/busqueda/reporte_detallado_pad','Reportes\ReporteDetalladoPadsController@busqueda_pad')->name('reportes.reporte_detallado_pads.busqueda')->middleware('can:reportes.listado_reportes..reporte_detallado_pad.ver');


    /////////Reportes anim contratos derivados//////
    Route::get('/consulta/reporte_detallado_derivados','Reportes\ReporteDetalladoDerivadosController@index')->name('reportes.reporte_detallado_contrato_derivados.index')->middleware('can:reportes.listado_reportes..reporte_detallado_contrato_derivado.ver');
    Route::post('/busqueda/reporte_detallado_derivados','Reportes\ReporteDetalladoDerivadosController@busqueda_derivado')->name('reportes.reporte_detallado_contrato_derivados.busqueda')->middleware('can:reportes.listado_reportes..reporte_detallado_contrato_derivado.ver');


    /////////Reportes anim convenios entidades////
    Route::get('/consulta/reporte_convenio_entidad','Reportes\ReporteConvenioEntidadesController@index')->name('reportes.reporte_convenio_entidades.index')->middleware('can:reportes.listado_reportes.reporte_convenios_entidades.ver');
    Route::post('/busqueda/reporte_convenio_entidad','Reportes\ReporteConvenioEntidadesController@busqueda_convenio_entidades')->name('reportes.reporte_convenio_entidades.busqueda')->middleware('can:reportes.listado_reportes.reporte_convenios_entidades.ver');


    ////////Reportes anim convenios contratos terceros///
    Route::get('/consulta/reporte_convenio_contrato_terceros','Reportes\ReporteConvenioContratosTercerosController@index')->name('reportes.reporte_convenio_contratos_terceros.index')->middleware('can:reportes.listado_reportes.reporte_convenio_contrato_tercero.ver');
    Route::post('/busqueda/reporte_convenio_contrato_terceros','Reportes\ReporteConvenioContratosTercerosController@busqueda_terceros')->name('reportes.reporte_convenio_contratos_terceros.busqueda')->middleware('can:reportes.listado_reportes.reporte_convenio_contrato_tercero.ver');


    /////////Reportes terceros  ////////
    Route::get('/consultas/reporte_tercero','Reportes\ReporteTercerosController@index')->name('reportes.reporte_terceros.index')->middleware('can:reportes.listado_reportes.reporte_terceros.ver');
    Route::post('/busqueda/reporte_tercero','Reportes\ReporteTercerosController@busqueda_terceros')->name('reportes.reporte_terceros.busqueda')->middleware('can:reportes.listado_reportes.reporte_terceros.ver');


    ///////// Reportes terceros cuentas bancarias  //////
    Route::get('/consultas/reporte_tercero_cuentas_bancarias','Reportes\ReporteTercerosCuentasBancariasController@index')->name('reportes.reporte_terceros_cuentas_bancarias.index')->middleware('can:reportes.listado_reportes.reporte_terceros_cuentas_bancarias.ver');
    Route::post('/busqueda/reporte_tercero_cuentas_bancarias','Reportes\ReporteTercerosCuentasBancariasController@busqueda_terceros_cuentas')->name('reportes.reporte_terceros_cuentas_bancarias.busqueda')->middleware('can:reportes.listado_reportes.reporte_terceros_cuentas_bancarias.ver');


    ///////Reportes proyectos ////////
    Route::get('/consulta/reporte_proyectos','Reportes\ReporteProyectosController@index')->name('reportes.reporte_proyectos.index')->middleware('can:reportes.listado_reportes.reporte_proyectos.ver');
    Route::post('/busqueda/reporte_proyectos','Reportes\ReporteProyectosController@busqueda_proyecto')->name('reportes.reporte_proyectos.busqueda')->middleware('can:reportes.listado_reportes.reporte_proyectos.ver');


    ///////Reportes proyectos por fase////
    Route::get('/consulta/reporte_proyectos_fases','Reportes\ReporteProyectosFasesController@index')->name('reportes.reporte_proyectos_fases.index')->middleware('can:reportes.listado_reportes.reporte_proyectos_fases.ver');
    Route::post('/busqueda/reporte_proyectos_fases','Reportes\ReporteProyectosFasesController@busqueda_proyecto_fase')->name('reportes.reporte_proyectos_fases.busqueda')->middleware('can:reportes.listado_reportes.reporte_proyectos_fases.ver');


    ///////Reportes proyectos actividades  ////////
    Route::get('/consulta/reporte_proyectos_actividades','Reportes\ReporteProyectosActividadesController@index')->name('reportes.reporte_proyectos_actividades.index')->middleware('can:reportes.listado_reportes.reporte_proyectos_actividades.ver');
    Route::post('/busqueda/reporte_proyectos_actividades','Reportes\ReporteProyectosActividadesController@busqueda_proyecto_actividad')->name('reportes.reporte_proyectos_actividades.busqueda')->middleware('can:reportes.listado_reportes.reporte_proyectos_actividades.ver');


    ///////////////////Reportes proyectos actividades planeacion  ////////
    Route::get('/consulta/reporte_proyectos_actividades_planeacion','Reportes\ReporteProyectosActividadesPlaneacionController@index')->name('reportes.reporte_proyectos_actividades_planeacion.index')->middleware('can:reportes.listado_reportes.reporte_proyectos_actividades_planeacion.ver');
    Route::post('/busqueda/reporte_proyectos_actividades_planeacion','Reportes\ReporteProyectosActividadesPlaneacionController@busqueda_proyecto_actividad_planeacion')->name('reportes.reporte_proyectos_actividades_planeacion.busqueda')->middleware('can:reportes.listado_reportes.reporte_proyectos_actividades_planeacion.ver');


    Route::post('store/gestion_ambiental/ActividadesRealizadas','Gestioncalidad_seguridad_industrial_actividades_realizadasController@ActividadesRealizadas_store')->name('gestion_calidad_seguridad.ActividadesRealizadas.store');
    Route::get('get_api_gestion/gestion_ambiental/ActividadesRealizadas','Gestioncalidad_seguridad_industrial_actividades_realizadasController@ActividadesRealizadas_get_info')->name('gestion_calidad_seguridad.ActividadesRealizadas_get_info');
    Route::get('delete/gestion_social/ctividadesRealizadas','Gestioncalidad_seguridad_industrial_actividades_realizadasController@delete_ActividadesRealizadas')->name('gestion_calidad_seguridad.ActividadesRealizadas_delete');


     //////////////////////Reporte proyectos convenios ///
     Route::get('/consulta/reporte_proyectos_convenio','Reportes\ReporteProyectosConveniosController@index')->name('reportes.reporte_proyectos_convenios.index')->middleware('can:reportes.listado_reportes.reporte_proyectos_convenios.ver');
     Route::post('/busqueda/reporte_proyectos_convenio','Reportes\ReporteProyectosConveniosController@busqueda_proyecto_convenio')->name('reportes.reporte_proyectos_convenios.busqueda')->middleware('can:reportes.listado_reportes.reporte_proyectos_convenios.ver');

    ////////////////// Reporte proyectos caracteristicas /////////
    Route::get('/consulta/reporte_proyectos_caracteriticas','Reportes\ReporteProyectosCaracteristicasController@index')->name('reportes.reporte_proyectos_caracteristicas.index')->middleware('can:reportes.listado_reportes.reporte_proyectos_caracteristicas.ver');
    Route::post('/busqueda/reporte_proyectos_caracteriticas','Reportes\ReporteProyectosCaracteristicasController@busqueda_proyecto_caracteristica')->name('reportes.reporte_proyectos_caracteristicas.busqueda')->middleware('can:reportes.listado_reportes.reporte_proyectos_caracteristicas.ver');


    /////////////////Reporte cdr movimientos  ////////////////////
    Route::get('/consulta/reporte_cdr_movimientos','Reportes\ReporteCdrMovimientosController@index')->name('reportes.reporte_cdr_movimientos.index')->middleware('can:reportes.listado_reportes.reporte_cdr_movimientos.ver');
    Route::post('/busqueda/reporte_cdr_movimientos','Reportes\ReporteCdrMovimientosController@busqueda_cdr_movimiento')->name('reportes.reporte_cdr_movimientos.busqueda')->middleware('can:reportes.listado_reportes.reporte_cdr_movimientos.ver');

     /////////////////Reporte contratos_saldos_por_pagar  ////////////////////
     Route::get('/consulta/reporte_saldos_por_pagar','Reportes\ReporteContratosSaldosPorPagarController@index')->name('reportes.reporte_saldos_por_pagar.index');
     Route::post('/busqueda/reporte_saldos_por_pagar','Reportes\ReporteContratosSaldosPorPagarController@busqueda_cdr_movimiento')->name('reportes.reporte_saldos_por_pagar.busqueda');

     /////////////////Reporte consolidado PADS  ////////////////////
     Route::get('/consulta/reporte_consolidado_pads','Reportes\ReporteConsolidadoPadsController@index')->name('reportes.reporte_pads_consolidado.index');
     Route::post('/buqueda/reporte_consolidado_pads','Reportes\ReporteConsolidadoPadsController@busqueda')->name('reportes.reporte_pads_consolidado.busqueda');
 

    ////////Reporte patrimonios movimientos ////////
    Route::get('/consulta/reporte_patrimonios_movimientos','Reportes\ReportePatrimoniosMovimientosController@index')->name('reportes.reporte_patrimonios_movimientos.index')->middleware('can:reportes.listado_reportes.reporte_patrimonios_movimientos.ver');
    Route::post('/busqueda/reporte_patrimonios_movimientos','Reportes\ReportePatrimoniosMovimientosController@busqueda_patrimonios_movimiento')->name('reportes.reporte_patrimonios_movimientos.busqueda')->middleware('can:reportes.listado_reportes.reporte_patrimonios_movimientos.ver');


    //////////Reporte endosos movimientos  ////////
    Route::get('/consulta/reporte_endosos_movimientos','Reportes\ReporteEndososMovimientosController@index')->name('reportes.reporte_endosos_movimientos.index')->middleware('can:reportes.listado_reportes.reporte_endosos_movimientos.ver');
    Route::post('/busqueda/reporte_endosos_movimientos','Reportes\ReporteEndososMovimientosController@busqueda_endosos_movimiento')->name('reportes.reporte_endosos_movimientos.busqueda')->middleware('can:reportes.listado_reportes.reporte_endosos_movimientos.ver');


    ////////////Reporte obligaciones movimientos ///////
    Route::get('/consulta/reporte_obligaciones_movimientos','Reportes\ReporteObligacionesMovimientosController@index')->name('reportes.reporte_obligaciones_movimientos.index')->middleware('can:reportes.listado_reportes.reporte_obligaciones_movimientos.ver');
    Route::post('/busqueda/reporte_obligaciones_movimientos','Reportes\ReporteObligacionesMovimientosController@busqueda_obligaciones_movimiento')->name('reportes.reporte_obligaciones_movimientos.busqueda')->middleware('can:reportes.listado_reportes.reporte_obligaciones_movimientos.ver');


    /////////////Reporte rps movimientos ////////
    Route::get('/consulta/reporte_rps_movimientos','Reportes\ReporteRpsMovimientosController@index')->name('reportes.reporte_rps_movimientos.index')->middleware('can:reportes.listado_reportes.reporte_rps_movimientos.ver');
    Route::post('/busqueda/reporte_rps_movimientos','Reportes\ReporteRpsMovimientosController@busqueda_rps_movimiento')->name('reportes.reporte_rps_movimientos.busqueda')->middleware('can:reportes.listado_reportes.reporte_rps_movimientos.ver');


    ////////////Reporte contratos polizas //////
    Route::get('/consulta/reporte_contrato_polizas','Reportes\ReporteContratosPolizasController@index')->name('reportes.reporte_contrato_polizas.index')->middleware('can:reportes.listado_reportes.reporte_contratos_polizas.ver');
    Route::post('/busqueda/reporte_contrato_polizas','Reportes\ReporteContratosPolizasController@busqueda_contratos_polizas')->name('reportes.reporte_contrato_polizas.busqueda')->middleware('can:reportes.listado_reportes.reporte_contratos_polizas.ver');

    ///////Reporte gestion ambiental fuentes de materiales//////

    Route::get('/consulta/reporte_gestion_ambiental_fuentes','Reportes\ReporteGestionAmbientalFuentesController@index')->name('reportes.reporte_gestion_ambiental_fuentes.index');
    Route::post('/busqueda/reporte_gestion_ambiental_fuentes','Reportes\ReporteGestionAmbientalFuentesController@busqueda_gestion_ambiental_fuentes')->name('reportes.reporte_gestion_ambiental_fuentes.busqueda');

    ////////Reporte gestion ambiental permisos ////////

    Route::get('/consulta/reporte_gestion_ambiental_permisos','Reportes\ReporteGestionAmbientalPermisosController@index')->name('reportes.reporte_gestion_ambiental_permisos.index');
    Route::post('/busqueda/reporte_gestion_ambiental_permisos','Reportes\ReporteGestionAmbientalPermisosController@busqueda_gestion_ambiental_permisos')->name('reportes.reporte_gestion_ambiental_permisos.busqueda');

    /////// Reporte gestion social /////

    Route::get('/consulta/reporte_gestion_soscial','Reportes\ReporteGestionnesSocialesController@index')->name('reportes.reporte_gestiones_sociales.index');
    Route::post('/busqueda/reporte_gestion_soscial','Reportes\ReporteGestionnesSocialesController@busqueda_gestiones_sociales')->name('reportes.reporte_gestiones_sociales.busqueda');

    //////// Reporte control calidad ///////

    Route::get('/consulta/reporte_control_calidad','Reportes\ReporteControlCalidadController@index')->name('reportes.reporte_control_calidad.index');
    Route::post('/busqueda/reporte_control_calidad','Reportes\ReporteControlCalidadController@busqueda_control_calidad')->name('reportes.reporte_control_calidad.busqueda');

    ///////// Reporte control seguridad industrial //////

    Route::get('/consulta/reporte_control_seguridad_industrial','Reportes\ReporteControlSeguridadIndustrialController@index')->name('reportes.reporte_control_seguridad_industrial.index');
    Route::post('/busqueda/reporte_control_seguridad_industrial','Reportes\ReporteControlSeguridadIndustrialController@busqueda_control_seguridad_industrial')->name('reportes.reporte_control_seguridad_industrial.busqueda');

    ///////// Reporte control actividades realizadas ///////

    Route::get('/consulta/reporte_control_actividades_realizadas','Reportes\ReporteControlActividadesRealizadasController@index')->name('reportes.reporte_control_actividades_realizadas.index');
    Route::post('/busqueda/reporte_control_actividades_realizadas','Reportes\ReporteControlActividadesRealizadasController@busqueda_control_actividades_realizadas')->name('reportes.reporte_control_actividades_realizadas.busqueda');

    //////// Reporte consolidado de contratos  ////

    Route::get('/consulta/reporte_consolidado_contrato','Reportes\ReporteConsolidadoContratosController@index')->name('reportes.reporte_consolidado_contratos.index');
    Route::post('/busqueda/reporte_consolidado_contrato','Reportes\ReporteConsolidadoContratosController@busqueda_consolidado_contratos')->name('reportes.reporte_consolidado_contratos.busqueda');

    //////// Reporte vencimiento de contratos  ////

    Route::get('/consulta/reporte_vencimiento_contratos','Reportes\ReporteVencimientoContratosController@index')->name('reportes.reporte_vencimiento_contratos.index');
    Route::post('/consulta/reporte_vencimiento_contratos/search','Reportes\ReporteVencimientoContratosController@busqueda_vencimiento_contratos')->name('reportes.reporte_vencimiento_contratos.busqueda');

    //////// Reporte pesos porcentuales por actividades ////

    Route::get('/consulta/reporte_pesos_porcentuales','Reportes\ReportePesosPorcentualesController@index')->name('reportes.reporte_pesos_porcentuales_actividades.index');

    /////////// Reporte personas asignadas proyectos//////////
    
    Route::get('/consulta/reporte_personas_asignadas_proyectos','Reportes\ReportePersonasAsignadasProyectosController@index')->name('reportes.reporte_personas_asignadas_proyectos.index');
    Route::post('/busqueda/reporte_personas_asignadas_proyectos','Reportes\ReportePersonasAsignadasProyectosController@busqueda')->name('reportes.reporte_personas_asignadas_proyectos.busqueda');

    /////////// Reporte avance porcentual de proyectos//////////
    
    Route::get('/consulta/reporte_avance_porcentual_proyectos','Reportes\ReporteAvancePorcentualProyectosController@index')->name('reportes.reporte_avance_porcentual_proyectos.index');
    Route::post('/busqueda/reporte_avance_porcentual_proyectos','Reportes\ReporteAvancePorcentualProyectosController@busqueda')->name('reportes.reporte_avance_porcentual.busqueda');

    ////////////////////// Reporte Avance de ejecucion////////////////////////////////

    Route::get('/consulta/reporte_avance_ejecucion','Reportes\ReporteAvanceEjecucionController@index')->name('reportes.reporte_avance_ejecucion.index');

    ////////////////////// Reporte proyectos licencias////////////////////////////////

    Route::get('/consulta/reporte_proyectos_licencias','Reportes\ReporteProyectosLicenciasController@index')->name('reportes.reporte_proyectos_licencias.index');
    Route::post('/busqueda/reporte_proyectos_licencias','Reportes\ReporteProyectosLicenciasController@busqueda')->name('reportes.reporte_proyectos_licencias.busqueda');
    

     ////////////////////// Reporte balance proyectos contratos////////////////////////////////

     Route::get('/consulta/reporte_balance_proyectos_contratos','Reportes\ReporteProyectosBalanceContratosController@index')->name('reportes.reporte_balance_proyectos_contratos.index');
     Route::post('/busqueda/reporte_balance_proyectos_contratos','Reportes\ReporteProyectosBalanceContratosController@busqueda')->name('reportes.reporte_balance_proyectos_contratos.busqueda');
     

    ////////////////////// Reporte bitacoras proyectos ////////////////////////////////

    Route::get('/consulta/reporte_bitacoras_proyectos','Reportes\ReporteBitacoraProyectosController@index')->name('reportes.reporte_bitacoras_proyectos.index');
    Route::post('/busqueda/reporte_bitacoras_proyectos','Reportes\ReporteBitacoraProyectosController@busqueda')->name('reportes.reporte_bitacoras_proyectos.busqueda');
    

    ////////////////////// Reporte ejecucion actualizada////////////////////////////////

    Route::get('/consulta/reporte_ejecucion_actualizada','Reportes\ReporteEjecucionActualizadaController@index')->name('reportes.reporte_ejecucion_actualizada.index');
    Route::post('/busqueda/reporte_ejecucion_actualizada','Reportes\ReporteEjecucionActualizadaController@busqueda')->name('reportes.reporte_ejecucion_actualizada.busqueda');
    
    ////////////////////// Reporte informe supervision////////////////////////////////

    Route::get('/consulta/reporte_informe_supervision','Reportes\ReporteInformeSupervisionController@index')->name('reportes.informe_supervision.index');
    Route::post('/busqueda/reporte_informe_supervision','Reportes\ReporteInformeSupervisionController@busqueda')->name('reportes.informe_supervision.busqueda');
    
    
    /////Informe de seguimientos de proyectos////

    Route::get('consulta/informe_segumiento_proyecto','InformeSeguimientoProyectosController@informe_seguimiento_index')->name('informe_seguimiento_proyectos.informe_seguimiento_index')->middleware('can:reportes.listado_reportes.consulta_seguimiento_proyecto.ver');
    Route::get('ver_consulta/seguimiento_proyecto/{id}/{id_semana_parametrica}/{fecha}','InformeSeguimientoProyectosController@consulta_seguimiento_crear')->name('informe_seguimiento_proyectos.consulta_seguimiento_crear')->middleware('can:reportes.listado_reportes.consulta_seguimiento_proyecto.ver');
    Route::post('/busqueda/informe_segumiento_proyecto','InformeSeguimientoProyectosController@busqueda_proyecto')->name('informe_seguimiento_proyectos.busqueda_proyecto')->middleware('can:reportes.listado_reportes.consulta_seguimiento_proyecto.ver');


    ///////Revision///////////
    Route::post('revision_store','RevisionController@store')->name('revision.store')->middleware('can:informes_seguimiento.revision.crear');
    Route::get('revision_get_info','RevisionController@get_info')->name('revision.get_info')->middleware('can:informes_seguimiento.revision.ver');
    Route::get('delete/revision','RevisionController@delete')->name('revision.delete')->middleware('can:informes_seguimiento.revision.eliminar');


    ///////Tableros de control///////////
    Route::get('tableros_control','TablerosControlController@index')->name('tableros_control.index')->middleware('can:menu.tableros_control');
    Route::get('tableros_control/view/{id_tablero}','TablerosControlController@view')->name('tableros_control.view')->middleware('can:menu.tableros_control');

    /////////////////////limpiar Caché////////////7

    Route::get('/clearcache', function(){
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return '<h1>se ha borrado el cache</h1>';
    });
    });



