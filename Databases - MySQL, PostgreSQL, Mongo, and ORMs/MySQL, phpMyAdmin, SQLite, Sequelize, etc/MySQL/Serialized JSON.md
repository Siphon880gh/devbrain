Storing serialized JSON in MySQL is quite common, especially since MySQL 5.7 (October 2015), which introduced a native JSON data type.

---

Storing serialized JSON in MySQL is quite common, especially since MySQL 5.7, which introduced a native JSON data type. Here's a brief explanation of how it works and some considerations:

1. **JSON Data Type:**
   - MySQL has a JSON column type that allows you to store JSON documents directly in a table.
   - This data type provides automatic validation of JSON documents and optimizes storage by compacting them into a binary format.

2. **Advantages:**
   - Flexibility: JSON columns can store structured data without requiring a fixed schema.
   - Dynamic Schema: You can easily change the structure of data stored in a JSON column without altering the table schema.
   - Queryable and Indexable: MySQL provides functions to query and manipulate JSON data, and you can even create indexes on JSON columns for better performance.

3. **Storing Serialized JSON:**
   - Before the introduction of the JSON data type, developers would serialize JSON into a string and store it in a TEXT or VARCHAR field.
   - However, with the native JSON type, it's now more efficient to store JSON data as it ensures validation and allows for more efficient access patterns.

4. **Usage:**
   - To insert JSON data, you would use a standard SQL INSERT statement and include the JSON object as part of the query.
   - MySQL's functions like `JSON_EXTRACT`, `JSON_SET`, `JSON_REPLACE`, and `JSON_SEARCH` are available to manipulate and query the JSON data directly in SQL queries.

5. **Considerations:**
   - While storing JSON provides flexibility, it can also lead to less efficient queries if not used carefully, especially if the JSON documents are large and the queries are complex.
   - It’s generally not a good practice to store large amounts of data that require frequent access within JSON columns, as it can lead to performance issues.
   - Normalization is still preferred for data that will be frequently accessed or searched, but JSON is excellent for semi-structured data or data that doesn't fit neatly into a relational schema.

In summary, MySQL supports storing serialized JSON directly in tables using a native JSON data type, providing flexibility for semi-structured data while still allowing for efficient querying and manipulation.


---

TLDR: 
   - MySQL's functions like `JSON_EXTRACT`, `JSON_SET`, `JSON_REPLACE`, and `JSON_SEARCH` are available to manipulate and query the JSON data directly in SQL queries.