
Sometimes you may have a lot of css files and some css rules override the tailwind classes' rules because of `!important` in the theme's css. And it may not be feasible to edit those css files because of time constraints or because it's legacy code you're not supposed to touch.

What you can do is make tailwind classes have `!important` as well, and since tailwind will be loaded after the css files (if setup correctly), then the tailwind styling will persist.

You do NOT need to write an entirely different css rules just to override with the same tailwind classes adding `!important`

Simply the tailwind classes can be prefixed with exclamation mark:
```
!bg-black !bg-opacity-50
```
