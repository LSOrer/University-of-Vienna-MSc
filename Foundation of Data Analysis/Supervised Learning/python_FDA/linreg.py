# import packages
import numpy as np
import matplotlib.pyplot as plt
from random import gauss

# generating simulated data
alpha = 1
beta = 0.5
sigma = 1
N = 10

K = 1000 #number of repetitions
alpha_samples = np.zeros((2,0))

for k in range(K):
    # simulate data
    x = np.array([gauss(0,1) for i in range(N)])
    noise = np.array([gauss(0,sigma) for i in range(N)])
    y = np.multiply(alpha, x) + beta + noise

    # fit linear regression model
    z = np.append(x[:, None], np.ones((N,1)), axis = 1)
    A = np.dot(z.transpose(), z) / N
    b = np.dot(y,z) / N
    alpha_hat = np.dot(np.linalg.pinv(A), b)

    alpha_samples = np.append(alpha_samples, alpha_hat[:, None], axis = 1)

alpha_samples.shape


# plot results

plt.scatter(x,y, label='Random number')
plt.grid()
plt.xlabel('x')
plt.ylabel('y')
x_plot = np.linspace(-3,3,100)
y_true = np.multiply(alpha, x_plot)+beta
plt.plot(x_plot, y_true, c='green', label='Linear Regression')
y_fitted = np.multiply(alpha_hat[0], x_plot) + alpha_hat[1]
plt.plot(x_plot, y_fitted, 'r', label='Fitted LinReg')
plt.legend()

plt.figure(figsize=(10,7))
plt.hist(alpha_samples.transpose(), 50, label=('Alpha','Beta'))
plt.legend()
plt.show()