
Required knowlege: [[Training AI - Concept PRIMER]]
Recommended but not required knowledge: [[AI Vector Math - Weights, Biases, Activation, Layers]]

## Normal vs Hyperparameters

- **Normal parameters** (weights and biases) are the values that the model learns during training and directly impact the predictions the model makes. Happens during the training process. The model continuously updates the weights and biases based on the error or loss it computes after each prediction. You might try different values for the learning rate, batch size, or number of layers, and observe how these changes affect the model's performance.
- **Hyperparameters** are settings defined before training that control the learning process and architecture of the model, but they are not adjusted during training. Both are essential for building and fine-tuning a model, but they have different roles and are handled differently in the training process. 

Here’s a comparison table that outlines the key differences between **parameters** and **hyperparameters** in machine learning models:

| **Aspect**                  | **Parameters (Weights & Biases)**                           | **Hyperparameters**                                        |
|-----------------------------|-------------------------------------------------------------|------------------------------------------------------------|
| **Definition**               | Values that are learned by the model during training, such as the weights and biases. | Settings that are manually defined before training and control the learning process. |
| **Examples**                 | - Weights in a neural network<br>- Biases in a neural network | - Learning rate<br>- Batch size<br>- Number of layers<br>- Number of epochs |
| **Role**                     | Directly control the model’s output by transforming inputs. | Control how the model learns and the structure of the model. |
| **Set or Learned?**          | Learned automatically during training using algorithms like gradient descent. | Set manually before training begins. Not learned by the model. |
| **Tuning Method**            | Adjusted during training via backpropagation and gradient descent. | Tuned through techniques like grid search, random search, or manually. |
| **Updated During Training?** | Yes, updated continuously during training based on the loss function. | No, remain fixed during the entire training process (unless redefined for a new training run). |
| **Storage**                  | Stored as part of the model's internal state, typically in weight and bias matrices. | Defined in configuration files (e.g., `params.json`) or set in the training script. |
| **Impact on Model**           | Define the model's prediction by learning patterns from the data. | Control how the model trains, including learning speed, complexity, and regularization. |
| **Scope**                    | Specific to the connections between neurons or layers in the network. | Apply to the overall training process or model architecture. |
| **Optimization Method**      | Optimized during training using methods like gradient descent and backpropagation. | Selected based on experience or tuning methods like cross-validation, grid search, or random search. |
| **Examples in Neural Networks** | - Weight matrices between layers<br>- Bias terms for each neuron | - Number of layers in the network<br>- Learning rate for gradient descent<br>- Dropout rate for regularization |


Before training, you set **hyperparameters** like:
    - The **learning rate** (e.g., 0.01).
    - The **number of neurons** in the hidden layer (e.g., 128).
    - The **number of epochs** (e.g., 20).
    - The **activation function** used in the hidden layer (e.g., ReLU).
These hyperparameters guide how the model learns the weights and biases.

Mnemonic: One way to remember hyperparameters is to think of them as "metaparameters". Those would be the parameters you set in a config file (for web developers, that's like meta tags though that's at a config section). Meta is about the process. Normal parameters are the weights and biases adjusted automatically.

---

## Hyperparameters in LLaMA Model

Many model-loading scripts or frameworks (e.g., PyTorch, Hugging Face) will reference `params.json` or a similar configuration file to set up the model structure when loading it for inference or further training.

For example, in Meta's LLaMA model, hyperparameters are stored in configuration files like `params.json`. This file can contain a variety of settings that govern how the model was structured and trained. The exact contents and format may vary depending on the specific model version.

When you download a LLaMA model from [[Download Model - Llama]], it'll come with multiple files including .pth (python torch model) and the params.json

### Common Hyperparameters in `params.json`:

1. **Model Architecture Hyperparameters**:
   - **`n_layers`**: The number of layers (depth) in the neural network.
   - **`n_heads`**: The number of attention heads in each transformer layer.
   - **`d_model`**: The dimensionality of the input and output vectors (i.e., the size of each token’s embedding).
   - **`d_ff`**: The size of the feed-forward network (often 4 times the model dimension).
   - **`vocab_size`**: The size of the model's vocabulary (the number of unique tokens it can process).
   - **`max_seq_len`**: The maximum sequence length the model can process at once (the number of tokens it can handle in one input).

2. **Training Hyperparameters**:
   - **`learning_rate`**: Specifies the learning rate used during training, which controls the step size for updating weights.
   - **`batch_size`**: The number of samples processed before updating the model’s parameters.
   - **`num_epochs`**: The number of times the model was trained over the entire dataset.
   - **`dropout`**: The dropout rate used during training to prevent overfitting by randomly setting some neurons to zero during forward passes.
   - **`optimizer`**: The optimization algorithm used to update the model’s parameters (e.g., Adam, SGD).
   - **`warmup_steps`**: The number of steps during which the learning rate is gradually increased at the beginning of training.

3. **Positional Encoding Hyperparameters**:
   - **`use_rotary_embeddings`** or **`rotary_dim`**: Information about whether rotary embeddings are used for positional encoding, a common approach in transformer models like LLaMA.
   - **`use_sinusoidal_positional_encoding`**: Specifies if sinusoidal positional encoding is used to help the model understand the order of tokens in a sequence.

4. **Model-Specific Hyperparameters**:
   - **`bias`**: Whether or not biases are used in specific layers (e.g., attention layers).
   - **`activation_function`**: The type of activation function used in layers (e.g., GELU, ReLU).
   - **`layer_norm_epsilon`**: A small value added to the denominator in layer normalization to avoid division by zero.

### Example Structure of `params.json`:

Here’s a hypothetical example of what might be included in a `params.json` file for a LLaMA model:

```json
{
  "n_layers": 32,
  "n_heads": 16,
  "d_model": 4096,
  "d_ff": 16384,
  "vocab_size": 32000,
  "max_seq_len": 2048,
  "learning_rate": 0.0001,
  "batch_size": 128,
  "num_epochs": 10,
  "dropout": 0.1,
  "optimizer": "adam",
  "warmup_steps": 10000,
  "use_rotary_embeddings": true,
  "rotary_dim": 64,
  "bias": false,
  "activation_function": "gelu",
  "layer_norm_epsilon": 1e-5
}
```

### Purpose of `params.json`:
- This file stores the **hyperparameters** that were used to define the model architecture and guide the training process.
- When you load a pre-trained model (like LLaMA), these hyperparameters are critical for reconstructing the model architecture and ensuring it functions properly with the pre-trained weights.

### Why It’s Important:
- **Reproducibility**: If you want to fine-tune or use a model, the exact same hyperparameters must be used to ensure the model behaves as expected.
- **Loading the Model**: Many model-loading scripts or frameworks (e.g., PyTorch, Hugging Face) will reference `params.json` or a similar configuration file to set up the model structure when loading it for inference or further training.

In summary, the `params.json` file for a model like LLaMA indeed contains the **hyperparameters** that define the model's architecture and training behavior. These hyperparameters play a critical role in ensuring the model can be correctly reloaded and used after it has been pre-trained or fine-tuned.