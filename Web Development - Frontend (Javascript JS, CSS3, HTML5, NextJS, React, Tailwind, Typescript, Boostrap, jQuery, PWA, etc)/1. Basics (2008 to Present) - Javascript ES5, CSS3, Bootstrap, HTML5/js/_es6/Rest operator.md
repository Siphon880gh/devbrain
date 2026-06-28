# ES6 Fundamental: Rest operator
Store the reset of the key-value pairs into a variable
```
const finishOrder = [
  'Speed Racer', // #1 place
  'Flash Marker Jr.', // #2 place
  'Racer X', // #3 place
  'Snake Oiler',
  'Trixie',
  'Grey Ghost',
  'Taejo Togokhan'
];

const [first, second, third, ...theRest] = finishOrder;
// ^var ^var ^var ^array of the other racers
```

Warning: Not to be confused with spread operator which also uses the "..." keyword