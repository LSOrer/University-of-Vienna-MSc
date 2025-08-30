import matplotlib.pyplot as plt
import numpy as np

data = np.loadtxt('abalone.csv', skiprows=1, delimiter=',')
print(data)

x = data[:,0]
y = data[:,1]

X = np.stack([x, x**2, np.ones_like(x)], axis=1)

w1, w2, b = np.linalg.lstsq(X, y, rcond=None)[0]

y_hat = w1*x+w2*x**2+b

x_spaced = np.linspace(0.25, 0.6)
y_spaced = w1*x_spaced + w2*x_spaced**2 + b

plt.scatter(x,y, label='Abalone Data')
plt.plot(x_spaced, y_spaced, c='red', label='Linear Regression')
plt.grid()
plt.xlabel('Diameter')
plt.ylabel('Weight')
plt.title('Abalone Diameter against Weight')
plt.legend()
plt.show()