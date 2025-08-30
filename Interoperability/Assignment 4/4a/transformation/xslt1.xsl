<?xml version="1.0"?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:variable name="res1" select="document('result1.xml')/orders"/>
<xsl:variable name="res2" select="document('result2.xml')/orderitems"/>
<xsl:variable name="res3" select="document('result3.xml')/menus"/>
<xsl:variable name="res4" select="document('result4.xml')/orders"/>


<xsl:output indent="yes"/>
<xsl:template match="/">
<customer_data>
<xsl:for-each select="$res1//order">
    <xsl:call-template name="order"/>
</xsl:for-each>
</customer_data>
</xsl:template>


<xsl:template name="order">
    <customer_details>
            <xsl:attribute name="customer_id">
            <xsl:value-of select="substring(customer/@customerid, '1', '4')"/>
            </xsl:attribute>
        <lname>
            <xsl:value-of select="customer/contactdetails/address/name/family_name"/>
        </lname>    
        <fname>
            <xsl:value-of select="customer/contactdetails/address/name/given_name"/>
        </fname>
        <bday>1999-01-01</bday>
        <address>
            <Address>
                <City>
                <xsl:value-of select="customer/contactdetails/address/address/city"/>
                </City>
                <Country>
                <xsl:value-of select="customer/contactdetails/address/address/@country"/>
                </Country>
                <Street>
                    <Street>
                     <xsl:value-of select="customer/contactdetails/address/address/street/name"/>
                    </Street>
                    <Number>
                         <xsl:value-of select="customer/contactdetails/address/address/street/number"/>
                    </Number>
                    <Additional>None</Additional>
                </Street>
            </Address>
        </address>
        <order_data>
            <orders>
                <xsl:attribute name="order_id">
                <xsl:value-of select="@orderid"/>
                </xsl:attribute>
                <item_id>
                <xsl:value-of select="orderinfo/items/orderitem/@orderitemid"/>
                </item_id>
                <robot_id>xxx</robot_id>
            </orders>
        </order_data>
        <robots>
            <xsl:attribute name="robot_id">xxx</xsl:attribute>
                <rname>opt. robot name</rname>
                <rtype>opt. robot type</rtype>
                <rfunction>opt. robot function</rfunction>
        </robots>

    </customer_details>
</xsl:template>


</xsl:stylesheet>