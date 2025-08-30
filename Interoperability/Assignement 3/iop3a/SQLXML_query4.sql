/* SQLXML_query4 without xml datatype
    used tables: Robot, Delivery, Stock
*/

SELECT xmlroot(
		xmlelement(name robot_sandra,
			xmlagg( xmlelement(name robot_taskboard,
       xmlelement(name robot_info, xmlforest(r.robot_id, r.rname, r.rtype, r.rfunction)),
	   xmlelement(name delivery_info,
	   xmlelement(name delivery, xmlforest(d.delivery_id, d.ddate, d.vendor, d.damount)),
	   xmlelement(name stock_replenishment, 
	   xmlelement(name stock_info, xmlforest(s.ingredient_id, s.scurrent, s.snew, s.smaxcapa))))))
				 ), version 1.0, standalone yes)
				 
FROM public."Robot" r
	FULL JOIN public."Delivery" d
	ON r.delivery_id=d.delivery_id
	FULL JOIN public."Stock" s
	ON s.stock_id=d.stock_id

WHERE r.rname='Sandra' AND (d.vendor='Cocacola Comp.' OR d.vendor='FreshMarket')
