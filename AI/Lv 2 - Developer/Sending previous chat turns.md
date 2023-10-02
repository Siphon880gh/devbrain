Have in the prompt a string that keeps concatenating the previous prompts and responses in this format:
```
User: ...

ChatGPT: ...
```

If you had inspect ChatGPT on the front end you'll see your avatar is identified as User and that ChatGPT's SVG has the `<text>` as ChatGPT.

---

Proof this works:
<<
```
User:  
What is 1+1?  
  
ChatGPT:  
1 + 1 = 2.  
  
User:  
What is 2+2?  
  
ChatGPT:  
2 + 2 = 4.  
  
User:  
What is 3+3?  

```
  
\>>
```
3 + 3 = 6.
```  

---

Further proof this works

<<
```
User:  
What is 1+1?  
  
ChatGPT:  
1 + 1 = 2.  
  
User:  
What is 2+2?  
  
ChatGPT:  
2 + 2 = 4.  
  
User:  
For future math calculations, we will redefine 1 to be 2.  
  
ChatGPT:  
Understood. Using your redefined value, where 1 is now equivalent to 2:  
  
If you ask "What is 1+1?", the answer would be 4, since 2 (your redefined 1) + 2 (your redefined 1) = 4.  
  
Just let me know when you'd like to revert back to conventional math definitions or if you have other special conditions.  
  
User:  
What is 1+2?
```

\>>
```
Using the redefined value where 1 is now equivalent to 2:  
  
1 (which is 2) + 2 = 4.  
  
So, 1 + 2 = 4.
```