Example:
```
inquirer.prompt([{
    name: "foobar",
    message: "choose: ",
    type: "list",
    choices: [{
            name: "a",
            value: 1
        },
        {
            name: "b",
            value: 2
        }
    ]

}]).then((answers) => {
    console.log({ answers })
});
```