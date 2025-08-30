import numpy as np
import sklearn
import sklearn.datasets
from matplotlib import pyplot as plt
import matplotlib

if __name__ == "__main__":
    print("PCA: Olivetti Faces Example")
    
    ## load dataset, resize images to 32x32, subtract mean
    data = sklearn.datasets.fetch_olivetti_faces()

    images = []
    for i in range(len(data.images)):
        from PIL import Image
        img = Image.fromarray(data.images[i])
        img.thumbnail((32, 32), Image.BICUBIC)  # resizes image in-place
        images.append(np.array(img).ravel())
    images = np.array(images)
    mean = np.mean(images, axis=0)
    images = images - mean.reshape((1, 32*32))

    ## compute covariance matrix, and eigenvaleus and eigenvectors
    cov = np.cov(images.T)
    ew, ev = np.linalg.eigh(cov) # each column in ev is an unit length eigenvector
    ew = np.real(ew)

    ## show covariance matrix
    plt.clf()
    plt.imshow(cov, cmap=matplotlib.cm.get_cmap("jet"))
    plt.savefig("covariance.png", dpi=300, bbox_inches="tight")

    ## sort eigenvalues and reorder eigenvectors accordingly
    order = np.argsort(ew)[::-1]
    ew = ew[order]
    ev = ev.T[order].T

    ## compute projection and compute covariance matrix of projected data
    proj_images = []
    for i in range(len(images)):
        proj_images.append(np.dot(ev[:,:10].T, images[i]))
    proj_images = np.array(proj_images)
    cov_proj = np.cov(np.array([proj_images[i].ravel() for i in range(len(images))]).T)
    plt.clf()
    plt.imshow(cov_proj, cmap=matplotlib.cm.get_cmap("jet"))
    plt.savefig("covariance_projection.png", dpi=300, bbox_inches="tight")

    ## plot example images from the data
    for i in range(20):
        plt.clf()
        plt.imshow((images[i] + mean).reshape((32,32)), cmap=matplotlib.cm.get_cmap("gray"))
        plt.savefig("example%02d.png" % i, dpi=300, bbox_inches="tight")

    ## plot variation of reconstruction when scaling only the first principal eigenvector
    for i in range(20):
        plt.clf()
        plt.imshow((mean + ev[:,0] * float((i-10)) / 1.).reshape((32,32)), cmap=matplotlib.cm.get_cmap("gray"))
        plt.savefig("rec%02d.png" % i, dpi=300, bbox_inches="tight")

    ## plot the mean face
    plt.clf()
    plt.imshow(mean.reshape((32,32)), cmap=matplotlib.cm.get_cmap("gray"))
    plt.savefig("mean.png", dpi=300, bbox_inches="tight")

    ## reconstruct a face from more and more principal components
    for i in range(100):
        proj = np.dot(ev[:,:i+1].T, images[0])
        rec = mean + np.dot(ev[:,:i+1], proj)
        plt.clf()
        plt.imshow(rec.reshape((32,32)), cmap=matplotlib.cm.get_cmap("gray"))
        plt.savefig("recsingle-ev%02dd.png" % i, dpi=300, bbox_inches="tight")

 