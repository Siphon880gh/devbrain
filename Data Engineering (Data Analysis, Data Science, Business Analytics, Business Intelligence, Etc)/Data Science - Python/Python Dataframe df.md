In Python, especially with **pandas**, a **DataFrame** is like a table stored inside a variable.

Most people name the variable:

```python
df
```

`df` usually means **DataFrame**.

A DataFrame is similar to a spreadsheet, SQL table, or CSV file loaded into memory. Once the data is inside `df`, you can inspect it, filter it, sort it, group it, and query it.

---

## Simple idea

```python
df = table_data
```

The variable `df` holds the table.

So when you see this:

```python
df = pd.read_csv("customers.csv")
```

It means:

“Load the CSV file into a table-like object and store it in the variable called `df`.”

---

## Install pandas

```bash
pip install pandas
```

Then import it:

```python
import pandas as pd
```

`pd` is the common shortcut for pandas.

---

## Load a CSV into a DataFrame

```python
import pandas as pd

df = pd.read_csv("customers.csv")
```

Now `df` contains the CSV data.

Example CSV:

```csv
name,age,city,total_spent
John,32,Los Angeles,250
Maria,28,New York,400
David,45,Los Angeles,800
Sarah,35,Chicago,150
```

After loading it, `df` behaves like a table.

---

## View the first few rows

```python
print(df.head())
```

This shows the first 5 rows.

You can also choose how many rows:

```python
print(df.head(10))
```

---

## View column names

```python
print(df.columns)
```

Example output:

```python
Index(['name', 'age', 'city', 'total_spent'], dtype='object')
```

---

## Select one column

```python
print(df["name"])
```

This gives you the `name` column.

Example:

```python
0     John
1    Maria
2    David
3    Sarah
Name: name, dtype: object
```

---

## Select multiple columns

```python
print(df[["name", "city"]])
```

This returns a smaller table with only those columns.

---

## Filter rows

This is where a DataFrame starts feeling like a queryable table.

### Get customers from Los Angeles

```python
la_customers = df[df["city"] == "Los Angeles"]

print(la_customers)
```

### Get customers older than 30

```python
older_customers = df[df["age"] > 30]

print(older_customers)
```

### Get customers who spent more than 300

```python
big_spenders = df[df["total_spent"] > 300]

print(big_spenders)
```

---

## Filter with multiple conditions

Use `&` for **AND**.

```python
result = df[
    (df["city"] == "Los Angeles") &
    (df["total_spent"] > 300)
]

print(result)
```

Use `|` for **OR**.

```python
result = df[
    (df["city"] == "Los Angeles") |
    (df["city"] == "New York")
]

print(result)
```

Important: wrap each condition in parentheses.

---

## Query using `.query()`

Pandas also has a query-style syntax.

```python
result = df.query("age > 30")

print(result)
```

Another example:

```python
result = df.query("city == 'Los Angeles' and total_spent > 300")

print(result)
```

This can feel closer to SQL-style filtering.

---

## Sort the table

```python
sorted_df = df.sort_values("total_spent")

print(sorted_df)
```

Highest first:

```python
sorted_df = df.sort_values("total_spent", ascending=False)

print(sorted_df)
```

---

## Add a new column

```python
df["is_big_spender"] = df["total_spent"] > 300

print(df)
```

This adds a new column with `True` or `False`.

---

## Group data

Example: total spending by city.

```python
city_totals = df.groupby("city")["total_spent"].sum()

print(city_totals)
```

Example: average age by city.

```python
avg_age = df.groupby("city")["age"].mean()

print(avg_age)
```

---

## Save the result to a new CSV

```python
big_spenders = df[df["total_spent"] > 300]

big_spenders.to_csv("big_spenders.csv", index=False)
```

This creates a new CSV file.

---

## Full example

```python
import pandas as pd

# Load CSV into a DataFrame
df = pd.read_csv("customers.csv")

# Preview the table
print(df.head())

# Filter customers from Los Angeles
la_customers = df[df["city"] == "Los Angeles"]

# Filter big spenders
big_spenders = df[df["total_spent"] > 300]

# Sort by highest spending
big_spenders = big_spenders.sort_values("total_spent", ascending=False)

# Save result
big_spenders.to_csv("big_spenders.csv", index=False)

print(big_spenders)
```

---

## Simple way to think about it

```python
df = pd.read_csv("file.csv")
```

Means:

“Take this CSV file and turn it into a table I can work with in Python.”

Then:

```python
df["column_name"]
```

Means:

“Get one column from the table.”

And:

```python
df[df["age"] > 30]
```

Means:

“Give me only the rows where age is greater than 30.”

So yes, `df` is just a variable, but the value inside it is a powerful table object called a **DataFrame**.