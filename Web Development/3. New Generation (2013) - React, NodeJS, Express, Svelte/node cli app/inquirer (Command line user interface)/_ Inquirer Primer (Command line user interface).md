What is Inquirer?

Useful command line user interface for Node JS.
Ask user questions on the command line. 
They can type responses, leave blank, choose answer, choose multiple answers, confirm with Y/N, type a response in their text editor, etc

1. Setup package.json through command line, then install inquirer module.

2. You'll require the inquirer module.
Documentation is here: https://www.npmjs.com/package/inquirer
Tip: You can search for module documentations on https://www.npmjs.com/
```
const inquirer = require("inquirer");
```

3. Here you use the inquirer API
You are chaining methods to inquirer object: prompt, then, catch. 
- .prompt(..) receives an array of question objects where each object has field "name" where you give the variable name that stores the user's input in .then(). Furthermore, the question object indicates the type of question, the question message to display, and additional properties applicable to the question type.
 - The default type is input, so `type: "input"` is optional.
 - Some questions you don't want user to skip. Validate method will make sure the screen goes to the next question only if it returns true based on your logic with the input. Additionally, you can display a validation message by returning a string instead of false.
- .then(..) method gets an array of answer objects where you get the inputs from the variable names you set at the "name" fields.
- .catch() method catches any error. Inquirer forces you to chain onto .catch(), otherwise the Node script will error.

```
inquirer.prompt([{
            name: "name",
            message: "Patient's name?",
            type: "input",
            validate: input => Boolean(input.length)
        },
        {
            name: "age",
            message: "What's the age?",
            type: "number",
            validate: input => {
                if (isNaN(input) || typeof input !== "number")
                    return "Hint: Enter a number!"
                else
                    return true;
            }
        },
        {
            name: "gender",
            message: "What's the biological gender?",
            type: "list",
            choices: [
                "M",
                "F"
            ]
        },
        {
            name: "cc",
            message: "Chief complaint (Why they come here?)",
            type: "editor"
        },
        {
            name: "covid",
            message: "Meet at least 2 Covid symptoms?",
            type: "confirm"
        },
        {
            name: "insurance",
            message: "Select Insurance (can use more than one)",
            type: "checkbox",
            choices: [
                "BlueShield",
                "Medicare",
                "Medical",
                "Kaiser",
                "Health Net",
                "LA Care",
                "Western Health",
                "Others"
            ]
        },
    ]).then(answers => {
        let { name, age, gender, cc, covid: isCovid, insurance } = answers;
        let time = new Date().toISOString().match(/(\d{2}:){2}\d{2}/)[0];

        console.log(`Time intake: ${time}.\nPatient ${name} is a ${age}yo ${gender} coming in for:\n\t${cc}${isCovid?"Recommend":"Not recommend"} swabbing for Covid-19.\nInsurance on file: ${insurance.join(", ")}.`);

    })
    .catch(err => {
        console.log("Error: ", err);
    })
```