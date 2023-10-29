
Example: Interview coach

package.json requirements:
```
  "dependencies": {
    "dotenv": "^16.3.1",
    "express": "^4.18.2",
    "langchain": "^0.0.145"
  },
```

Your express route can receive the request from frontend:
```
const {test1, test2} = require("./libs/gpt")

//...

app.post("/api/ask-our-api", async(req, res) => {
  if(req.body.length===0) {
    res.json({error: "No prompt provided."})
  }

  console.log(req.body)
  let response = await test1("This is for improving my interview skills. Below are information about the job, my qualifications, and my question/answer. Improve my answer for clarity and flow.", req.body.context);
  //console.log(test1);
  //response = {};
  res.send(response);
})

```


This is the /libs/gpt custom library we're making:
```
require('dotenv').config();
const { OpenAI } = require('langchain/llms/openai');
const { PromptTemplate } = require("langchain/prompts");
const { StructuredOutputParser } = require("langchain/output_parsers");
// const inquirer = require('inquirer');

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

/**
 * 
 * @function    getTextResponse
 * @description Respond to user in plain text. No structured JSON.
 * 
 */ 
const getTextResponse = async (basePrompt, context) => {
    const defaultQuestion = "This is for improving my interview skills. Below are information about the job, my qualifications, and my question/answer. Improve my answer for clarity and flow.";
    const finalBasePrompt = basePrompt?basePrompt:defaultQuestion;
    // console.log({finalBasePrompt})
    // console.log({context})
    try {
        /**
         * Query the model with the given prompt
         * @param {string} finalBasePrompt - The prompt to query to the model
         * @returns {Promise<string>} The model's response as a promise
         */
        const res = await model.call(finalBasePrompt + "\n" + context);
        
        return res;
    }
    catch (err) {
      console.error(err);
    }
};

/**
 * 
 * @function    getStructResponse
 * @description Respond as an JSON object that can be parsed in building out an app. 
 *              StructuredOutputParser instance as parser has a utility method that will parse the JSON response into a native type.
 * 
 */ 
const getStructResponse = async (basePrompt, parser) => {
    const defaultQuestion = "This is for improving my interview skills. Below are information about the job, my qualifications, and my question/answer. Improve my answer for clarity and flow.";
    const finalBasePrompt = basePrompt?basePrompt:defaultQuestion;
    try {
        /**
         * Query the model with the given prompt
         * @param {string} finalBasePrompt - The prompt to query to the model
         * @returns {Promise<string>} The model's response as a promise
         */
        const res = await model.call(finalQuestion);

        const structured = await parser.parse(res)
        console.log(structured);

        return structured;

    }
    catch (err) {
      console.error(err);
    }
};

const chainOfThoughtPrompts = (prompts) => {
  // TODO: Iterate prompts array. Consider OOP
}

async function test1(basePrompt, context) {
  // console.log({context})
    var textResponse = await getTextResponse(basePrompt, context);
    console.log(textResponse);
    return textResponse;
}



async function test2() {

    let userPrompt = "How to implement a linked list in Javascript?"
    const parser = StructuredOutputParser.fromNamesAndDescriptions({
        "code": "Javascript code that answers the user's question",
        "explanation": "Detailed explanation of the example code provided. Do not include the code itself in the explanation. Do not break my JSON parser.",
    });

  const formatInstructions = parser.getFormatInstructions();
    const robustInstructions = "Only reply back to me in JSON object so I can parse correctly with code."

    const prompt = new PromptTemplate({
      template: "You are a javascript expert and will answer the user’s coding questions thoroughly as possible.\n{userPrompt}\n{robustInstructions}\n{formatInstructions}",
      inputVariables: ["userPrompt"],
      partialVariables: { formatInstructions, robustInstructions } // Looks like this is old syntax and now need CompletionRequest
    });

    const finalPrompt = await prompt.format({
      userPrompt
    })
    //console.log({formatInstructions})
    // console.log({finalPrompt})


    return await getStructResponse(finalPrompt, parser);
} // test2

module.exports = {test1,test2};
```


Extra practice: Rewrite this code so it becomes a data structure and algorithms interview practice app.