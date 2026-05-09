It is a powerful **operator** that performs two motions at once: it **deletes** a piece of text and immediately puts you into **Insert mode** so you can type its replacement.

**Difference from `C`**: While `cc` changes the **whole line**, the command `C` (uppercase) only changes the text from the **current cursor position** to the end of the line.

---

With uppercase C:
```
the fox jumped over the fence
        ^
```

Pressing upper case C at "j", that line becomes:
```
the fox 
        ^
```

And you can immediately type new text where the caret is.

---

You delete a word and start inserting from there with:
```
cw
```


With `cw`:
```
the fox jumped over the fence
        ^
```

Becomes:
```
the fox  over the fence
        ^
```

And typing the word "leaped", the line becomes:
```
the fox leaped over the fence
```

---

Had you used:
```
dw
```

It won't immediately go into insertion mode. You have to press `a`, then you can type "leaped"

---

Yes, the uppercase `C` does NOT need to be pressed twice. While keyboard is in lowercase mode, you can enter uppercase `C` with `SHIFT + c`. Vim will take it.