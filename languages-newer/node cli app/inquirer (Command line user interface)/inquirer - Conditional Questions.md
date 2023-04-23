# Inquirer conditional questions

Questions can appear based on previous answers. These questions are conditional and have a method called when.

Add a when method to the question object that is conditional. The when method takes answers object constructed thus far and returns true or false. If returns true, then that question will be asked. 

For readability, you can destructure a previous user response from the answers object and that previous answer could be any value (in the below example, that previous question is a confirm type question that returns true or false)

```
{
  name: 'confirmAbout',
  type: 'confirm',
  message: 'Would you like to enter extra information about who you are?',
  default: true
},
{
  type: 'input',
  name: 'about',
  message: 'Give a discription about yourself:',
  when: ({ confirmAbout }) => {
    if (confirmAbout) {
      return true;
    } else {
      return false;
    }
  }
}
```