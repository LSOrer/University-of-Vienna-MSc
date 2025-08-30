#import packages
import numpy as np
import matplotlib.pyplot as plt
import pandas as pd

#load and pre-process data
data = pd.read_csv('iris_data.csv', header = None, delimiter=',')
z = data.to_numpy()
x = z[:,0:2].astype(float)
labels = z[:,-1]
y = np.array([i == 'Iris-setosa' for i in labels])
i0 = np.where(y==True)[0]
i1 = np.where(y==False)[0]
y = y.astype(int)

# train the LDA model

# estimate parameters
u0 = np.mean(x[i0,:], axis = 0)
u1 = np.mean(x[i1,:], axis = 0)

sigma0 = np.cov(x[i0,:].transpose())
sigma1 = np.cov(x[i1,:].transpose())
sigma = 0.5*(sigma0+sigma1)

# compute LDA model
inv_sigma = np.linalg.pinv(sigma)
w = np.dot(u1-u0, inv_sigma)
b = 0.5*(np.dot(np.dot(u0,inv_sigma),u0) - np.dot(np.dot(u1, inv_sigma), u1))
prior0 = len(i0) / len(x)
prior1 = len(i1) / len(x)
c = np.log(prior0 / prior1)

# evaluate model
yhat = np.sign(np.dot(x,w) + b - c) > 0
yhat = yhat.astype(int)
error = np.mean(yhat == y)

print(error)

# plot data
plt.grid()
plt.xlabel('feature 1')
plt.ylabel('feature 2')
plt.scatter(x[i0,0],x[i0,1], label='i0 Instances')
plt.scatter(x[i1,0],x[i1,1], label='i1 Instances')
plt.title('Linear Discriminant Analysis of Iris flowers')
plt.legend()

# plot decision boundary

delta = 0.025
xrange = np.arange(4,8,delta)
yrange = np.arange(2,4.5,delta)
Xplot, Yplot = np.meshgrid(xrange,yrange)
Zplot = w[0]*Xplot + w[1]*Yplot + b - c
plt.contour(Xplot, Yplot, Zplot, 0)
plt.show()

