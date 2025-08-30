/* SQLXML_query3 without xml datatype
    used tables: OrderItem, Ingredient, Stock
*/

SELECT xmlroot(
xmlelement(name orderitem_burgerbun,
			xmlagg(
xmlelement(name orderitem_deepdive,
	xmlelement(name orderitem_meta, xmlattributes(oi.item_id as item_id), xmlforest(oi.itname, oi.itsize, oi.itcost)),
xmlelement(name ingredient_info,
	xmlelement(name ingredient, xmlattributes(i.ingredient_id as ingredient_id),
		xmlforest(i.inname, i.inalergic, i.intype)),
	xmlelement(name stock_status, xmlelement(name stock_info, xmlattributes(s.stock_id as stock_id),
		xmlforest(s.scurrent, s.snew, s.smaxcapa))))))
				 ), version 1.0, standalone yes)
				 
FROM public."OrderItem" oi
	FULL JOIN public."Ingredient" i
	ON oi.ingredient_id=i.ingredient_id
	FULL JOIN public."Stock" s
	ON s.stock_id=i.stock_id

WHERE oi.itname ='Burgerbun'
