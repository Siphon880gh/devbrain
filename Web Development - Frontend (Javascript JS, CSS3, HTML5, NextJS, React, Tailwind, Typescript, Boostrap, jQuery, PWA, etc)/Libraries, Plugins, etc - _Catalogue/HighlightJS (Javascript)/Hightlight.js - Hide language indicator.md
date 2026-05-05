Recall that Hightlight.js creates a code snippet callout that lets user easily copy your code.

By default has language indicator. Here it's "CSS"
![[Pasted image 20250515022500.png]]

--> But you can hide the language indicator (especially if in the way of the code snippet on mobile)

![[Pasted image 20250515022525.png]]

Add this css to hide the language. Here it hides it on mobile only because it's a media query:
```
@media screen and (max-width: 768px) {
  .code-badge-language {
    display: none;
  }
}
```
