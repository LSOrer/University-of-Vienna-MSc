<orderitem_burgerbun>
{
for $customer_details at $pos in doc("result1.xml")/orders/order
let $order_data := doc("result2.xml")/orderitems/orderitem[position() = $pos]
let $menu := doc("result3.xml")/menus/menu[position() = $pos]
return
  <orderitem_deepdive>
    <orderitem_meta item_id="{
                $order_data/@orderitemid
            }">
      <itname>
        {
            data($order_data/menu/name)
        }
      </itname>
      <itsize>
        {
            data($menu/size/text())
        }
      </itsize>
      <itcost>
        {
            data($menu/price/text())
        }
      </itcost>
    </orderitem_meta>
    <ingredient_info>
      <ingredient ingredient_id="{
                $order_data/menu/menuitem/@menuitemid
            }">
        <inname>
        {
            data($order_data/menu/menuitem/burger/name)
        }
        </inname>
        <intype>Burger</intype>
      </ingredient>
      <stock_status>
        <stock_info stock_id="1">
          <scurrent>20</scurrent>
          <snew>30</snew>
          <smaxcapa>50</smaxcapa>
        </stock_info>
      </stock_status>
    </ingredient_info>
  </orderitem_deepdive>
}
</orderitem_burgerbun>