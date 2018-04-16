<?php
    include_once("nusoap-0.9.5/lib/nusoap.php");
    function open_file($file=null){
        if($file!==null){
            $myfile  = fopen($file, "r") or die("Unable to open file!");
            $data = "";
            while ($line = fgets($myfile)) {
                $data.=$line;
            }
            fclose($myfile);
            /*
             echo "<pre>";
             echo htmlspecialchars($xmldata);
             echo "</pre>";
            */
            return $data;
        }
    }
    function get_xmlt($file,$name=null){
        if($name!==null){
            $xslt = new xsltProcessor;
            $xslt->importStyleSheet(DomDocument::load($name));
            $xslt_data = $xslt->transformToXML(DomDocument::loadXML($file));
            return $xslt_data;
        }
    }
    
    /*
     echo "<pre>";
     echo htmlspecialchars($estados);
     echo htmlspecialchars($paises);
     echo "</pre>";
    */
    /***********************************WS************************************/
    $server = new nusoap_server();
    $metodos = array(
        'get_paises'  => "metodo_get_paises",
        'get_estados' => "metodo_get_estados"
    );
    $urn = array(
        'url1'=>"mi_ws1"
    );
    $miURL    = 'urn:'.$urn['url1'];
    $endpoint = 'http://127.0.0.1/ws/index.php';
    $server->configureWSDL('Web servicie de Eduardo',$miURL);
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
    function metodo_get_paises(){
        $xml     = open_file("estados.xml");
        $paises  = get_xmlt($xml,'get_paises.xsl');
        return $paises;
    }
    
    function metodo_get_estados($pais=null) {
        $xml     = open_file("estados.xml");
        $estados = get_xmlt($xml,'get_estados.xsl');
        if($pais!==null){
            $msg = 'País: '.$pais; 
            return 'mensaje: '.$msg;
        }
    }
    //echo metodo_get_paises();
    //echo metodo_get_estados(metodo_get_paises());
    //die();
    $server->register(  
                    $metodos['get_paises'], // nombre del metodo o funcion
                    array(), // Estructura de parámetros de entrada
                    array('return' => 'xsd: string'), // Estructura de parámetros de salida
                    $miURL // namespace
                    /*
                     $miURL.'#'.$metodos['get_estados'], // soapaction debe ir asociado al nombre del metodo 'Acción soap'
                     'rpc', // style
                     'encoded', // use
                     'Devuelve los nombres de los países disponibles para el método metodo_get_estados' // documentation
                    */
                );
    $server->register(  
                    $metodos['get_estados'], // nombre del metodo o funcion
                    array('pais'   => 'xsd: string'), // Estructura de parámetros de entrada
                    array('return' => 'xsd: string'), // Estructura de parámetros de salida
                    $miURL // namespace
                    /*
                     $miURL.'#'.$metodos['get_estados'], // soapaction debe ir asociado al nombre del metodo 'Acción soap'
                     'rpc', // style
                     'encoded', // use
                     'Este método recibe el nombre del país del que quiera los estados' // documentation
                    */
                );
   
    $HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
    $server->service($HTTP_RAW_POST_DATA);
?>