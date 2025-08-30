SELECT orders.orderid, customer.customerid, customer.contactdetails, orders.totalprice, orders.status, orders.orderstarttime, orders.orderendtime, 
orderitem.orderitemid, orderitem.quantity, orderitem.duration
FROM orders
JOIN customer ON customer.customerid = orders.customerid
JOIN orderitem ON orders.orderid = orderitem.orderid
WHERE customer.gender = 'Female' AND orders.totalPrice > 18;
