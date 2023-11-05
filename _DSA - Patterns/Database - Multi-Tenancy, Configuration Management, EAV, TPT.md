
Context: 
**Entity-Attribute-Value (EAV) Model:**
-vs-
**Table-per-Type (TPT):**
-vs-
**Single Table Inheritance:** A single table holds all the settings with a discriminator column to indicate the app type. This can lead to sparse tables if many settings are unique to specific apps

---

<<
Is there a pattern that has a name in mysql or databases that deals with this saving settings for each type of app?

\>>
In the realm of databases, what you're describing doesn't align with a specific design pattern by name as clearly as it does in software design. However, it closely resembles the concept of **Multi-Tenancy** where each app acts as a tenant with its own customizable settings, although multi-tenancy is typically used in the context of different customers or users sharing the same application or database infrastructure with logical separation.

For structuring data to accommodate various settings for different apps, the approach is generally termed as **Configuration Management** within the database. This isn’t a design pattern per se but rather a practice or part of a system design that involves:

1. **Entity-Attribute-Value (EAV) Model:** Sometimes used for flexible data models, where entities (apps) have various attributes (settings like fonts, colors) with corresponding values.

2. **Table-per-Type (TPT):** Each app type has its own table that extends a base settings table, which includes common settings.

3. **Single Table Inheritance:** A single table holds all the settings with a discriminator column to indicate the app type. This can lead to sparse tables if many settings are unique to specific apps.

4. **JSON/XML/Serialized Columns:** Some database systems allow for JSON, XML, or other serialized formats to be stored in a column, enabling a flexible schema where each app’s settings can be stored in a complex structure within a single column.

In practice, it often comes down to a combination of normalized and denormalized database design principles, and the choice depends on the specific requirements for scalability, query performance, and complexity of the configuration data.

---

<<
EAV, TPT, etc where can I read more about?

\>>
You can read more about these database design patterns and models in various database theory books, online educational resources, and technical documentation. Here are some resources where you might start:

1. **Entity-Attribute-Value (EAV) Model:**
   - Academic papers and database textbooks on database design.
   - Online articles and blogs that discuss the pros and cons of EAV, particularly in the context of relational databases.

2. **Table-per-Type (TPT):**
   - Object-Relational Mapping (ORM) documentation, such as Microsoft's Entity Framework or Hibernate, often explains the TPT strategy as it relates to mapping class inheritance to database tables.
   - Database design resources discussing normalization and inheritance.

3. **Single Table Inheritance:**
   - Resources on database normalization and schema design, which sometimes cover single table inheritance as a form of dealing with polymorphic entities in a database.
   - ORM documentation may also cover this topic since it's a common pattern used in ORMs for representing inheritance hierarchies.

4. **JSON/XML/Serialized Columns:**
   - The official documentation for databases that support JSON or XML types, like MySQL, PostgreSQL, or SQL Server.
   - Blogs and articles that focus on NoSQL and semi-structured data patterns within SQL databases.

For more in-depth and academic insights, you could also look into database design textbooks or take online courses on database management systems that cover advanced design patterns and data modeling. Websites like Coursera, edX, or Khan Academy offer courses on databases that might include these topics. Additionally, community forums like Stack Overflow can provide real-world use cases and discussions around these patterns.