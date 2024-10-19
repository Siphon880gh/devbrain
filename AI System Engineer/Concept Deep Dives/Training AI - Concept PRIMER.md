In order for the AI to respond to our queries, it needs to learn about the world. You have to provide it time to train on datasets of inputs and outputs.
### Training time

Training AI takes time. The more powerful your computer, the faster it'll take. The amount of time in a pass is called Epoch. The AI is trained in multiple epoches, because one pass is not enough to learn all the important features.

### Train with Datasets

You provide datasets that train the AI, which could be csv. There are datasets that you train the AI with. An example data set is inputs and expected outputs. The training will consist of learning from your dataset, then testing if it predicted correctly with another dataset you provide to adjust hyperparameters. It runs one more test to check performance. 

FYI: When reading literature online about training AI, datasets have inputs and expected outputs, also called features and targets, respectively. You can have multiple inputs/features to one target at a data point.

A common split is:
- **Training set**: 70-80% of the total data.
- **Validation set**: 10-15% of the total data.
- **Test set**: 10-15% of the total data.

For example datasets, refer to [[Training AI - Example Datasets]]

> [!note] In the code: One huge dataset into three datasets
> In Python, Pandas pd can be used to read and save csv. You could load the csv using panda into dataframes, then split the dataframes into the three types of datasets, then save them as three csv files.


> [!note] In the code: Training
> This is beyond the scope of this tutorial. However, one approach is with the three datasets to use Python's Scikit-learn to train, then if you like it, you can save the model with joblib (or pickle). Then how do I use the model on new data to predict outputs? You can use the same library may that be joblib, then run their predict method on a csv that only has the inputs aka features. Then it would predict the outputs aka targets. For the code on training and then predicting, refer to [[Predict Values with Scikit-learn, Joblib]]


### Why Multiple Datasets

#### Why Separate Training and Validation Sets?

- **Prevent Overfitting**: If the model were tested on the same data it was trained on, it might perform well simply by memorizing the data. The validation set, which the model hasn’t seen during training, acts as a proxy for new, unseen data. This helps ensure the model is not just memorizing but generalizing.
    
- **Hyperparameter Tuning**: Hyperparameters like learning rate, batch size, and dropout rate are often tuned based on the model’s performance on the validation set. This ensures the model's training is optimized for better performance.
    
- **Early Stopping**: The validation set can help in implementing early stopping, where training is stopped once performance on the validation set starts to degrade (even if the training set performance is still improving). This helps prevent overfitting.
#### Why Test Set?

In addition to the training and validation sets, there is often a **test set**. This set is completely unseen by the model during training and validation. After the model is fully trained and optimized using the training and validation sets, the test set is used to evaluate the final performance. This gives a good sense of how the model will perform on entirely new data.

### Minimizing Incorrect Learning

There is a goal to minimize loss which is the discrepancy between the model’s predictions and the actual outcomes and mathematically it's done through statistical techniques like mean squared error for regression or cross-entropy loss for classification.

During training, optimization algorithms (like gradient descent) aim to find the set of parameters (weights and biases) that minimize the loss function. This is done by iteratively adjusting the weights to reduce the loss. For the mathematical explanation on weights, biases, activation, refer to: [[AI Vector Math - Weights, Biases, Activation, Layers]]

As part of the goal to minimize loss, we want to avoid overfitting or overshooting. Briefly:
- **Overfitting**: Occurs when the model performs well on the training data but poorly on new data, often due to training for too many epochs.
- **Overshooting**: Happens when the learning rate is too high, causing the model to "jump" past the optimal weights and fail to converge smoothly.
- **Balancing**: Use early stopping and regularization to prevent overfitting, and tune the learning rate to avoid overshooting during training.

Overfitting occurs when the model learns too much about the training data, including noise and irrelevant details, which means it fits the training data very well but performs poorly on unseen data. The model finds a minimum (either a local minimum or even the global minimum) on the training loss surface, meaning that it has learned to predict the training data very well. However, that minimum does not represent the true global minimum on the validation or test loss surface, which would reflect how well the model generalizes to unseen data (e.g., user input or real-world scenarios). Because the problem is it learned too much, the solution to overfitting is to halt the training early enough.
- Halting the training early enough when validation performance begins to degrade, preventing the model from becoming too specialized in the training data and helping it generalize better to new data. 
- There are other algorithms to prevent overfitting: L2 Regularization (Ridge), L1 Regularization (Lasso), Dropout (Randomly drops out a proportion of neurons during training especially in neural networks), Data Augmentation, Cross-Validation, Simplify the Model, Pruning, Ensemble Methods (Bagging, Boosting), Noise Injection, Batch Normalization

**Overshooting** occurs when the **learning rate** is too high, causing the model to make updates that are too large, which prevents it from settling into a **local minimum** or the **global minimum**. The learning rate can be set in the options before the code runs the training. There are other settings to adjust such as batch size.
- Reducing the learning rate allows the model to take smaller, more controlled steps during training, which helps it gradually converge to the minimum instead of skipping past it.
- You can manually set a lower learning rate or other algorithms for learning rate
	- **Learning rate schedules** automatically reduce the learning rate as training progresses. A common technique is to start with a larger learning rate and gradually decrease it (e.g., **learning rate decay**).
	- **Learning rate warm-up** starts with a very small learning rate for the first few iterations or epochs and gradually increase it to the desired learning rate. This can help prevent large, erratic updates early in training when the model is still learning
- The **batch size** determines how many samples are processed before updating the model's weights. 
	- Smaller batch sizes introduce more **noise** into the gradient estimation (since each batch is a smaller, potentially less representative sample of the dataset), which can sometimes help the model explore more of the loss surface and potentially avoid overshooting. However, it can also lead to instability if the batches are too small. 
	- Larger batch sizes produce more stable gradient estimates because the average gradient is calculated over a larger number of samples. This stability can help reduce the chances of overshooting, especially when used with a lower learning rate.
- There are other algorithms to prevent overshooting such as gradient clipping, Adam optimizer and Momentum-based optimizer