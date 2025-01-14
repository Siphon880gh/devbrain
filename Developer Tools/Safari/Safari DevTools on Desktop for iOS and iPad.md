While DevTools on iPad and iPhone not accessible on the device to see why there are errors and what errors there are, you can open DevTools on your computer if you connect to iPad or iPhone via a cable.

With your iPhone or iPad connected to your macbook pro and you havingaccepted Trust to any dialog that appeared:

Then on desktop Safari (whose settings have enabled Developer menu to be accessible), go to menu Develop → your device → the page tab. 

You can simultaneously see element highlighted in your connected device as you move your mouse over elements in the html panel.

A use case is remote developer is to see if the error is because of cached copy on a fresh markup
![](https://i.imgur.com/3e4JDSY.png)


Note color linting not reliable so far into 12/24:

Note that if you view sources, it's error linting with colors is not good. For example we have an error which makes us want to look at sources to look at another js file whose error does not appear on console
![](https://i.imgur.com/QX008a8.png)

The coloring implies syntax error when the syntax is correct (works on other browsers!)
![](https://i.imgur.com/d8l9HSO.png)
