<?php
    include_once("nusoap-0.9.5/lib/nusoap.php");
    //url del webservice
    $wsdl="http://127.0.0.1/ws-nusoap-php/server.php?wsdl";
     //instanciando un nuevo objeto cliente para consumir el webservice
    $client = new nusoap_client($wsdl,'wsdl');
    //ELIMINIAMOS CACHE
    ini_set("soap.wsdl_cache_enabled", "0");
    //GENERAMOS EL PARAMETRO DE ESTADO Y MUNICIPIO
    if( !empty($_GET) ){
        echo "=============================".$_GET['call']."=================================";
        if($_GET['call']=='metodo_get_paises'){
            $resultado = $client->call('metodo_get_paises', $params);
        }elseif($_GET['call']=='metodo_get_estados'){
            $params = array('mexico');
            $resultado = $client->call('metodo_get_estados', $params);
        }elseif($_GET['call']=='metodo_get_estado_municipios'){
            $params = array('22');
            $resultado = $client->call('metodo_get_estado_municipios', $params);
        }else{
            echo "<br>No entro a ninguna función";
        }
        echo "<br>=============================Result=================================";
        if( isset($resultado) ){
            echo "<pre>";
            echo htmlspecialchars($resultado);
            echo "</pre>";
        }
    }else{
        die("No hay metodo get");
    }
?>