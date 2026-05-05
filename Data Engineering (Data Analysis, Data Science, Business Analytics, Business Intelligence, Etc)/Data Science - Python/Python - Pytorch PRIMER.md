
Get Started

If new to Pytorch, it isn't recommended to go directly into it. Instead, you should look into using Whisper which relies on Pytorch.

You'll see Pytorch can select the algorithm to work with your processor (CUDA, etc), then loads in the LLM model, then takes in your inputs and instructions, then spits out your output, simply put.

---

### Quick Start for PyTorch

#### 1. Install PyTorch:
First, install PyTorch using pip:
```bash
pip install torch torchvision
```

#### 2. Create a Simple Neural Network:
Here’s how to define a simple neural network using PyTorch:
```python
import torch
import torch.nn as nn
import torch.optim as optim

# Define a simple neural network
class SimpleNN(nn.Module):
    def __init__(self):
        super(SimpleNN, self).__init__()
        self.fc1 = nn.Linear(784, 128)  # Input: 784 (e.g., MNIST), Output: 128
        self.fc2 = nn.Linear(128, 10)   # Output layer: 10 classes

    def forward(self, x):
        x = torch.relu(self.fc1(x))
        x = self.fc2(x)
        return x

# Initialize the network, loss function, and optimizer
model = SimpleNN()
criterion = nn.CrossEntropyLoss()
optimizer = optim.Adam(model.parameters(), lr=0.001)
```

#### 3. Training Loop Example:
Here’s a basic training loop:
```python
# Dummy input (batch size = 64, 784 input features)
inputs = torch.randn(64, 784)
# Dummy labels (batch size = 64, 10 classes)
labels = torch.randint(0, 10, (64,))

# Training loop
for epoch in range(10):  # Train for 10 epochs
    # Zero the gradients
    optimizer.zero_grad()
    
    # Forward pass
    outputs = model(inputs)
    loss = criterion(outputs, labels)
    
    # Backward pass
    loss.backward()
    
    # Update weights
    optimizer.step()
    
    print(f"Epoch [{epoch+1}/10], Loss: {loss.item():.4f}")
```

#### 4. GPU Support (Optional):
Move your model and tensors to the GPU if available:
```python
device = torch.device('cuda' if torch.cuda.is_available() else 'cpu')
model.to(device)
inputs, labels = inputs.to(device), labels.to(device)
```
