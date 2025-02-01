When text is changed into vector embeds and saved into a vector embed database for your LLM to use, or when a LLM model is trained, here's what mathematically happens

### **But firstly, definitions:**
- A word may be broken into one token or a few tokens. Remember a token represents a word or subword.

### **And how tokens relate to vectors and 3d space**
That token takes up a 3d space with other tokens, and the distance between two tokens depend how similar they are to each other.

For a token to take up 3d space, there needs to be a mathematical equation, usually in the form of x, y, z, which could be represented as `x + 2y + 3z`, and when explaining that math, there are three terms here. It's usually represented in matrix form as [x, 2y, 3z], and when explaining that math, there are three components in there.

These equations are called vectors because vector equations have a spatial component to it. They're actually called vector embeddings because you "embed" the semantic meaning of the text into this vector space, allowing for numerical operations like distance and similarity calculations.

### **It's actually more than 3d space**
In AI models, there are more than 3 dimensions. It's considered a high-dimensional vector space so you could have [x1, x2, x3, ..., x768]. With these different dimensions, you can explain more features:
- Is the token a noun or a verb?
- Does it refer to something positive or negative?
- What other words frequently appear in its context?
  
Therefore, the idea remains the same, regardless if it's a higher dimension than 3d: each token's vector can be thought of as a point in this space, and transformations via weights, biases, and activation functions change its position in this space.

And the distance between that token and another token in one dimension can reveal how similar or dissimilar they are in that dimension (eg. is it a positive or negative sentiment).

However for simplicity sake, my mathematical explanations will be with 3 dimensions.

### **Weights and Biases**
Your model may have been pretrained on English and knowledge, however as the world changes, you may need to update its knowledge. During training of datasets (Refer to [[Training AI - Concept PRIMER]]), the components or terms have their numbers readjusted. For example [x, 2y, 3z] may become [x, 1.7y, 3.1z]. In addition, there is an intercept (eg. x + 2y + 3z + 100) which is the constant you add to the summation of terms.

When it comes the AI word, the coefficient are the weights that readjust where the token is placed in the high dimensional vector space, the intercept constant is the bias that's added. Why is the bias important? Because we do not want the possibility of the sum zeroing out, which will break complex understanding.

In code, the concept can be represented with Numpy Arrays (which represents matrix):
```
coefficients = np.array([1, 2, 3])
variables = np.array([1, 2, 3])  # x = 1, y = 2, z = 3
bias = 100

result = np.dot(coefficients, variables) + bias
print(result)  # Output will be 1*1 + 2*2 + 3*3 + 100 = 1 + 4 + 9 + 100 = 114

```

### **Layers and Activator**

After computing the weighted sum and bias, the result is passed through an **activation function** (like ReLU, sigmoid, or tanh). The activation function adds non-linearity to the model, which is crucial for learning complex patterns.

The **activation function** applies further transformations but does not necessarily apply more weights or biases. Instead, it transforms the sum into a value that can be fed to the next layer of the network or used as the output.

**Layers** in a neural network are the building blocks that process data and transform it step by step from the input to the output. Each layer applies a transformation to the data, passing the output to the next layer. This allows the network to learn increasingly complex features of the input data at each layer.

### Types of Layers:

1. **Input Layer**:
    
    - The **input layer** is where the raw input data (e.g., tokens, pixel values) enters the model. It doesn't apply any transformation; it simply passes the input data to the next layer in the network.
      
2. **Hidden Layers**:
    
    - **Hidden layers** perform transformations on the input data. These layers are called "hidden" because they are not visible to the external environment (they are internal to the model).
    - Each neuron (node) in a hidden layer computes a **weighted sum** of its inputs (from the previous layer), adds a **bias**, and then applies an **activation function** to produce an output.
    - A model can have multiple hidden layers, which allows it to learn complex features. Deeper networks (with more hidden layers) are often called **deep neural networks (DNNs)**.
      
3. **Output Layer**:
    
    - The **output layer** produces the final prediction, classification, or output of the model. The number of neurons in the output layer corresponds to the number of classes or dimensions the model is trying to predict.

### Layers know the activation function

- Each layer stores the type of **activation function** it uses. Activation functions are used to transform the output of a layer (often a vector of values) before passing it to the next layer. The purpose of an activation function is to introduce non-linearity into the model, enabling the network to learn more complex patterns. Without activation functions, a neural network would behave like a simple linear model, regardless of how many layers it has.
    
    - **ReLU** (Rectified Linear Unit): Passes positive values through unchanged and sets negative values to zero.
    - **Sigmoid**: Compresses the input to a value between 0 and 1.
    - **Tanh**: Compresses the input to a value between -1 and 1.
      
- The activation function is part of the model's architecture and is defined when constructing each layer. It doesn’t have parameters like weights or biases, but the type of activation function is stored and applied to the output of each neuron in that layer.

![](u1C5bjE.png)

^ From: https://www.researchgate.net/figure/An-example-of-a-deep-neural-network-with-two-hidden-layers-The-first-layer-is-the-input_fig6_299474560