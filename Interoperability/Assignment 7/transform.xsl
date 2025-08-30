<?xml version="1.0"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns:html="http://www.w3.org/1999/xhtml"
                xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#"
                xmlns:foaf="http://xmlns.com/foaf/spec/"
                xmlns:foo="http://example.com/foo#"
                xmlns:customer="http://www.robo-burger.com/customer">

  <xsl:template match="/">
    <rdf:RDF>
      <rdf:Description rdf:about="http://www.robo-burger.com">
        <xsl:apply-templates/>
      </rdf:Description>
    </rdf:RDF>
  </xsl:template>

    <xsl:template match="customer_details">
    <xsl:variable name="customer_id"><xsl:value-of select="@customer_id"/></xsl:variable>
    <xsl:variable name="lname"><xsl:value-of select="lname"/></xsl:variable>
    <xsl:variable name="fname"><xsl:value-of select="fname"/></xsl:variable>   
    <xsl:variable name="bday"><xsl:value-of select="bday"/></xsl:variable>  

    <xsl:variable name="city"><xsl:value-of select="address/Address/City"/></xsl:variable>
    <xsl:variable name="country"><xsl:value-of select="address/Address/Country"/></xsl:variable>

    <customer:hasDetails>
      <rdf:Description rdf:about="http://www.robo-burger.com/customer/{$customer_id}">
        
        <foaf:c_id>
            <xsl:value-of select="@customer_id"/>
        </foaf:c_id>

        <foaf:lname>
        <rdf:Description>
            <rdfs:label><xsl:value-of select="lname"/></rdfs:label>
        </rdf:Description>
        </foaf:lname>
       
        <foaf:fname>
        <rdf:Description>
            <rdfs:label><xsl:value-of select="fname"/></rdfs:label>
        </rdf:Description>
        </foaf:fname>
        
        <foaf:bday>
        <rdf:Description>
            <rdfs:label><xsl:value-of select="bday"/></rdfs:label>
        </rdf:Description>  
        </foaf:bday>

        <foaf:city>
        <rdf:Description>
            <rdfs:label><xsl:value-of select="address/Address/City"/></rdfs:label>
        </rdf:Description> 
        </foaf:city>

        <foaf:country>
        <rdf:Description>
            <rdfs:label><xsl:value-of select="address/Address/Country"/></rdfs:label>
        </rdf:Description>         
        </foaf:country>       

      </rdf:Description>
    </customer:hasDetails>
  
  </xsl:template>

</xsl:stylesheet>