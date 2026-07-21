Star vs Snowflake vs Fact/Dimensions

[https://youtu.be/hQvCOBv_-LE?si=KoV0Scx2kKPqkyFN](https://youtu.be/hQvCOBv_-LE?si=KoV0Scx2kKPqkyFN)  

  

---




<<
Dimensional Modeling? Snowflake vs Star?

\>>
Dimensional modeling is a design technique often used for data warehouses. It structures data into fact tables and dimension tables with the aim of optimizing for readability and query performance. Here's how the star schema and snowflake schema, which are two types of dimensional modeling, compare:

**Star Schema:**
- Simple structure with a single, central fact table connected to multiple dimension tables.
- Fact tables contain quantitative data (like sales amount, profit, etc.).
- Dimension tables contain attributes about the measurements (like date, product details, store information, etc.).
- Directly connects each dimension table to the fact table.
- High performance for queries due to denormalized structure, which requires fewer joins.
- Easier to understand and navigate because of its simplicity.
- Can lead to data redundancy because of denormalization, which may consume more storage space.

**Snowflake Schema:**
- More complex structure where dimension tables are normalized into multiple related tables, forming a structure that resembles a snowflake.
- Reduces redundancy and saves storage space compared to the star schema.
- Can involve more complex queries with more joins, which may reduce query performance.
- Sometimes preferred for data models that require a more detailed level of analysis.
- Helps maintain data integrity by reducing update anomalies.
- Can be more difficult for users to navigate due to its complexity.

In summary, the star schema is generally preferred for its simplicity and query speed, making it suitable for most data warehousing scenarios. The snowflake schema can be useful when you need to manage a more complex data model with less redundancy and are willing to manage the trade-off with potentially slower query performance.
