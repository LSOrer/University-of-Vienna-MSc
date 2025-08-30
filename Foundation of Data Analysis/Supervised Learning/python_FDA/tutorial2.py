price_list = {'apple': 3, 'grapes': 1.5, 'pineapple': 2, 'banana': 2.4}

apple_price = price_list['apple']

print('An apple costs {}€'.format(apple_price))

shopping_cart = ['apple', 'banana', 'grapes']

def calculate_total(products, prices):
    product_prices = [prices[product] for product in products]
    total = sum(product_prices)
    return total

print('The total is {}€'.format(calculate_total(shopping_cart, price_list)))