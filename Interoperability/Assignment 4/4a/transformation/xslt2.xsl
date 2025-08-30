<?xml version="1.0"?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:variable name="res1" select="document('result1.xml')/orders"/>
<xsl:variable name="res2" select="document('result2.xml')/orderitems"/>
<xsl:variable name="res3" select="document('result3.xml')/menus"/>
<xsl:variable name="res4" select="document('result4.xml')/orders"/>


<xsl:output indent="yes"/>
<xsl:template match="/">
<order_data_all>
<xsl:for-each select="$res1//order">
    <xsl:call-template name="order"/>
</xsl:for-each>
</order_data_all>
</xsl:template>


<xsl:template name="order">
    <order_meta>
        <xsl:attribute name="order_id">
        <xsl:value-of select="@orderid"/>
        </xsl:attribute>
            <order_date>
                <xsl:value-of select="substring(string(orderinfo/orderendtime), '1', '10')"/>
            </order_date>
            <orderdetail>
                <Orderdetails>
                    <OrderID>
                        <xsl:value-of select="@orderid"/>
                    </OrderID>
                    <OrderItems>
                        <Item1>
                        <xsl:value-of select="$res2/orderitem/menu/menuitem/burger/name"/>
                        </Item1>
                        <Item2>
                        <xsl:value-of select="$res3/menu/menuitem/drink/drinkinfo/name"/>
                        </Item2>                    
                        <Item3>opt. Item 3</Item3>
                    </OrderItems>
                    <Total>
                    <xsl:value-of select="orderinfo/totalprice"/>
                    </Total>
                </Orderdetails>
            </orderdetail>
            <orderitems>
                <xsl:attribute name="item_id">
                <xsl:value-of select="orderinfo/items/orderitem/@orderitemid"/>
                </xsl:attribute>
                <itname>opt.</itname>
                <itsize>o</itsize>
                <itcost>0</itcost>
            </orderitems>
            <ingredients>
                <xsl:attribute name="ingredient_id">404</xsl:attribute>
                <inname>othercode does not handle ingredients</inname>
                <intype>well .. happens</intype>
            </ingredients>
    </order_meta>
</xsl:template>


</xsl:stylesheet>