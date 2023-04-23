# Mock Data (No testing framework)
```
function showInputs(inputs) {
  const {input1, input2} = inputs;
  console.log("Your inputs are " + input1 + " " + input2);
}

//Comment out live data
//let inputs = {};
//inputs.input1 = prompt("Give me a number for input1");
//inputs.input2 = prompt("Give me a number for input2");

//Inject fake data
const mockData = {
  input1: 1,
  input2: 2
}
inputs = mockData;

showInputs(inputs);
```