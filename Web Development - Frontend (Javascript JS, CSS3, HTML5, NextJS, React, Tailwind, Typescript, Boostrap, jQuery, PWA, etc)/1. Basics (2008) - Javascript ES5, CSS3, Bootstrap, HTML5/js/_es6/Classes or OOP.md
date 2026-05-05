Make parts of your code easy to understand by writing them in terms of how we grasp real life concepts and relationships. This is classes or OOP (Object orientated programming).

Pay attention to inheritance (a mammal is a specific type of animal that inherits its traits, plus has its own traits as a mammal)

Note classes are named in Title case. Note methods have a hybrid of a call versus definition that you are used to from object methods.

```
class Animal {
}


class Mammal extends Animal {
    giveBirth() {
        
    }
}


class Reptile extends Animal {
    laysEgg() {
        
    }
}

var reptile = new Reptile();
```

Before ES6, we could mimick creating classes using Function Prototypes. This is actually more performant than ES6 classes. Its methods should be declared outside using Prototype syntax for performance.:
```
function Car(owner) {
    this.owner = owner;
}

Car.prototype.vroom = function() {
    console.log("Vroom!");
}

var car = new Car();
car.vroom();
```