MySQL:

Make sure to hash all passwords. Even if there's a leak or database dump, the hashed passwords are computationally impractical time wise to reverse engineer

password_hash and  password_verify(hashed, plain) enough because computationally it would take too long to arrive from hashed to plain. 

Two users signing up with the same plain password will produce different hash values in the database. So a known plain-password/hash pair can't be compared to a database dump/leak.

But verifying the password with a provided plain password against a stored hashed password is fast.

---

Use prepared statements to protect against 1=1 hack that by passes Select for logging in

Better:
```
$sql = "SELECT id, username, password FROM users WHERE username = ?";  
$statement = $pdo->prepare($sql);  
$statement->execute([$username]);  
$user = $statement->fetch();
```

- When hacker attempts to login with username `' OR 1=1 --`  and anything for password, if your code is not secured, they will automatically be login successful.

- How? This query `SELECT id, username, password FROM users WHERE username = '$username' AND password = '$password` got corrupted into `SELECT id, username, password FROM users WHERE username = '' OR 1=1 --....` where the username field terminated early and is unioned into truthy "1=1". The password requirement for matching where has been dropped off where `--` is because that makes everything after it become a comment!

- On the off chance that the code checks password AND username, rather than username AND password, then you can try the 1=1 in the password instead. Or review your team member's code.

---

Sanitize user inputs that are shown to the world.
```
            <?php
            $comments = $pdo->query('SELECT * FROM comments ORDER BY created_at DESC')->fetchAll();
            foreach($comments as $comment) {
                echo "<tr>";
                echo "<td>".htmlspecialchars($comment['name'])."</td>";
                echo "<td>".htmlspecialchars($comment['comment'])."</td>";
                // echo "<td>".$comment['name']."</td>";
                // echo "<td>".$comment['comment']."</td>";
                echo "<td>".$comment['created_at']."</td>";
                echo "</tr>";
            }
            ?>
```


- That way someone can't comment `<script>alert("You got hacked!");</script>` then everyone seeing the comment gets their user experience interrupted. Or worse, the hacker would've injected javascript that steals credentials from the cookies of the logged in user and sends them to an external server (with CORS enabled).

---

You get the idea

For an exhaustive list, obligatorily:
https://www.invicti.com/blog/web-security/sql-injection-cheat-sheet/
