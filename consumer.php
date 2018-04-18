<?php
    include_once("nusoap-0.9.5/lib/nusoap.php");
    //url del webservice
    $wsdl="http://quickbox.com.mx/web_service_cp_municipio.php?wsdl";
     //instanciando un nuevo objeto cliente para consumir el webservice
    $client = new nusoap_client($wsdl,'wsdl');
    //ELIMINIAMOS CACHE
    ini_set("soap.wsdl_cache_enabled", "0");
    //GENERAMOS EL PARAMETRO DE ESTADO Y MUNICIPIO
    $params = array(
        "estado_cp" => $_GET['estado_cp'],
        "municipio_nuevo" => $_GET['municipio_nuevo']
    );
    //llamando al método y pasándole el array con los parámetros
    $resultado = $client->call('CONSULTA_MUNICIPIO_CP', $param);
    print_r($resultado);
?>