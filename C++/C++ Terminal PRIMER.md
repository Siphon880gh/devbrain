


Certainly! Below is a simple C++ program that takes two numbers as input from the user and then outputs their sum. This program uses basic C++ input/output streams and arithmetic operations.

```cpp
#include <iostream>

int main() {
    int num1, num2, sum;

    std::cout << "Enter first number: ";
    std::cin >> num1;

    std::cout << "Enter second number: ";
    std::cin >> num2;

    sum = num1 + num2;

    std::cout << "Sum = " << sum << std::endl;

    return 0;
}
```

To run this program:

1. Save the code in a file with a `.cpp` extension, for example, `sum.cpp`.
2. Compile the code using a C++ compiler like g++. You can do this by running a command like `g++ sum.cpp -o sum` in your terminal or command prompt.
3. Run the compiled program. If you're using a Unix-like system, you can do this by typing `./sum` in your terminal. On Windows, you would just type `sum`.

This program will prompt you to enter two numbers. After you enter each number, press Enter. The program will then display the sum of these two numbers.