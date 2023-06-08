
<<
In programming what is composition?

\>>
In programming, composition refers to the design principle where complex objects or structures are created by combining simpler or more basic objects together. It is a way of building relationships between objects to create more complex and reusable systems.

Composition involves creating an object that contains other objects as its components or parts. These parts or components can be other objects, modules, or classes, and they are combined to form a larger and more complex object. The main idea behind composition is to achieve code reuse and modularity by creating objects that are made up of smaller, self-contained components.

One of the key benefits of composition is that it allows for greater flexibility and modularity in software design. By breaking down complex systems into smaller, interchangeable parts, you can easily modify or extend the behavior of a system without impacting other parts of the codebase. It promotes code reuse and maintainability by encapsulating functionality within individual components.

Composition is often contrasted with inheritance, another object-oriented programming concept. While inheritance establishes an "is-a" relationship between classes, composition establishes a "has-a" relationship. Composition is generally favored over inheritance because it provides more flexibility, reduces code coupling, and avoids issues like the fragile base class problem.

Here's a simple example in Python to illustrate composition:

```python
class Engine:
    def start(self):
        print("Engine started")


class Car:
    def __init__(self):
        self.engine = Engine()

    def start_engine(self):
        self.engine.start()


my_car = Car()
my_car.start_engine()
```

In this example, the `Car` class has a composition relationship with the `Engine` class. The `Car` class contains an instance of the `Engine` class as one of its components. Through composition, the `Car` class can delegate the responsibility of starting the engine to the `Engine` class.

By using composition, we can easily modify or replace the `Engine` component without impacting the `Car` class or other parts of the code. It provides a modular and flexible way of building complex systems.

<<
Provide example in JS

\>>
Certainly! Here's an example in JavaScript to demonstrate composition:

```javascript
// Component objects
const Engine = {
  start: function() {
    console.log("Engine started");
  }
};

const Wheels = {
  rotate: function() {
    console.log("Wheels rotating");
  }
};

// Composite object
const Car = {
  engine: Object.create(Engine),
  wheels: Object.create(Wheels),

  startEngine: function() {
    this.engine.start();
  },

  drive: function() {
    this.wheels.rotate();
    console.log("Car is driving");
  }
};

// Create an instance of the Car
const myCar = Object.create(Car);

// Use the composed functionality
myCar.startEngine(); // Output: "Engine started"
myCar.drive(); // Output: "Wheels rotating" and "Car is driving"
```

In this example, we have three objects: `Engine`, `Wheels`, and `Car`. The `Engine` and `Wheels` objects represent individual components, while the `Car` object is the composite object that uses composition to combine these components.

The `Car` object has properties `engine` and `wheels`, which are created using `Object.create()` and inherit the behavior from the `Engine` and `Wheels` objects, respectively. The `startEngine()` method of `Car` delegates the responsibility of starting the engine to the `Engine` object, and the `drive()` method combines the behavior of rotating the wheels and driving the car.

By using composition, we can easily add or modify the components of the `Car` object, such as adding more functionality to the engine or wheels, without impacting other parts of the code. Composition provides a flexible and modular approach to building complex systems in JavaScript.