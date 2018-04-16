<?php
    include_once("nusoap-0.9.5/lib/nusoap.php");
    function get_xmlt($name=null){
        if($name!==null){
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
            $xslt->importStyleSheet(DomDocument::load($name));
            $xslt_data = $xslt->transformToXML(DomDocument::loadXML($xmldata));
        }
    }
    $paises  = get_xmlt('get_estados.xsl');
    $estados = get_xmlt('get_paises.xsl');
    //echo "<pre>";
    //echo htmlspecialchars($xslt_data);
    //echo "</pre>";
    /***********************************WS************************************/
    $server = new nusoap_server();
    $metodos = array(
        'get_estados'=>"metodo_get_estados"
    );
    $urn = array(
        'url1'=>"mi_ws1"
    );
    $miURL    = 'urn : '.$urn['url1'];
    $endpoint = 'http: //regochan.com/nusoap/soap_servidor.php';
    $server->configureWSDL('Web servicie de Eduardo ',$miURL);
    $server->wsdl->schemaTargetNamespace = $miURL;
    // Parametros de entrada
    /*
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
    */
     function metodo_get_estados($pais=null) {
        if($pais!==null){
            $msg = 'País: '.$pais; 
            return array(
                        'mensaje' => $msg
            );
        }
    }
    $server->register(  
                    $metodos['get_estados'], // nombre del metodo o funcion
                    array('pais'   => 'xsd: string'), // Estructura de parámetros de entrada
                    array('return' => 'xsd: string'), // Estructura de parámetros de salida
                    $miURL, // namespace
                    $miURL.'#'.$metodos['get_estados'], // soapaction debe ir asociado al nombre del metodo /*Acción soap*/
                    'rpc', // style
                    'encoded', // use
                    'Este método recibe el nombre del país del que quiera los estados' // documentation
                );
   
    $HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
    $server->service($HTTP_RAW_POST_DATA);
?>