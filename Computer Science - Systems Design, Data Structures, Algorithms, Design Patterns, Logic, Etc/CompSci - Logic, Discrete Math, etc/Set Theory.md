
### Why

Set Theory helps in understanding collections of objects, known as sets, and the relationships between them. Here are some example problems that cover basic concepts of set theory to help improve your logic for engineering applications.

### Example Problem 1: Basic Set Operations
**Problem**: Consider the sets A = {1, 2, 3, 4} and B = {3, 4, 5, 6}. Compute the following:
1. Union of A and B (A ∪ B)
2. Intersection of A and B (A ∩ B)
3. Difference between A and B (A - B)
4. Difference between B and A (B - A)
5. Cartesian product of A and B (A x B)


**Solution**:
1. A ∪ B = {1, 2, 3, 4, 5, 6}
2. A ∩ B = {3, 4}
3. A - B = {1, 2}
4. B - A = {5, 6}
5. A x B = {(1, 3), (1, 4), (1, 5), (1, 6), (2, 3), (2, 4), (2, 5), (2, 6), (3, 3), (3, 4), (3, 5), (3, 6), (4, 3), (4, 4), (4, 5), (4, 6)}

### Example Problem 2: Application of Set Theory in Problem Solving
**Problem**: In a class of 40 engineering students, 25 students are taking a course in Electrical Engineering (EE), 20 in Mechanical Engineering (ME), and 15 are enrolled in both EE and ME. How many are taking only one of these courses?

**Solution**:
- E represents the set of students taking EE
- M represents those taking ME
- |E| = 25 (Number of students taking EE)
- |M| = 20 (Number of students taking ME)
- |E intersect M| = 15 (Students taking both)

Using the principle of inclusion-exclusion:
- |E union M| = |E| + |M| - |E intersect M| = 25 + 20 - 15 = 30

So, 30 students are taking at least one of the courses. To find those taking only one course:
- |E - M| = |E| - |E intersect M| = 25 - 15 = 10
- |M - E| = |M| - |E intersect M| = 20 - 15 = 5

Thus, 15 students are taking only one course.

### Example Problem 3: Using Set Theory in Engineering Contexts
**Problem**: A network consists of nodes connected by links. Let A be the set of operational nodes, and B be the set of nodes currently transmitting data. If A = {1, 2, 3, 4, 5} and B = {2, 3, 6}, find nodes that are operational but not transmitting data.

**Solution**:
- A - B = {1, 4, 5}

These nodes are operational but not currently transmitting data.

These example problems illustrate how basic set theory operations, the principle of inclusion-exclusion, and the practical application of set theory can solve problems in engineering and other disciplines. Set theory's structure and analysis capabilities make it an invaluable tool across various scientific and engineering contexts.
