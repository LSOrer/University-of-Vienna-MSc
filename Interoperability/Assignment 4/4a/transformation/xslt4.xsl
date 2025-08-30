<?xml version="1.0"?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:variable name="res1" select="document('result1.xml')/orders"/>
<xsl:variable name="res2" select="document('result2.xml')/orderitems"/>
<xsl:variable name="res3" select="document('result3.xml')/menus"/>
<xsl:variable name="res4" select="document('result4.xml')/orders"/>


<xsl:output indent="yes"/>
<xsl:template match="/">
<robot_sandra>
<xsl:for-each select="$res2//orderitem">
    <xsl:call-template name="sandra"/>
</xsl:for-each>
</robot_sandra>
</xsl:template>


<xsl:template name="sandra">
  <robot_taskboard>
    <robot_info>
        <xsl:attribute name="robot_id">111</xsl:attribute>
        <rname>Sandra</rname>
        <rtype>stock_manager</rtype>
        <rfunction>ordering</rfunction>
    </robot_info>
    <delivery_info>
      <delivery>
      <xsl:attribute name="delivery_id">222</xsl:attribute>
        <ddate>2020-06-11</ddate>
        <vendor>Cocacola Comp.</vendor>
        <damount>5</damount>
      </delivery>
      <stock_replenishment>
        <stock_info>
        <xsl:attribute name="stock_id">333</xsl:attribute>
          <ingredient_id>378</ingredient_id>
          <scurrent>43</scurrent>
          <snew>43</snew>
          <smaxcapa>30</smaxcapa>
        </stock_info>
      </stock_replenishment>
    </delivery_info>
  </robot_taskboard>
</xsl:template>


</xsl:stylesheet>