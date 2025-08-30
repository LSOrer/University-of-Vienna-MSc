<order_data_all>
{
for $customer_details at $pos in doc("result1.xml")/orders/order
let $order_data := doc("result2.xml")/orderitems/orderitem[position() = $pos]
let $menu := doc("result3.xml")/menus/menu[position() = $pos]
return
  <order_meta order_id="{
                $customer_details/@orderid
            }">
    <order_date>
        {
             substring($customer_details/orderinfo/orderendtime/string(), 1, 10)
        }  
    </order_date>
    <orderdetail>
      <Orderdetails>
        <OrderID>
        {
            data($customer_details/@orderid)
        }
        </OrderID>
        <OrderItems>
          <Item1>
        {
            data($order_data/menu/menuitem/burger/name)
        }
          </Item1>
          <Item2>
        {
            data($menu/menuitem/drink/drinkinfo/name)
        }
          </Item2>
          <Item3>opt. Item 3</Item3>
        </OrderItems>
        <Total>
        {
            data($customer_details/orderinfo/totalprice)
        }
        </Total>
      </Orderdetails>
    </orderdetail>
    <orderitems item_id="{
                $customer_details/orderinfo/items/orderitem/@orderitemid
            }">
      <itname>opt.</itname>
      <itsize>o</itsize>
      <itcost>0</itcost>
    </orderitems>
    <ingredients ingredient_id="404">
      <inname>othercode does not handle ingredients</inname>
      <intype>well .. happens</intype>
    </ingredients>
  </order_meta>
}
</order_data_all>