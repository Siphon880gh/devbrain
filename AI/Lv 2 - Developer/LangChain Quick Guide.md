https://python.langchain.com/docs/modules/model_io/models/llms/integrations/openai


Get API Key for OpenAI API at:
https://platform.openai.com/


```
require('dotenv').config();
const { OpenAI } = require('langchain/llms/openai');
const inquirer = require('inquirer');

const apiKey = process.env.OPENAI_API_KEY;
const openAIModel = "gpt-3.5-turbo"

/**
 * OpenAI constructor
 * @constructor
 * @param {Object} options - Options for OpenAI API
 * @param {int} options.apiKey - The temperature property represents variability in the words selected in a response. Temperature ranges from 0 to 1 with 0 meaning higher precision but less creativity and 1 meaning lower precision but more variation and creativity.
 * 
 */
const model = new OpenAI({ 
    openAIApiKey: process.env.OPENAI_API_KEY, 
    temperature: 0,
    model: openAIModel
});
// console.log({ model });


const callAPI = async (userPrompted) => {
    const defaultQuestion = "How do you implement a linked list in TypeScript?";
    const finalQuestion = userPrompted?userPrompted:defaultQuestion;
    try {
        /**
         * Query the model with the given prompt
         * @param {string} prompt - The prompt to query to the model
         * @returns {Promise<string>} The model's response as a promise
         */
        const res = await model.call(finalQuestion);
        console.log(res);
    }
    catch (err) {
      console.error(err);
    }
};

//callAPI();

const askCommandPrompt = () => {
    inquirer.prompt([
      {
        type: 'input',
        name: 'userPrompted',
        message: `Ask ${openAIModel} a question:`,
      },
    ]).then(answers => {
        const userPrompted = answers.userPrompted;
        callAPI(userPrompted)
    });
  };
  
  askCommandPrompt();
```