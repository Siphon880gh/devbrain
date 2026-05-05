Often times you may have wordpress theme overriding the tailwind classes' rules because of `!important` in the theme's css

What you can do is make tailwind classes have `!important` as well, and since tailwind will be loaded after the wordpress theme, then the tailwind styling will persist.

You do NOT need to write an entirely different css rules just to override with the same tailwind classes adding `!important`

Simply the tailwind classes can be prefixed with exclamation mark:
```
!bg-black !bg-opacity-50
```

For example, adding the important tailwind classes into a text block:
![[Pasted image 20250718012659.png]]