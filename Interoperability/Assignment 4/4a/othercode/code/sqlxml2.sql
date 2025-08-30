SELECT xmlelement (name orderitems,
xmlagg(xmlelement(name orderitem, xmlattributes(orderitem.orderitemid AS orderitemID),
xmlelement(name menu, xmlforest(menu.menuid, menu.name),
xmlelement(name menuitem, xmlattributes(menuitem.menuitemid AS menuitemID),
xmlelement(name burger, xmlattributes(burger.burgerid AS burgerID),
xmlforest(burger.name, burger.numberingredients)))),
xmlelement(name orderiteminfo, 
xmlforest(orderitem.duration)))))

FROM orders 
JOIN orderitem ON orderitem.orderid = orders.orderid
JOIN menu ON menu.menuid=orderitem.menuid
JOIN menuitem ON menuitem.menuid=menu.menuid
JOIN burger ON burger.burgerid = menuitem.burgerid
WHERE burger.NumberIngredients>7;