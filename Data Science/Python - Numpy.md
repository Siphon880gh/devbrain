
**Numpy:**
https://www.learnpython.org/en/Numpy_Arrays <-- Playgrounds/Sandboxes

NumPy is the fundamental package for **scientific computing in** Python. It is a Python library that provides a multidimensional array object, various derived objects (such as masked arrays and matrices), and an assortment of routines for fast operations on arrays, including mathematical, logical, shape manipulation, sorting, selecting, I/O, discrete Fourier transforms, basic **linear algebra**, basic **statistical operations**, random simulation and much more.

**How to experiment:**
1. Use the playgrounds/sandboxes
2. Try to come up with a goal (for example, first sandbox we see a list of heights from test participants. But what's the average height?)
3. Look up functions at a Numpy Reference
https://numpy.org/doc/stable/reference/

**Problem:**
At the first sandbox we have the lists of people's heights and weights. If we want to find the average height among the test subjects, notice we imported numpy as np. Then you'll read numpy has an average function that takes in a required argument array. Find the average height.

Looking into the Numpy reference, you found:
https://numpy.org/doc/stable/reference/generated/numpy.average.html#numpy-average

**Answer**: `print(np.average(np_height))`