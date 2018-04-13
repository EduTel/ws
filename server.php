<?php
    include_once("nusoap-0.9.5/lib/nusoap.php");
    $myfile  = fopen("estados.xml", "r") or die("Unable to open file!");
    $xmldata = "";
    while ($line = fgets($myfile)) {
        $xmldata.=$line;
    }
    fclose($myfile);
    echo "<pre>";
    echo htmlspecialchars($xmldata);
    echo "</pre>";
    $xslt = new xsltProcessor;
    $xslt->importStyleSheet(DomDocument::load('get_estados.xsl'));
    $xslt_data = $xslt->transformToXML(DomDocument::loadXML($xmldata));
    echo "<pre>";
    echo htmlspecialchars($xslt_data);
    echo "</pre>";
    /***********************************WS************************************/
    $server = new nusoap_server();
    $server->configureWSDL('Mi Web Service #1', 'urn:mi_ws1');
    // Parametros de entrada
    $server->wsdl->addComplexType(  'type_entrada_get_estados', 
                                    'complexType', 
                                    'struct', 
                                    'all', 
                                    '',
                                    array(
                                        'nombre'   => array(
                                                            'name' => 'nombre',
                                                            'type'   => 'xsd: string'
                                                        ),
                                        'email'    => array(
                                                            'name' => 'email',
                                                            'type'    => 'xsd: string'
                                                        ),
                                        'telefono' => array(
                                                            'name' => 'telefono',
                                                            'type' => 'xsd: string'
                                                        ),
                                        'ano_nac'  => array(
                                                            'name' => 'ano_nac',
                                                            'type'  => 'xsd: int'
                                                        )
                                    )
                                );
    // Parametros de Salida
    $server->wsdl->addComplexType(  'type_salida_get_estados', 
                                    'complexType', 
                                    'struct', 
                                    'all', 
                                    '',
                                    array(
                                        'mensaje'   => array('name' => 'mensaje','type' => 'xsd:string')
                                    )
                                );
    $server->register(  
                    'get_estados', // nombre del metodo o funcion
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
?>