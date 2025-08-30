<robot_sandra>
{
for $customer_details at $pos in doc("result1.xml")/orders/order
let $order_data := doc("result2.xml")/orderitems/orderitem[position() = $pos]
let $menu := doc("result3.xml")/menus/menu[position() = $pos]
return
  <robot_taskboard>
    <robot_info robot_id="111">
      <rname>Sandra</rname>
      <rtype>stock_manager</rtype>
      <rfunction>ordering</rfunction>
    </robot_info>
    <delivery_info>
      <delivery delivery_id="222">
        <ddate>2020-06-11</ddate>
        <vendor>Cocacola Comp.</vendor>
        <damount>5</damount>
      </delivery>
      <stock_replenishment>
        <stock_info stock_id="333">
          <ingredient_id>378</ingredient_id>
          <scurrent>43</scurrent>
          <snew>43</snew>
          <smaxcapa>30</smaxcapa>
        </stock_info>
      </stock_replenishment>
    </delivery_info>
  </robot_taskboard>
}
</robot_sandra>