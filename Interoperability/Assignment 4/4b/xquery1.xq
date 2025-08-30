<customer_data>
{
for $customer_details in doc("result1.xml")/orders/order
return
<customer_details customer_id="{
    $customer_details/customer/@customerid
    }">
    <lname>
        {
            data($customer_details/customer/contactdetails/address/name/family_name)
        }
    </lname>
    <fname>
        {
            data($customer_details/customer/contactdetails/address/name/given_name)
        }
    </fname>
    <bday>1999-01-01</bday>
    <address>
      <Address>
        <City>
        {
            data($customer_details/customer/contactdetails/address/address/city)
        }
        </City>
        <Country>
        {
            data($customer_details/customer/contactdetails/address/address/@country)
        }
        </Country>
        <Street>
          <Street>
        {
            data($customer_details/customer/contactdetails/address/address/street/name)
        }
          </Street>
          <Number>
        {
            data($customer_details/customer/contactdetails/address/address/street/number)
        }
          </Number>
          <Additional>None</Additional>
        </Street>
      </Address>
    </address>
    <order_data>
      <orders order_id="{
    $customer_details/@orderid
    }">
        <item_id>
        {
            data($customer_details/orderinfo/items/orderitem/@orderitemid)
        }
        </item_id>
        <robot_id>xxx</robot_id>
      </orders>
    </order_data>
    <robots robot_id="xxx">
      <rname>opt. robot name</rname>
      <rtype>opt. robot type</rtype>
      <rfunction>opt. robot function</rfunction>
    </robots>
</customer_details>
}
</customer_data>