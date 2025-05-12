
| Term    | Stands for               | Used with                                         | Description                                                                        |
| ------- | ------------------------ | ------------------------------------------------- | ---------------------------------------------------------------------------------- |
| **ODM** | Object Document Mapper   | **NoSQL databases** (like MongoDB)                | Maps JavaScript/TypeScript objects to document-based data (e.g. MongoDB documents) |
| **ORM** | Object Relational Mapper | **Relational databases** (like PostgreSQL, MySQL) | Maps code objects to structured data in tables (rows and columns)                  |

---

### 🔍 More Details

#### 🟩 ODM (Object Document Mapper)

* ODMs are built for **document-oriented databases** (e.g. MongoDB), where data is stored in JSON-like documents.
* They help developers work with documents in their code as if they were regular objects.
* They also manage things like validation, schemas, and query building.

**Popular ODMs:**

* **Mongoose** (JavaScript/Node.js)
* **Typegoose** (TypeScript wrapper for Mongoose)
* **MongoEngine** (Python)
* **Morphia** (Java)

#### 🟦 ORM (Object Relational Mapper)

* ORMs are designed for **relational databases**, where data lives in structured tables with defined relationships.
* They allow you to work with SQL databases using your programming language’s objects and avoid writing raw SQL.
* They support things like migrations, relationships (1:1, 1\:N, M\:N), and transactions.

**Popular ORMs:**

* **Prisma** (JavaScript/TypeScript)
* **Sequelize** (JavaScript)
* **TypeORM** (TypeScript)
* **SQLAlchemy** (Python)
* **Entity Framework** (C#/.NET)
* **Hibernate** (Java)

---

### 🧠 Summary

* Use an **ODM** if you're working with MongoDB or another NoSQL document database.
* Use an **ORM** if you're working with a traditional SQL database.
* Prisma is a bit unique—it acts like an ORM, but supports both relational and NoSQL (MongoDB).
