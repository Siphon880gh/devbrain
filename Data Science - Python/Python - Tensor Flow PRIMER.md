Get Started
### Quick Start for TensorFlow

#### 1. Install TensorFlow:
First, install TensorFlow using pip:
```bash
pip install tensorflow
```

#### 2. Create a Simple Neural Network:
Here’s how to define a simple neural network using TensorFlow (with Keras API):
```python
import tensorflow as tf
from tensorflow.keras import layers, models

# Define a simple neural network
model = models.Sequential([
    layers.InputLayer(input_shape=(784,)),     # Input: 784 (e.g., MNIST)
    layers.Dense(128, activation='relu'),      # Hidden layer with 128 units
    layers.Dense(10)                           # Output layer with 10 units (for 10 classes)
])

# Compile the model
model.compile(optimizer='adam', 
              loss=tf.keras.losses.SparseCategoricalCrossentropy(from_logits=True),
              metrics=['accuracy'])
```

#### 3. Training Loop Example:
Here’s a basic training process using TensorFlow:
```python
# Dummy input (batch size = 64, 784 input features)
inputs = tf.random.normal([64, 784])
# Dummy labels (batch size = 64, 10 classes)
labels = tf.random.uniform([64], minval=0, maxval=10, dtype=tf.int64)

# Train the model for 10 epochs
model.fit(inputs, labels, epochs=10)
```

#### 4. GPU Support (Optional):
TensorFlow automatically uses the GPU if available. You can check it with:
```python
print("Num GPUs Available: ", len(tf.config.list_physical_devices('GPU')))
```

Both of these frameworks will let you quickly define, train, and run neural networks. From here, you can explore further functionality, such as adding layers, trying different optimizers, or working with real datasets!