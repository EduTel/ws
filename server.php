<?php
    include_once("nusoap-0.9.5/lib/nusoap.php");
    $myfile  = fopen("estados.xml", "r") or die("Unable to open file!");
    $xmldata = "";
    while ($line = fgets($myfile)) {
        $xmldata.=$line;
    }
    fclose($myfile);
    //echo "<pre>";
    //echo htmlspecialchars($xmldata);
    //echo "</pre>";
    $xslt = new xsltProcessor;
    $xslt->importStyleSheet(DomDocument::load('get_estados.xsl'));
    $xslt_data = $xslt->transformToXML(DomDocument::loadXML($xmldata));
    //echo "<pre>";
    //echo htmlspecialchars($xslt_data);
    //echo "</pre>";
    /***********************************WS************************************/
    $server = new nusoap_server();
    $server->configureWSDL('Web servicie de Eduardo', 'urn:mi_ws1');
    // Parametros de entrada
    $server->wsdl->addComplexType(  'type_entrada_get_estados', 
                                    'complexType', 
                                    'struct', 
                                    'all', 
                                    '',
                                    array(
                                        'pais'   => array(
                                                            'name' => 'pais',
                                                            'type' => 'xsd:  string'
                                                        ),
                                    )
                                );
    // Parametros de Salida
    $server->wsdl->addComplexType(  'type_salida_get_estados', 
                                    'complexType', 
                                    'struct', 
                                    'all', 
                                    '',
                                    array(
                                        'mensaje'   => array(
                                                             'name' => 'mensaje',
                                                             'type' => 'xsd:string'
                                                            )
                                    )
                                );
    $server->register(  
                    'metodo_get_estados', // nombre del metodo o funcion
                    array(
                            'type_entrada_get_estados' => 'tns:type_entrada_get_estados'
                    ), // parametros de entrada
                    array(
                            'return' => 'tns:type_get_estados'
                    ), // parametros de salida
                    'urn:mi_ws1', // namespace
                    'urn:hellowsdl2#calculo_edad', // soapaction debe ir asociado al nombre del metodo
                    'rpc', // style
                    'encoded', // use
                    'Este método recibe el nombre del país del que quiera los estados' // documentation
                );
    function get_estados($pais=null) {
        if($pais!==null){
            $msg = 'País: '.$pais; 
            return array(
                        'mensaje' => $msg
                    );
        }
    }
    $HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
    $server->service($HTTP_RAW_POST_DATA);
?>