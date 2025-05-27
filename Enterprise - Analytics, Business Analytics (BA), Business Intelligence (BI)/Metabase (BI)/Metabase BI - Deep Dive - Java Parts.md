Metabase even though you can deploy on your server like a web app without an enterprise environment, is Java-based.

**Metabase** is Java-based, being built primarily with Clojure, a functional programming language that runs on the Java Virtual Machine (JVM). This design allows Metabase to leverage the JVM's scalability and cross-platform compatibility, making it easier to deploy across various environments. Metabase packages its application as a standalone JAR file, which can be easily run on any system with Java installed, and it also offers Docker images for containerized deployment.

You may explore its inner workings and find various Java parts. Here's a deep dives into the Java parts:

### H2

H2 is a lightweight, in-memory database widely used for development and testing rather than for production environments. While it offers some concurrency, it is limited compared to databases built for high concurrency and large-scale production, such as PostgreSQL or MySQL. For applications requiring strong concurrency support and data durability, H2 may not be the best choice.

H2 is favored in development due to its quick and easy setup. Its SQL-compatible syntax allows developers to simulate how queries would behave on other databases, which aids in transitioning to a production database later. H2’s Embedded and In-Memory Modes enable developers to bundle it with their applications without needing additional setup or dependencies. The in-memory mode, in particular, clears data upon application shutdown, making it ideal for temporary data storage during development and testing.

You can switch away from H2 to PostgresQL, for example. In fact, that's the recommended setup from Metabase's official documents.

Where you may find H2: If you run metabase container in non-daemon / no-deteched mode (no -d flag). It'll warn it's on H2 and for production you need to migrate out or just switch out entirely to PostgresQL.

## Jetty Webserver

What is Jetty? The server for Java apps. Alternative to Tomcat for Java. Metabase is a Java app. A Java server can serve html files, images etc like a traditional server and can be configured to serve jsp files (Java Server Page but due to legal challenges now rectonned Jakarta Server Pags) which are similar to php by mixing html with server code and can access MySQL. Jetty can come in two favors and Metabase is using embed Jetty: “running Jetty in embedded mode means putting an HTTP module into your application, rather than putting your application into an HTTP server.”

The Embedded Jetty Webserver is a lightweight, embedded web server integrated within applications. In Metabase's case, Jetty enables Metabase to serve its web application without needing an external web server, such as Apache or Nginx.

Where you may find Jetty: When you look up Docker compose files as your method of installation. It has a Jetty port in the compose file.

### Clojure

Clojure is a functional, concurrent programming language that runs on the Java Virtual Machine (JVM), similar to Scala and Kotlin. As a Lisp dialect on the Java platform, Clojure's syntax uses S-expressions, which are parsed into data structures by a Lisp reader before being compiled. Clojure is commonly used in backend development and integrates well with Java, often found in Java-based applications or containerized environments that are either backend-only or full-stack, like Metabase (which is full-stack because it’s a BI tool with a web portal GUI and connects to your database for analytics). The language was first released in 2007.

Where you may find Clojure: Backend installation for non-Mac and non-ARM64