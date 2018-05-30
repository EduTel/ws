<?xml version="1.0" encoding="UTF-8"?>
    <xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <!--
        method: define el formato de salida (xml, html o text).
        version: define la versión del formato de salida.
        enconding: juego de caracteres de salida. Por defecto UTF-8.
        indent: indenta la salida de la transformación (yes o no).
    -->
    <xsl:output method="xml" version="1.0" encoding="UTF-8" indent="yes" />
    <xsl:template match="/estados/pais">
        <xsl:for-each select="estado">
            <estado id="{@id}" nombre='{nombre}' capilal='{capilal}' >
                <file><xsl:value-of select="file" /></file>
            </estado>
        </xsl:for-each>
    </xsl:template>
</xsl:stylesheet>