<?php
    include_once("nusoap-0.9.5/lib/nusoap.php");
    //url del webservice
    $wsdl="http://127.0.0.1/ws/server.php?wsdl";
     //instanciando un nuevo objeto cliente para consumir el webservice
    $client = new nusoap_client($wsdl,'wsdl');
    //ELIMINIAMOS CACHE
    ini_set("soap.wsdl_cache_enabled", "0");
    //llamando al método y pasándole el array con los parámetros
    $resultado = $client->call('metodo_get_paises');
    print_r($resultado);
    //GENERAMOS EL PARAMETRO DE ESTADO Y MUNICIPIO
    $params = array('mexico');
    $resultado = $client->call('metodo_get_estados', $params);
    echo "<pre>";
    echo htmlspecialchars($resultado);
    echo "</pre>";
?>