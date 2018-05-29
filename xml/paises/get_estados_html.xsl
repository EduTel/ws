<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet 
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <!--    
        method: define el formato de salida (xml, html o text).
        version: define la versión del formato de salida.
        enconding: juego de caracteres de salida. Por defecto UTF-8.
        indent: indenta la salida de la transformación (yes o no).
    -->
    <xsl:output method="html" version="4.0" encoding="UTF-8" indent="yes" />
    <xsl:template match="/estados/pais/estado">
        <table class="table table-dark">
            <tr>
                <td>
                    <xsl:value-of select="nombre" />
                </td>
                <td>
                    <xsl:value-of select="abreviatura" />
                </td>
                <td>
                    <xsl:value-of select="capilal" />
                </td>
            </tr>
        </table>
    </xsl:template>
</xsl:stylesheet>