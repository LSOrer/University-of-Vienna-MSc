SELECT orders.orderid, orders.status, orders.totalprice, orders.invoice, orderitem.orderitemid, menu.menuid, menu.name
FROM orders 
JOIN orderitem  ON orderitem.orderid = orders.orderid
JOIN menu ON menu.menuid = orderitem.menuid
WHERE orderitem.menuid != '0' AND menu.price>20;