<?xml version="1.0" encoding="UTF-8"?>
    <xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <?xml-stylesheet href="estados.css" title="Estilo1"?>
    <!--
        method: define el formato de salida (xml, html o text).
        version: define la versión del formato de salida.
        enconding: juego de caracteres de salida. Por defecto UTF-8.
        indent: indenta la salida de la transformación (yes o no).
    -->
    <xsl:output method="xml" version="1.0" encoding="UTF-8" indent="yes" />
    <!-- Plantilla all -->
    <!--
    <xsl:template match="/">
        <xsl:apply-templates select="estados/pais/estado/nombre"> 
            <xsl:sort select="nombre" order="descending" />
        </xsl:apply-templates>
    </xsl:template>
    -->
    <xsl:template match="/estados/pais/estado">
        <nombre id="{@id}">
            <xsl:value-of select="nombre" />
        </nombre>
    </xsl:template>
    <!--
    <xsl:template match="/estados/pais/estado">
        <xsl:apply-templates />
    </xsl:template>
    <xsl:template match="nombre">
        <ul>
            <xsl:apply-templates select="nombre"/>
        </ul>
    </xsl:template>
    -->
    <!--
    <xsl:template match="/estados/pais/estado/nombre">
        <xsl:value-of select="." />
    </xsl:template>
    -->
</xsl:stylesheet>