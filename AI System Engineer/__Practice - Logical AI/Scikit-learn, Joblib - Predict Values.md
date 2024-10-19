
What is this good for:
- Business analytics
- Marketing metrics

Quick Review:
- Inputs in datasets aka features
- Outputs in datasets aka targets

Our goal here is to train a model with a sample dataset, then have it learn by testing itself then checking the answers in validation set and test set. Validation set is for adjusting parameters like weights and biases (Read more at [[AI Vector Math - Weights, Biases, Activation, Layers]]). Test set is to test against performance.

We will be using Python's Scikit-Learn and Joblib.

You need to have three datasets (can be .csv files) prepped already. If not, go ahead and split your dataset into three datasets. Just try to make sure each dataset are just as random. The next section splits one csv file into three csv files. You can skip that section if not needed.

---

## If not done: Split dataset into three datasets

In Python, Pandas pd can be used to read and save csv. You could load the csv using panda into dataframes, then split the dataframes into the three types of datasets, then save them as three csv files.
### Example of a Dataset in CSV Format:
Here's an example of how the **training, validation, and test sets** described earlier could look in a CSV file:

```csv
ID,Feature1,Feature2,Target
1,2.3,5.7,0
2,4.1,6.2,1
3,5.0,4.3,0
4,3.6,7.1,1
5,4.7,6.9,1
6,2.8,4.9,0
...
1000,3.5,7.1,1
```

### CSV Structure:
- **ID**: A unique identifier for each data point (optional, but useful).
- **Feature1 and Feature2**: These represent the features (input variables) of the dataset.
- **Target**: This is the label or output the model is trying to predict (in this case, 0 or 1 for binary classification).

### How to Use CSV for Machine Learning:
1. **Save Your Dataset**:
   - Save your data in a CSV file. If you're splitting your dataset into training, validation, and test sets, you can either:
     - Save each set in a separate CSV file (e.g., `train.csv`, `val.csv`, `test.csv`), or
     - Save the entire dataset in a single CSV and split it programmatically when loading it.

2. **Loading CSV in Python**:
   - You can easily load and manipulate CSV files in Python using libraries like **Pandas**.

   Here’s an example of how to load a CSV file and split it into training, validation, and test sets using **Pandas**:

   ```python
   import pandas as pd
   from sklearn.model_selection import train_test_split

   # Load the CSV file into a pandas DataFrame
   df = pd.read_csv('dataset.csv')

   # Split the data into features (X) and target (y)
   X = df[['Feature1', 'Feature2']]  # Feature columns
   y = df['Target']  # Target column

   # Split into training (80%) and test (20%) sets
   X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

   # Further split the training set into training (90% of the 80%) and validation (10% of the 80%)
   X_train, X_val, y_train, y_val = train_test_split(X_train, y_train, test_size=0.1, random_state=42)

   # Now you have training, validation, and test sets!
   ```

3. **Save Split Datasets (Optional)**:
   - If you want to save the split datasets to new CSV files, you can easily do so with Pandas:

   ```python
   # Save the training set
   train_df = pd.concat([X_train, y_train], axis=1)
   train_df.to_csv('train.csv', index=False)

   # Save the validation set
   val_df = pd.concat([X_val, y_val], axis=1)
   val_df.to_csv('val.csv', index=False)

   # Save the test set
   test_df = pd.concat([X_test, y_test], axis=1)
   test_df.to_csv('test.csv', index=False)
   ```

---

## Training then saving the model

Requirement: You have three CSV files (training, validation, and test sets). Let's walk you through how to train a machine learning model using these datasets in Python. I’ll assume you are using a popular library like **Scikit-learn** for simplicity, and I’ll show you how to load the CSV files, train a model, and evaluate it. Then if it's to your preferences, you save the model.

### 1. **Loading the CSV Files**
First, you need to load the data from your CSV files into Python. You can use **Pandas** for this.

```python
import pandas as pd

# Load the training, validation, and test sets
train_df = pd.read_csv('train.csv')
val_df = pd.read_csv('val.csv')
test_df = pd.read_csv('test.csv')

# Separate features and target for each dataset
X_train = train_df[['Feature1', 'Feature2']]  # Replace with your feature columns
y_train = train_df['Target']

X_val = val_df[['Feature1', 'Feature2']]
y_val = val_df['Target']

X_test = test_df[['Feature1', 'Feature2']]
y_test = test_df['Target']
```

### 2. **Training a Model**
Let’s say you want to train a simple **Logistic Regression** model. We’ll use **Scikit-learn** (`sklearn`) for this. You can replace this with other models (like Random Forest, SVM, etc.), but Logistic Regression is a good starting point for classification tasks.

Here’s how you can train the model:

```python
from sklearn.linear_model import LogisticRegression
from sklearn.metrics import accuracy_score

# Initialize the model
model = LogisticRegression()

# Train the model on the training data
model.fit(X_train, y_train)

# Validate the model on the validation data
y_val_pred = model.predict(X_val)
val_accuracy = accuracy_score(y_val, y_val_pred)

print(f'Validation Accuracy: {val_accuracy:.4f}')
```

### 3. **Hyperparameter Tuning (Optional)**
You can also tune the hyperparameters of your model by evaluating the performance on the validation set. For example, you can try different regularization strengths in Logistic Regression, or adjust hyperparameters for more complex models like Random Forest or Neural Networks.

If you're satisfied with the model performance on the validation set, you can proceed to evaluate it on the test set.

### 4. **Evaluating on the Test Set**
Once you're happy with the model, the next step is to evaluate it on the **test set** to see how well it generalizes to completely unseen data.

```python
# Evaluate the model on the test data
y_test_pred = model.predict(X_test)
test_accuracy = accuracy_score(y_test, y_test_pred)

print(f'Test Accuracy: {test_accuracy:.4f}')
```

### 5. **Using Other Models**
You can easily swap Logistic Regression with other models in **Scikit-learn**. For example, using a **Random Forest**:

```python
from sklearn.ensemble import RandomForestClassifier

# Initialize the model
model = RandomForestClassifier(n_estimators=100, random_state=42)

# Train the model
model.fit(X_train, y_train)

# Validate and test as before
y_val_pred = model.predict(X_val)
val_accuracy = accuracy_score(y_val, y_val_pred)
print(f'Validation Accuracy: {val_accuracy:.4f}')

y_test_pred = model.predict(X_test)
test_accuracy = accuracy_score(y_test, y_test_pred)
print(f'Test Accuracy: {test_accuracy:.4f}')
```

### 6. **Saving the Model (Optional)**
If your model performs well and you want to save it for future use, you can use **joblib** or **pickle** to save it.

```python
import joblib

# Save the model
joblib.dump(model, 'trained_model.pkl')

# Load the model
model = joblib.load('trained_model.pkl')
```

### Summary of Steps:
1. **Load your datasets** (training, validation, test) from CSV files.
2. **Train a model** (like Logistic Regression, Random Forest, etc.) using the training set.
3. **Validate** the model using the validation set to check its performance.
4. **Evaluate** the model on the test set to get the final performance.
5. **Tune hyperparameters** as needed and save the model if desired.

These steps form the basic pipeline for training a machine learning model with CSV datasets in Python. You can extend this process with different models, more advanced hyperparameter tuning, or even more complex data preprocessing if needed.

---

## Use the saved model to predict outputs from provided inputs

Now we use the saved model to predict outputs from provided inputs.

Once your model is trained, validated, and tested, you can use it to make predictions on **new, unseen data**. The process involves loading the trained model (if necessary) and passing new data through the model to predict outputs.

Here’s a step-by-step guide on how to use your trained model to predict outputs for new data.

### 1. **Ensure the Model is Loaded**
If you saved the model after training (e.g., using `joblib`), you need to load the saved model before using it for predictions.

```python
import joblib

# Load the trained model
model = joblib.load('trained_model.pkl')
```

If you haven’t saved the model but still have it in memory, you can skip this step.

### 2. **Prepare the New Data**
The new data must be in the same format as the data used to train the model. This means:
- The same **features** (e.g., "Feature1", "Feature2") must be used.
- Any **preprocessing** steps applied to the training data (e.g., scaling, normalization) must also be applied to the new data.

Let’s say you have new data in a CSV file, `new_data.csv`:

```python
import pandas as pd

# Load the new data from CSV (just the features, no target)
new_data = pd.read_csv('new_data.csv')

# Display the new data (optional)
print(new_data.head())
```

### Example of `new_data.csv`:

```csv
Feature1,Feature2
2.4,5.6
3.8,6.9
4.1,7.0
```

### 3. **Make Predictions**
Now, you can use the trained model to predict the target (output) for this new data. You use the `predict` method of the model.

```python
# Make predictions using the loaded model
predictions = model.predict(new_data)

# Display the predictions
print("Predictions:", predictions)
```

The `predictions` variable will contain the model's predicted output for each row in the new data.

### 4. **(Optional) Probabilistic Predictions**
If you're using a model like Logistic Regression or Random Forest for classification tasks, you can also get **probabilistic predictions** by using the `predict_proba` method. This returns the probability of each class for each data point.

```python
# Get probabilistic predictions
probabilities = model.predict_proba(new_data)

# Display the probabilities
print("Probabilities:", probabilities)
```

For example, if you're classifying between two classes (e.g., 0 and 1), `predict_proba` will return the probabilities of the data point belonging to class 0 and class 1.

### 5. **Example of Full Workflow**
Let’s bring everything together with a complete example of using a trained model to make predictions on new data:

```python
import joblib
import pandas as pd

# Step 1: Load the trained model
model = joblib.load('trained_model.pkl')

# Step 2: Load the new data
new_data = pd.read_csv('new_data.csv')

# Step 3: Make predictions
predictions = model.predict(new_data)

# Step 4: Display the predictions
print("Predictions:", predictions)

# (Optional) Get probabilistic predictions
probabilities = model.predict_proba(new_data)
print("Probabilities:", probabilities)
```

### 6. **Saving the Predictions**
If you want to save the predictions to a CSV file, you can easily do so:

```python
# Add the predictions as a new column in the new data
new_data['Predicted_Target'] = predictions

# Save the new data with predictions to a CSV file
new_data.to_csv('new_data_with_predictions.csv', index=False)
```

### Summary:
1. **Load the trained model** (if needed).
2. **Prepare the new data** in the same format as the training data.
3. Use the model's `**predict**` method to make predictions.
4. **Optionally**, use `predict_proba` to get probabilities for classification models.
5. **Save or display** the predicted outputs.

This process allows you to use your trained model to make predictions on any new, unseen data, leveraging the patterns the model learned during training.