/* SQLXML_query2 with xml datatype (orderdetail)
    used tables: Order, OrderItem, Ingredient
*/

SELECT xmlroot(
xmlelement(name order_data_all,
			xmlagg(
    xmlelement(name order_meta, xmlattributes(o.order_id as order_id), xmlforest(o.order_date, o.orderdetail),
	xmlelement(name orderitems, xmlattributes(oi.item_id as item_id), xmlforest(oi.itname, oi.itsize, oi.itcost)),
	xmlelement(name ingredients, xmlattributes(i.ingredient_id as ingredient_id), xmlforest(i.inname, i.inalergic, i.intype)))))
				,version 1.0, standalone yes)

FROM public."Order" o
	FULL JOIN public."OrderItem" oi
	ON o.item_id=oi.item_id
	FULL JOIN public."Ingredient" i
	ON oi.ingredient_id=i.ingredient_id

WHERE o.order_id > 100 AND o.order_id < 131		
