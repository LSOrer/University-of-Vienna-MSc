#Create set of candidate keys based on previous apriori level (L)
def apriori_gen(L):
    #List of current L keys
    keyset = list(L.keys())

    #Temporary dictionary of new candidate keys (L+1)
    temp = dict()

    #Sorting keys prevents duplicates (eg ABC vs ACB)
    for i in range(0,len(keyset)-2):
        temp_keys_1 = sorted(str(keyset[i]).split(";"))
        for j in range(i+1, len(keyset)-1):
            temp_keys_2 = sorted(str(keyset[j]).split(";"))
            #Iterate through items of 2nd key, if the key consists of multiple elements
            if len(temp_keys_2)>1:
                for k in range(0, len(temp_keys_2)):
                    if temp_keys_2[k] not in temp_keys_1:
                        #Sort elements of key to prevent duplicates
                        temp_arr = temp_keys_1.copy()
                        temp_arr.append(temp_keys_2[k])
                        temp_arr = sorted(temp_arr)

                        #Combine key and initialize dictionary entry for the key
                        temp_keystring = ""
                        for l in range(0, len(temp_arr)-1):
                            temp_keystring += str(temp_arr[l]) +";"
                        temp_keystring += str(temp_arr[len(temp_arr)-1])

                        temp[temp_keystring] = 0
            else:
                #Combine key and initialize dictionary entry for the key
                temp_keystring = ""
                for l in range(0, len(temp_keys_1)):
                    temp_keystring += str(temp_keys_1[l]) + ";"
                temp[temp_keystring + keyset[j]] = 0

    return temp

#Returns frequent items out of dictionary
def get_frequent(L):
    for key in L.copy():
        if L[key] < rel_min_support:
            L.pop(key)
    return L

#Recommend a movie with highest support
def recommend(L, comparison):
    support = 0
    recommendations = set()

    #Iterate through levels starting at level corresponding to the comparison list (eg start level 3 for 2 items A;B)
    for i in range (len(comparison), len(L)):
        for key in L[i].keys():
            key_elements = set(key.split(";"))
            if set(comparison).issubset(key_elements):
                if L[i][key]>support:
                    support = L[i][key]
                    recommendations = key_elements - set(comparison)
        if (support!=0):
            #Generate key and access dicitionary
            temp_keystring = ""
            comparison=sorted(comparison)
            for l in range(0, len(comparison)-1):
                temp_keystring += str(comparison[l]) + ";"
            temp_keystring+=str(comparison[len(comparison)-1])
            #Return recommendation with confidence, if any recommendation is found
            return str(recommendations) + " with a convidence of " +str(support/L[i-1][temp_keystring])
    return support

#Initialize list for all levels of L
L = list()

#Initialize the first level L1
L1 = dict()
L.append(L1)

#Relative minimum support value
rel_min_support = 444

#Initialize transaction list
transactions = list()

#File location
file = open('./movies.txt', "r")

#Candidates length-1
for line in file.readlines():
        #Strip newline
        line = line.rstrip('\n')

        #Split by semicolon
        components = line.split(";")

        #Add components to transaction list
        transactions.append(components)

        #Count support for components
        for component in components:
            if str(component) in L[0]:
                L[0][component]=L[0][component]+1
            else:
                L[0][component]=1

#Create frequent itemsets length-1
for key in L[0].copy():
    if L[0][key] < rel_min_support:
        L[0].pop(key)

#Open oneItems.txt
oneOpen = open('./oneItems.txt', "w")

#Write oneItems.txt
for key in L[0]:
    oneOpen.write(str(L[0][key]) +":" +key +"\n")

C = list()
k = 1

#Apriori generation ends, if the frequent item set is empty
while (L[k-1]):
    #Generate a dictionary with all possible subsets
    C.append(apriori_gen(L[k-1]))

    #Iterate through list of transactions
    for transaction in transactions:
        temp_transaction = set(transaction)

        #Match candidates with transactions in order to calculate support
        for key in C[k-1].keys():
            temp_candidates = set(str(key).split(";"))
            if temp_candidates.issubset(temp_transaction):
                C[k-1][key]+=1

    #Create new dictionary for next apriori level
    temp = dict()
    L.append(temp)

    #Add frequent sets to current level
    L[k] = get_frequent(C[k-1])
    k+=1

#Open patterns.txt
patterns = open('./patterns.txt', "w")

#Iterate through all levels and write into patterns.txt
for level in L:
    # Write patterns.txt
    for key in level:
        patterns.write(str(level[key]) + ":" + key + "\n")

#Check movie recommendation
movies = ["Ant-Man and the Wasp", "Spider-Man: Far from Home"]
print(recommend(L, movies))