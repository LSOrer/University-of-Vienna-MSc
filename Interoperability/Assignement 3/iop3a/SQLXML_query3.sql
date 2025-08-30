/* SQLXML_query3 without xml datatype
    used tables: OrderItem, Ingredient, Stock
*/

SELECT xmlroot(
		xmlelement(name orderitem_burgerbun,
			xmlagg(
				xmlelement(name orderitem_deepdive,
      			 xmlelement(name orderitem_meta, xmlforest(oi.item_id, oi.itname, oi.itsize, oi.itcost)),
		   			xmlelement(name ingredient_info,
					 xmlelement(name ingredient,
						   xmlforest(i.inname, i.inalergic, i.intype)),
	   xmlelement(name stock_status, xmlelement(name stock_info,
						   xmlforest(s.scurrent, s.snew, s.smaxcapa))))))
				 ), version 1.0, standalone yes)
				 
FROM public."OrderItem" oi
	FULL JOIN public."Ingredient" i
	ON oi.ingredient_id=i.ingredient_id
	FULL JOIN public."Stock" s
	ON s.stock_id=i.stock_id

WHERE oi.itname ='Burgerbun'