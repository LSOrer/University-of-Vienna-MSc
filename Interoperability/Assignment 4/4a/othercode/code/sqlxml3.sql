SELECT xmlelement (name menus,
xmlagg(xmlelement(name menu, xmlattributes(menu.menuid AS menuID),
xmlforest(menu.name, menu.price, menu.size),
xmlelement(name menuitem, xmlattributes(menuitem.menuitemid AS menuItemID),
xmlelement(name drink, xmlattributes(drink.drinkid AS drinkID),
xmlelement(name drinkInfo, xmlforest(drink.name, drink.size)),
xmlelement(name ice, drink.ice))))))

FROM menu
JOIN menuitem ON menuitem.menuid = menu.menuid
JOIN drink ON drink.drinkid = menuitem.drinkid
WHERE menu.size = 'Small' AND drink.ice = TRUE;
