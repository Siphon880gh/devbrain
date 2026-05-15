
Foreign keys are a fundamental aspect of relational databases, and they are used to establish a link between the data in two tables. While it's true that you could manually join tables during your queries, foreign keys serve several important purposes that go beyond this. Here are some reasons why you might want to use foreign keys:

1. **Referential Integrity**: Foreign keys help maintain referential integrity, which ensures that the relationship between tables remains consistent. When a foreign key constraint is defined, the database will prevent any changes that would lead to data inconsistency. For example, if you try to insert a record in your first table (let's say a 'user' table) with a `role_id` that does not exist in the 'role' table, the database will prevent this operation. Similarly, if you try to delete a record from the 'role' table which is still referred to by a record in the 'user' table, the operation will fail (unless you've specified `CASCADE` or similar behavior).

2. **Database Performance**: When you establish a foreign key relationship, most DBMS systems (like PostgreSQL, MySQL, SQL Server) automatically create an index on the foreign key columns, which can result in more efficient queries.

3. **Self-documenting**: Foreign keys can serve as a form of documentation. By looking at the table schema and its constraints, you can understand the relationships between tables without needing additional documentation.

4. **Ease of Use with ORMs**: Object-Relational Mapping (ORM) libraries, like Sequelize for Node.js or Hibernate for Java, can automatically take advantage of foreign key relationships to make it easier to work with related data. For example, you might be able to access a user's role directly as a property of the user object without writing an explicit join.

Therefore, even though you can technically perform a join at the query without having a foreign key, it's generally good practice to use foreign keys to enforce data integrity and relationships.