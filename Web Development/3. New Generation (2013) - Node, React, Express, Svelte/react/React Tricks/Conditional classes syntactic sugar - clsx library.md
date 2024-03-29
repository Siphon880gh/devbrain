
Syntactic sugar for conditional classNames - clsx

Install clsx, a React library:
```
npm install --save clsx
```

Import with
```
import clsx from 'clsx';
```

it can build a className that has multiple classes more easily using either syntatic sugar:
https://github.com/lukeed/clsx
https://github.com/lukeed/obj-str

Using clsx (this syntatic sugar passes arguments):
```
// Strings (variadic)
clsx('foo', true && 'bar', 'baz');
//=> 'foo bar baz'


clsx({ foo:true }, { bar:false }, null, { '--foobar':'hello' });
//=> 'foo --foobar'

```


Using obj-str (this syntax passes an object argument):
```
objstr({ foo:true, bar:false, baz:isTrue() });
//=> 'foo baz'
```
