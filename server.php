<?php
    include_once("nusoap-0.9.5/lib/nusoap.php");
    function open_file($file=null){
        if($file!==null){
            $myfile  = fopen(utf8_decode($file), "r") or die("Unable to open file!");
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
    function get_xmlt($file,$xmlt_name=null,$xpath=null){
        if($xmlt_name!==null){
            $xslt = new xsltProcessor;
            $xslt->importStyleSheet(DomDocument::load($xmlt_name));
            if($xpath===null){
                $xslt_data = $xslt->transformToXML(DomDocument::loadXML($file));
            }else{
                $string = $xslt->transformToXML(DomDocument::loadXML($file));
                $string = "<estados>".str_replace('<?xml version="1.0" encoding="UTF-8"?>',"",$string)."</estados>";
                $xslt_data = new SimpleXMLElement( $string );
                $xslt_data = $xslt_data->xpath($xpath)[0];
            }
            return $xslt_data;
        }
    }
    /***********************************WS************************************/
    $server = new nusoap_server();
    $metodos = array(
        'get_paises'  => "metodo_get_paises",
        'get_estados' => "metodo_get_estados",
        'get_estado'  => "metodo_get_estado_municipios"
    );
    $urn = array(
        'url1'=>"mi_ws1"
    );
    $ns    = 'urn:'.$urn['url1'];
    $endpoint = 'http://127.0.0.1/ws/index.php';
    $server->configureWSDL('Web servicie de Eduardo',$ns);
    $server->wsdl->schemaTargetNamespace = $ns;
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
    $server->register(  
                    $metodos['get_paises'], // nombre del metodo o funcion
                    array(), // Estructura de parámetros de entrada
                    array('return' => 'xsd:string'), // Estructura de parámetros de salida
                    $ns // namespace
                    /*
                     $ns.'#'.$metodos['get_estados'], // soapaction debe ir asociado al nombre del metodo 'Acción soap'
                     'rpc', // style
                     'encoded', // use
                     'Devuelve los nombres de los países disponibles para el método metodo_get_estados' // documentation
                    */
                );
    $server->register(  
                    $metodos['get_estados'], // nombre del metodo o funcion
                    array('pais'   => 'xsd:string'), // Estructura de parámetros de entrada
                    array('return' => 'xsd:string'), // Estructura de parámetros de salida
                    $ns // namespace
                    /*
                     $ns.'#'.$metodos['get_estados'], // soapaction debe ir asociado al nombre del metodo 'Acción soap'
                     'rpc', // style
                     'encoded', // use
                     'Este método recibe el nombre del país del que quiera los estados' // documentation
                    */
                );
    $server->register(  
                    $metodos['get_estado'], // nombre del metodo o funcion
                    array('estado'   => 'xsd:string'), // Estructura de parámetros de entrada
                    array('return' => 'xsd:string'), // Estructura de parámetros de salida
                    $ns // namespace
                    /*
                     $ns.'#'.$metodos['get_estados'], // soapaction debe ir asociado al nombre del metodo 'Acción soap'
                     'rpc', // style
                     'encoded', // use
                     'Este método recibe el nombre del país del que quiera los estados' // documentation
                    */
                );
    //$server->register(
        //"MiFuncion",
        //array(
        //      'num1' => 'xsd:integer',
        //      'num2' => 'xsd:integer'
        //),array(
        //      'return' => 'xsd:string'
        //),
        //$ns
    //);
    function metodo_get_paises(){
        $url = "xml/paises/";
        $xml     = open_file($url."estados.xml");
        $paises  = get_xmlt($xml,$url.'get_paises.xsl');
        return $paises;
    }
    function metodo_get_estados($pais=null) {
        if($pais!==null){
            $url = "xml/estados/";
            $xml     = open_file($url."estados.xml");
            $estados = get_xmlt($xml,$url."get_estados.xsl");
            return $estados;
        }
    }
    /**
     * optiene todos los c_mnpio;
     *
     * @param [type] $estado
     * @return void
     */
    function xpath($data,$xpath){
        $xslt_data = new SimpleXMLElement($data);
        return $xslt_data->xpath($xpath)[0];
    }
    function metodo_get_estado_municipios($estado=null) {
        if($estado!==null){
            $url1           = "xml/estados/";
            $xml            = open_file($url1."estados.xml");
            $estados        = get_xmlt($xml,$url1."get_all.xsl",'//*[@id="'.$estado.'"]/file');

            $url2           = "xml/municipios/";
            $xml_municipios = open_file($url2.$estados);
            $municipios     = get_xmlt($xml_municipios,$url2."get_municipios.xsl");


            /*
            libxml_use_internal_errors(true);
            $DOMDocument = new DOMDocument();
            $DOMDocument->loadXML($xml_estado); // the variable $ads contains the HTML code above
            $saveXML = $DOMDocument->saveXML();

            $xslt_data = xpath((string)$saveXML,"//NewDataSet");
            $xml_string = "";
            foreach ($xslt_data->children() as $value) {
               $xml_string.= $value->asXML();
            }
            $xml_string = "<estados>".$xml_string."</estados>";
            $xslt_data = xpath($xml_string,"//estados");
            $tag_value = array();
            foreach ($xslt_data->children() as $value) {
                array_push($tag_value,$value->$tag->asXML() );
            }
            $tag_value = array_unique($tag_value);
            $tag_value_xml = "";
            foreach ($tag_value as $value2) {
               $tag_value_xml.="<$tag>".$value2."</$tag>";
            }
            $tag_value_xml = "<".$tag."s>".$tag_value_xml."</".$tag."s>";
            echo "<pre>";
            print_r($tag_value_xml);
            echo "</pre>";
            */
            //print_r($municipios);
            //die();
            return $municipios;
        }
    }
    //function MiFuncion($num1, $num2){
        //$resultadoSuma = $num1 + $num2;
        //$resultado = "El resultado de la suma de " . $num1 . "+" .$num2 . " es: " . $resultadoSuma;
        //return $resultado;
    //}
    //echo metodo_get_estados('mexico');
    //echo metodo_get_estado_municipios("22",'c_mnpio');
    //metodo_get_estado('01');
    $HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
    $server->service($HTTP_RAW_POST_DATA);
?>