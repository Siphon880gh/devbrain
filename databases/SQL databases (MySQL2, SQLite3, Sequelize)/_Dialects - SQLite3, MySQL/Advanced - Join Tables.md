Merge two tables by a field
```
SELECT *
FROM A JOIN B ON A.X = B.Y
```

You can add a WHERE clause at the end if you are filtering for a specific row that match at ON:
```
SELECT * FROM authors AS A JOIN books AS B ON A.id = B.authorID WHERE A.firstName = "Mark"
```

You can also do more complicated joins, merging multiple tables. 

For example, you phoned all employees and asked if they could come in to work on their day off, but on their usual shift hours. 
Here you are getting the start and end time the employee was called and you are also getting the outcome of that call (whether employee agrees to work extra, to substitute another day, or refuses).
There would be an Employee table, a Call table holding their usual shift start and end times, and a Call Outcome table holding the possible answers.
The tables have lookup values to other tables whether than hard-coding the shift times and Call outcome answers.
```
SELECT employee.first_name, employee.last_name, call.start_time, call.end_time, call_outcome.outcome_text
FROM employee
INNER JOIN call ON call.employee_id = employee.id
INNER JOIN call_outcome ON call.call_outcome_id = call_outcome.id
ORDER BY call.start_time ASC;
```

You can choose which fields to show in the resulting records at the *. You can reference those fields with the renamed tables: `SELECT A.id, B.author`.

More details: https://www.sqlshack.com/learn-sql-join-multiple-tables/

Other types of joins, you would replace "JOIN" in the syntax with "LEFT JOIN", "RIGHT JOIN", etc. MySQL does not have FULL JOIN.
- Left join: Show all the records of table A. For fields from table B that do not apply with "ON", show them with NULL values.
- Right join: Show all the records of table B. For fields from table A that do not apply with "ON", show them with NULL values.
- Outer join, Full join, etc, read below links:
https://www.codeproject.com/Articles/33052/Visual-Representation-of-SQL-Joins
https://www.reddit.com/r/SQL/comments/aysflk/sql_join_chart_custom_poster_size/