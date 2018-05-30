<?xml version="1.0" encoding="UTF-8"?>
    <xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <!--
        method: define el formato de salida (xml, html o text).
        version: define la versión del formato de salida.
        enconding: juego de caracteres de salida. Por defecto UTF-8.
        indent: indenta la salida de la transformación (yes o no).
    -->
    <xsl:output method="xml" version="1.0" encoding="UTF-8" indent="yes" />
    <xsl:template match="/table/">
        <estado id="{@d_codigo}">
            <d_asenta><xsl:value-of select="d_asenta"/></d_asenta>
            <d_tipo_asenta><xsl:value-of select="d_tipo_asenta"/></d_tipo_asenta>
            <D_mnpio><xsl:value-of select="D_mnpio"/></D_mnpio>
            <d_estado><xsl:value-of select="d_estado"/></d_estado>
            <d_ciudad><xsl:value-of select="d_ciudad"/></d_ciudad>
            <d_CP><xsl:value-of select="d_CP"/></d_CP>
            <c_estado><xsl:value-of select="c_estado"/></c_estado>
            <c_oficina><xsl:value-of select="c_oficina"/></c_oficina>
            <c_CP><xsl:value-of select="c_CP"/></c_CP>
            <c_tipo_asenta><xsl:value-of select="c_tipo_asenta"/></c_tipo_asenta>
            <c_mnpio><xsl:value-of select="c_mnpio"/></c_mnpio>
            <id_asenta_cpcons><xsl:value-of select="id_asenta_cpcons"/></id_asenta_cpcons>
            <d_zona><xsl:value-of select="d_zona"/></d_zona>
            <c_cve_ciudad><xsl:value-of select="c_cve_ciudad"/></c_cve_ciudad>
        </estado>
    </xsl:template>
</xsl:stylesheet>