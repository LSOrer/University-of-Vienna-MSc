SELECT menu.menuid, menu.name, menu.price, menu.size, menuitem.menuitemid, drink.drinkid, drink.name, drink.size, drink.ice
FROM menu
JOIN menuitem ON menuitem.menuid = menu.menuid
JOIN drink ON drink.drinkid = menuitem.drinkid
WHERE menu.size = 'Small' AND drink.ice = TRUE;