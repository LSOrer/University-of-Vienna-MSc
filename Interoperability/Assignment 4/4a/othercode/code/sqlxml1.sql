SELECT xmlelement (name orders,
xmlagg(xmlelement(name order, xmlattributes(orders.orderid AS orderID),
xmlelement(name customer, xmlattributes(customer.customerid AS customerID),
xmlforest(customer.contactdetails)),
xmlelement(name orderInfo, xmlforest(orders.totalprice, orders.status, 
orders.orderstarttime, orders.orderendtime),
xmlelement(name items, 
xmlelement(name orderitem, xmlattributes(orderitem.orderitemid AS orderitemID),
xmlelement(name info, xmlforest(orderitem.quantity, orderitem.duration))))))))

FROM orders
JOIN customer ON customer.customerid = orders.customerid
JOIN orderitem ON orders.orderid = orderitem.orderid
WHERE customer.gender = 'Female' AND orders.totalPrice > 18;
