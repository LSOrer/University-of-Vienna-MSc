import numpy as np
import matplotlib.pyplot as plt
from mpl_toolkits.mplot3d import Axes3D

# File location
file = './lab_iris_data.csv'

# Function for changing label names into 1 and 0
def label_mapping(name):
    class_names = {
        b'Iris-setosa': 0,
        b'Iris-versicolor': 1
    }
    return class_names.get(name)

# Hyptohesis function 
def hypothesis(x, theta):
    return 1/(1+np.exp(np.dot(-x, theta)))

# Loss function
def loss_function(theta, features, labels, reg_factor):
    loss = 0;
   
    for i in range(0, len(features[:, ])):
        loss += (-1 * labels[i] * np.log(hypothesis(features[i], theta))) - ((1-labels[i]) * np.log(1-hypothesis(features[i], theta))) + reg_factor/2
    return loss

# Returns gradient of a sample
def grad(theta, features, labels, reg_factor):
    grad = [0, 0, 0, 0];
   
    for i in range(0, len(features[:, ])):
        grad += np.dot((hypothesis(features[i], theta) - labels[i]), features[i].T) + (reg_factor * theta)

    return grad

# Algorithm 1: Stochastic gradient descent algorithm
def train_classifier(num_iter, learning_rate, batch_size):
    # Initialize theta = 0
    theta = [0, 0, 0, 0]

    #Initializes learning rate
    ninit = learning_rate

    # Iterates through the specified # of iterations
    for t in range(1, num_iter+1):
        # Creates random sub sample
        # Selecting random list elements cf. https://stackoverflow.com/questions/19436153/selecting-a-random-list-element-of-length-n-in-python
        random_idx = np.random.randint((len(dataset[:])-1), size=batch_size)
        random_dataset_X = X[random_idx, :]
        random_dataset_y = Y[random_idx]

        # Calculates and updates theta
        theta = theta - (learning_rate * 1/batch_size * grad(theta, random_dataset_X, random_dataset_y, 1))

        # Updates learning rate
        learning_rate = ninit / np.sqrt(t)
        
    return theta

# Adds a column full of ones to the matrix to account for the bias
# Creating ones column cf. https://docs.scipy.org/doc/numpy/reference/generated/numpy.ones.html
def add_ones(matrix):
    return np.hstack((np.ones((matrix.shape[0], 1)), matrix))

# Dataset
# Usage of loadtxt method cf. https://docs.scipy.org/doc/numpy/reference/generated/numpy.loadtxt.html
dataset = np.loadtxt(file, delimiter = ',', converters = {3: lambda s: label_mapping(s)})

# Creates feature matrix X and adds ones for bias
X = dataset[:, 0:(len(dataset[0])-1)]
X = add_ones(X)

# Creates label vector Y
Y = dataset[:, (len(dataset[0])-1)]

# Calculates the final theta
final_theta = train_classifier(30, 0.1, 10)

# Plots a 3D Plot
# Usage of plot cf. https://matplotlib.org/3.1.1/tutorials/introductory/pyplot.html
fig = plt.figure()
ax = plt.axes(projection='3d')
ax.set_xlim(4, 7)
ax.set_ylim(2, 5)
ax.set_zlim(0, 5)
ax.set_xlabel('X axis')
ax.set_ylabel('Y axis')
ax.set_zlabel('Z axis')

# Displays all data points of the dataset as a 3D scatter
# Creating of scatter plot cf. https://matplotlib.org/3.1.1/gallery/mplot3d/scatter3d.html
ax.scatter3D(dataset[:, 0], dataset[:, 1], dataset[:, 2], c=dataset[:, 3])

# Creates a meshgrid for the area of the hyperplane
# Creating meshgrid cf. https://docs.scipy.org/doc/numpy/reference/generated/numpy.meshgrid.html
xx1, xx2= np.meshgrid(np.linspace(dataset[:, 0].min(), dataset[:, 0].max(), 100),
                      np.linspace(dataset[:, 1].min(), dataset[:, 1].max(), 100))

# Defines hyperplane function Z
Z = -(final_theta[0] + final_theta[1] * xx1 + final_theta[2] * xx2)/final_theta[3]

# Plots the hyperplane
# Plot surface cf. https://matplotlib.org/mpl_toolkits/mplot3d/tutorial.html
ax.plot_surface(xx1, xx2, Z)

plt.show()
