<?xml version="1.0"?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:variable name="res1" select="document('result1.xml')/orders"/>
<xsl:variable name="res2" select="document('result2.xml')/orderitems"/>
<xsl:variable name="res3" select="document('result3.xml')/menus"/>
<xsl:variable name="res4" select="document('result4.xml')/orders"/>


<xsl:output indent="yes"/>
<xsl:template match="/">
<orderitem_burgerbun>
<xsl:for-each select="$res2//orderitem">
    <xsl:call-template name="order"/>
</xsl:for-each>
</orderitem_burgerbun>
</xsl:template>


<xsl:template name="order">
    <orderitem_deepdive>
        <orderitem_meta>
            <xsl:attribute name="item_id">
            <xsl:value-of select="@orderitemid"/>
            </xsl:attribute>
            <itname>
                <xsl:value-of select="menu/name"/>
            </itname>
            <itsize>
                <xsl:value-of select="$res3/menu/size/text()"/>
            </itsize>
            <itcost>
                <xsl:value-of select="$res3/menu/price/text()"/>
            </itcost>
        </orderitem_meta>
    <ingredient_info>
        <ingredient>
            <xsl:attribute name="ingredient_id">
            <xsl:value-of select="menu/menuitem/@menuitemid"/>
            </xsl:attribute>
            <inname>
                <xsl:value-of select="menu/menuitem/burger/name"/>
            </inname>
            <intype>Burger</intype>
        </ingredient>
        <stock_status>
            <stock_info>
                <xsl:attribute name="stock_id">1</xsl:attribute>
            <scurrent>20</scurrent>
            <snew>30</snew>
            <smaxcapa>50</smaxcapa>
            </stock_info>
        </stock_status>
    </ingredient_info>
    </orderitem_deepdive>
</xsl:template>


</xsl:stylesheet>