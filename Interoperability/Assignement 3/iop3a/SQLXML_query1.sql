/* SQLXML_query1 with xml datatype (address)
    used tables: Customer, Order, Robot
*/

SELECT xmlroot(
		xmlelement(name customer_data,
			xmlagg(
       xmlelement(name customer_details, xmlforest(cu.customer_id, cu.lname, cu.fname, cu.bday, cu.address),
	   xmlelement(name order_data,
				 xmlelement(name orders,
						   xmlforest(o.order_id, o.item_id, o.robot_id))),
				 xmlelement(name robots,
						  xmlforest(r.rname, r.rtype, r.rfunction)))))
				   ,version 1.0, standalone yes)
				  			
FROM public."Customer" cu
	FULL JOIN public."Order" o
	ON cu.customer_id=o.customer_id
	FULL JOIN public."Robot" r
	ON o.robot_id=r.robot_id

WHERE cu.customer_id < 31	
