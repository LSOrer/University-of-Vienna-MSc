import matplotlib.pyplot as plt
import numpy as np

data = np.loadtxt('abalone.csv', skiprows=1, delimiter=',')
print(data)

x = data[:,0]
y = data[:,1]

plt.scatter(x,y)
plt.xlabel('Diameter')
plt.ylabel('Weight')
plt.title('Abalone Diameter against Weight')

plt.show()
