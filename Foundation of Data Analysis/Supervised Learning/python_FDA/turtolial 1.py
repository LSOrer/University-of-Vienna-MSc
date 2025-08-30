l = [1,2,3,4]

def multiply_by_n(l, n):
    new_list = []
    for i in l:
        new_list.append(i * n)
        return new_list

multiply_by_three = multiply_by_n(l, 3)

print('{} mulityplied by three is {}'.format(l,multiply_by_three))