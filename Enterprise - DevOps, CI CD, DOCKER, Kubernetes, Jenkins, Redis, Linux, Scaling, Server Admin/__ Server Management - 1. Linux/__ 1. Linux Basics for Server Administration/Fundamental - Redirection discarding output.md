Sometimes we don't want the Unix to show output on the screen because the output is useless to us. There are scenarios. Imagine setting up an alias that performas unix commands and you want it to look minimal/clean/neat.

```
command > /dev/null
```

But commands could also display errors. You may want to redirect the errors (2) to stdout (1) which goes to discarding

```
command > /dev/null 2>&1
```

I guess to remember this: Think of &1 as at the memory of stdout. & means memory location in C language.

From: https://www.tutorialspoint.com/unix/unix-io-redirections.htm