SELECT xmlelement(name orders,
xmlagg(xmlelement(name order, xmlattributes(orders.orderid AS orderID),
xmlforest(orders.status, orders.totalprice, orders.invoice),
xmlelement(name orderiteminfo, 
xmlelement(name orderitem, xmlattributes(orderitem.orderitemid AS orderItemID),
xmlelement(name menu, xmlattributes(menu.menuid AS menuID),
xmlforest(menu.name)))))))

FROM orders 
JOIN orderitem  ON orderitem.orderid = orders.orderid
JOIN menu ON menu.menuid = orderitem.menuid
WHERE orderitem.menuid != '0' AND menu.price>20;