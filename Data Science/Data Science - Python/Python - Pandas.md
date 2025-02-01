
Pandas:
https://www.learnpython.org/en/Pandas_Basics <-- Playgrounds/Sandboxes

Pandas has data structures that make it easy for data analysis purposes (business insights, etc). A basic data structure is a dataframe. It's great for plotting tables too. (It prints tabs in order to visually create a table)

Guides and API Reference:
https://pandas.pydata.org/docs/index.html


**How to experiment:**
1. Use the playgrounds/sandboxes
2. Try to come up with a goal (for example, first sandbox shows dimensions of countries & capital, area, and population, so what if I can create a sorted table AND a graph. That table could be sorted from largest to smallest area aka descending order)
3. Look up functions at a Pandas API Reference
https://pandas.pydata.org/docs/reference/index.html
4. Devise your ChatGPT prompts if needed

**4a.**
For the table with sorted area column (largest to smallest):

Running the print that is already in sandbox #1 will give you a table that isn't sorted. Let's sort by area because that's the first value column.

Looking at the API Reference, you have to make sure you're under the correct data structure: Dataframes. Then you search sort and you'll find sort_values:
https://pandas.pydata.org/docs/reference/api/pandas.DataFrame.sort_values.html

You'll see the key argument is "by". Reading the parameter description, you'll see you can provide the column label. You want largest area to smallest area, and you notice another parameter per the API reference is ascending (Boolean). You should have enough to print a table that's sorted by area

**Answer:**
```
print(brics.sort_values(by="area", ascending=False))
```


**4b.**
For the graph:

Your devised prompt to ChatGPT could be:

*This is my pandas code:* 
```
dict = {"country": ["Brazil", "Russia", "India", "China", "South Africa"], "capital": ["Brasilia", "Moscow", "New Dehli", "Beijing", "Pretoria"], "area": [8.516, 17.10, 3.286, 9.597, 1.221], "population": [200.4, 143.5, 1252, 1357, 52.98] } 

import pandas as pd 
brics = pd.DataFrame(dict) 
print(brics) 
```

*Give me code to draw a graph where the X axis are countires, and there are two lines with data points representing area and population. May need two Y axis.*


Their answer could be the following. 
Note: You'll notice that there's pandas and matplotlib. This is a common combination to create graphs because the various data structure helps mold the graph's axes and data points (lines, dots, etc).

```
import pandas as pd
import matplotlib.pyplot as plt

# Creating the DataFrame
data = {
    "country": ["Brazil", "Russia", "India", "China", "South Africa"],
    "capital": ["Brasilia", "Moscow", "New Dehli", "Beijing", "Pretoria"],
    "area": [8.516, 17.10, 3.286, 9.597, 1.221],
    "population": [200.4, 143.5, 1252, 1357, 52.98]
}
brics = pd.DataFrame(data)

# Creating the plot
fig, ax1 = plt.subplots()

# Plotting the area
ax1.set_xlabel('Country')
ax1.set_ylabel('Area (million sq km)', color='tab:blue')
ax1.plot(brics['country'], brics['area'], color='tab:blue', marker='o', label='Area')
ax1.tick_params(axis='y', labelcolor='tab:blue')

# Creating a second y-axis for population
ax2 = ax1.twinx()  
ax2.set_ylabel('Population (millions)', color='tab:red') 
ax2.plot(brics['country'], brics['population'], color='tab:red', marker='o', label='Population')
ax2.tick_params(axis='y', labelcolor='tab:red')

# Adding title and showing the plot
plt.title('Area and Population of BRICS countries')
fig.tight_layout()  
plt.show()
```


But that doesn't work in the sandbox. You'll have to run the code in **Jupyter Notebook**


![](P53XSLk.png)

