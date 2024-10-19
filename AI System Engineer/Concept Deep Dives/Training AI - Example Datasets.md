A common split is:
- **Training set**: 70-80% of the total data.
- **Validation set**: 10-15% of the total data.
- **Test set**: 10-15% of the total data.

Let's create a simple example that includes **input features** and **expected outputs** for the **training set**, **validation set**, and **test set**. We'll use a basic binary classification task where the goal is to predict whether a person will buy a product based on two features: **Age** and **Income**.

### Example Dataset:

- **Input Features**: Age and Income.
- **Output (Target)**: 1 if the person buys the product, 0 if they don’t.

---

### 1. **Training Set** (80% of the data):

|Age|Income|Buy (Target)|
|---|---|---|
|25|50K|1|
|32|60K|0|
|22|35K|0|
|45|85K|1|
|35|70K|1|
|28|40K|0|
|40|65K|1|
|23|30K|0|
|50|90K|1|
|38|75K|1|

Here, the model will use the **training set** to learn patterns between **Age**, **Income**, and the likelihood of buying a product.

---

### 2. **Validation Set** (10% of the data):

| Age | Income | Buy (Target) |
| --- | ------ | ------------ |
| 30  | 55K    | 0            |
| 29  | 65K    | 1            |
| 33  | 60K    | 0            |

The **validation set** is used during training to check how well the model generalizes to unseen data. The model won't use this set to learn, but to evaluate how well it's doing while tuning hyperparameters.

---

### 3. **Test Set** (10% of the data):

|Age|Income|Buy (Target)|
|---|---|---|
|27|45K|0|
|41|80K|1|
|36|68K|1|

The **test set** is used after the model has finished training to assess its performance on data it has never seen before. This provides a realistic measure of how well the model will perform on new, real-world data.

---

### Explanation:

- **Training Set** (80%) is used to teach the model. It shows the input (Age, Income) and the corresponding target (whether they bought the product).
- **Validation Set** (10%) is used during training to monitor the model's performance and avoid overfitting.
- **Test Set** (10%) is used at the very end, after the model has been fully trained, to evaluate how well it generalizes to new data.

This simple dataset helps to illustrate the basic idea of a classification problem, where the model learns relationships between the input features (Age and Income) and the target (whether a person buys the product or not). The percentages (80% training, 10% validation, and 10% test) can be adjusted depending on the size of the dataset, but this is a commonly used split.