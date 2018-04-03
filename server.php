<?php
    include_once("nusoap-0.9.5/lib/nusoap.php");
    $myfile  = fopen("estados.xml", "r") or die("Unable to open file!");
    $xmldata = "";
    while ($line = fgets($myfile)) {
        //echo htmlspecialchars($line);
        $xmldata.=$line;
    }
    fclose($myfile);
    $xslt = new xsltProcessor;
    $xslt->importStyleSheet(DomDocument::load('get_estados.xsl'));
    $xslt_data = $xslt->transformToXML(DomDocument::loadXML($xmldata));
    echo htmlspecialchars($xslt_data);
?>