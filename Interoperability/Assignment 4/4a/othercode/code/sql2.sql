SELECT orderitem.orderitemid, menu.menuid, menu.name, menuitem.menuitemid, burger.burgerid, burger.name, burger.numberingredients, orderitem.duration
FROM orders 
JOIN orderitem ON orderitem.orderid = orders.orderid
JOIN menu ON menu.menuid=orderitem.menuid
JOIN menuitem ON menuitem.menuid=menu.menuid
JOIN burger ON burger.burgerid = menuitem.burgerid
WHERE burger.NumberIngredients>7;