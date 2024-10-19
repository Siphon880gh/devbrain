
## PyTorch vs Tensorflow

The key difference between PyTorch and TensorFlow lies in how they execute code. Both frameworks revolve around the core data type called a tensor, which can be thought of as a multidimensional array*. However, PyTorch uses dynamic computation graphs (also called eager execution), meaning that it builds the graph as operations occur, making it more intuitive and easier to debug in real-time. This allows you to write code more naturally and inspect results at each step of the process.

On the other hand, TensorFlow traditionally uses static computation graphs, where the entire graph is built before running any operations. This provides optimization opportunities for deploying large-scale machine learning models but may require more setup and debugging effort. However, TensorFlow 2.x introduced eager execution to make it more accessible, bringing it closer to PyTorch in terms of ease of use.

In short, PyTorch is often preferred for research and experimentation due to its flexibility, while TensorFlow is favored in production environments for its performance and scalability. Both frameworks support automatic differentiation, GPU acceleration, and a wide range of machine learning applications, but their coding workflows and use cases can differ significantly.

---

## \*Multidimensional Array in Python: Lists, Numpy Array

In Python, the term "tensor" is generally associated with libraries like PyTorch and TensorFlow, where tensors are a core data type for handling multidimensional arrays. However, "tensor" itself is not a native Python data type.

In PyTorch, tensors are represented by the `torch.Tensor` class, while in TensorFlow, they are represented by the `tf.Tensor` class. Both libraries implement their own tensor data types to handle the complexities of deep learning computations efficiently, including support for GPU acceleration and automatic differentiation.

Outside of these frameworks, Python's native data structures like lists or NumPy arrays are often used to represent multidimensional arrays, but these are not referred to as "tensors" in the strict machine learning sense. So, while the concept of tensors exists in these libraries, it's not a native Python data type but rather a specialized one within those libraries.

---

## Programming Languages

PyTorch is used in Python. Like many libraries in Python, the library is named with the "Py" prefix.

TensorFlow, although primarily written in C++, is wrapped to be used by other programming languages. The most commonly used language  is Python. 

Python is used for defining, training, and deploying machine learning models due to its simplicity and ease of use, making it the language of choice for most TensorFlow users. Also, Python remains the dominant language for TensorFlow due to its large community support, extensive ecosystem, and integration with other popular machine learning tools.

TensorFlow provides support for other programming languages:

1. **C++**: While C++ is used under the hood, it also has an API for building models and performing machine learning tasks directly in C++.
2. **JavaScript**: With **TensorFlow.js**, you can run machine learning models directly in the browser or in Node.js environments.
3. **Java**: TensorFlow provides Java bindings to build and deploy models in JVM-based environments.
4. **Swift**: TensorFlow had an experimental project called **Swift for TensorFlow**, which allowed writing TensorFlow code in Swift. However, the project is no longer actively developed.
5. **Go**: TensorFlow also offers Go bindings for deploying models in Go applications.
6. **C#**: Through the TensorFlow.NET project, TensorFlow can also be used in .NET environments.


----

## Next Reading

The next suggested reading is [[Concept Primer - 2. Tokens, Vectors, Embeds]]

