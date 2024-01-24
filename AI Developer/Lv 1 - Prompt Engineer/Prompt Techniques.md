Status: Need legal reword


Users interact with LLMs using natural language input. Human users type the instructions for the model into a textual interface. The term **prompt** refers to the text that the user enters into the text field. Put differently, a prompt is the text that the user gives to the AI algorithm to tell it what to do.

  

The model takes the instructions from the prompt, completes the task, and then provides a response to the user. The response from the model is frequently referred to as the **output**.

  

In this course, our focus will be on **text outputs**, but different types of generative AI models provide different outputs. In the case of image generators like Stable Diffusion and Midjourney, the output is an image file.

  

A prompt can be a simple, straightforward question, such as, `Who was the first president of the United States?` Or it could be a vague request for the model to generate a type of text, such as, `Write a haiku about the beauty of AI.`

  

Prompts can also be complex, with key pieces of data and instructions to guide the model toward an output that will be the most useful to the user. Remember, LLMs generate responses based on an extremely high volume of data. The exact data that it uses to form the output will be significantly impacted by the specific words that the user inputs in the prompt.

### Prompt Engineering

  

**Prompt engineering** is the newly emerging field of methodically crafting the input for a generative AI model to give users an output that best meets their needs.

  

In order to generate the best output from a generative AI model, it helps to understand the opportunities and limitations of these models. This knowledge will help you phrase your prompt in the way that best allows the model to meet your needs.

  

Here are a few key pieces of information to keep in mind as you develop your prompts:

- Even very minor changes in the way a user phrases a prompt can lead to significant changes in the types of output an AI model generates. That’s why it’s important to take a methodical approach when developing prompts.
    
- When approaching prompt engineering, remember that AI models are only trained to predict the next word or “token.” Essentially, these models are text completers. The more accurate the input you provide, the more accurate and helpful you can expect the output to be.
    
- The AI model’s response is **stochastic**, which means randomly determined. Because the model is pulling from large amounts of data you will get a different output even when you enter the exact same prompt.
    
- Be on the lookout for **AI hallucinations**, the phenomenon of an AI model generating content that “feels” like a legitimate output, but is based on unreliable data. Again, because the model is pulling from an extremely high volume of data, not all of that data may be factually correct. A well-engineered prompt can decrease the risk of generating an AI hallucination.
    
- Sometimes a high-level of domain expertise may be required in order to develop a well-engineered prompt. Take, for example, the case of a medical doctor using an AI algorithm to suggest treatment options based on a patient’s medical history. The person engineering the prompt would not only need to know the best vocabulary to use to generate the desired output, they would also need to have an understanding of the treatment options to be able to evaluate and validate the output.
    

###   

---
---

###   

### Components of Prompt Engineering

When developing a prompt, you must include at least one of the following:

- Instructions
- Question

In addition to instructions or a question, you will likely want to include some aspect of these two optional components in your prompt to guide the algorithm toward an output that will be the most useful to you:

- Input data
- Examples


Users can provide **input data** to give the model additional information about the type of output they desire. The possibilities of the type of data that can be provided are endless, and will depend on the type of output desired.

  
Users can add anything from simple audience demographic information (age, level of education, physical location) to .csv files with many data points, and anything in between that will help to guide the model toward the desired output.

  
It can also be helpful to specify the tone that you would like the algorithm to use in its response.


![](https://i.imgur.com/9OqqnLL.png)


In this case, instead of asking the model to tell us a joke about penguins, we specified the tone—dad joke.

  

**Examples** help to focus the data that the model uses in its output, and are particularly useful when prompting the model to provide recommendations.

  

Let’s say you’re looking for something to watch tonight and you know you’re in the mood for a movie about a killer shark. Instead of just asking the algorithm to suggest a shark movie, you can improve the chances of the model suggesting a movie that you will enjoy by giving the algorithm some insight into your preferences. In your prompt you could tell the algorithm that you like _Jaws_, _The Shallows_, and _Open Water_, but don’t like the _Sharknado_ movies or _The Meg_. This information makes it more likely that you’ll get an output that matches your specific taste in shark movies.

![](https://i.imgur.com/wtUPcSr.png)



Providing such examples **after instructions** appears to be more effective than before them. **Changing the order of the examples will also change the output, so you may want to experiment with phrasing until you find the optimal result.**

  

When you add these optional components to a prompt, you give the algorithm additional data that personalizes the response, rather than relying on the entire breadth of the training data.

---

### Techniques to Improve Outputs

  

Now that you have a better understanding of what prompt engineering is, we’ll explore some specific techniques that you can use to enhance your prompts.

#### Zero-shot, One-shot, and Few-shot Prompting

  

As mentioned, the number of examples and detail of input data that the user provides to the algorithm can make a significant difference in the output. Prompt engineers use specific terms to describe the number of data points provided.

  

**Zero-shot prompting** refers to the technique of providing the model with no additional pieces of data to make its prediction. In our shark movie example, that would look something like this:


![](https://i.imgur.com/igrPD8P.png)


Zero-shot prompting is useful when seeking a broad output. Through the use of questions and answers with the algorithm, you can then guide it toward a more specific output if you so choose. Zero-shot prompting can also be a great tool when seeking a creative, out-of-the box output from the model.

  

---

  

**One-shot prompting**, as you probably guessed, refers to the practice of providing the algorithm with a single example or data-point. In our shark movie example, it would look something like this:


![](https://i.imgur.com/MSHg33E.png)



One-shot prompting can be useful when you’re seeking to narrow down the output, but still want to give the algorithm room to come up with potentially unpredictable outputs. It’s also clearly best utilized in cases where the user may only have a limited amount of data.

---

It will come as no surprise that **few-shot prompting** is when a user provides more than one example or datapoint—usually between two and five. This technique allows users who have multiple data-points to focus the model and guide it to find more specific outputs. Our original shark movie prompt is an example of few-shot prompting:


![](https://i.imgur.com/KUngOve.png)


####   

---
---

####   

#### Chain of Thought Prompting

  

**Chain of Thought Prompting** (also known as CoT) is a method used to guide the model to providing factually correct responses by forcing it to respond to a series of steps during the process of developing an output response.

![](https://i.imgur.com/lJgoUzp.png)

The technique requires the user to explicitly ask the model to take a “step-by-step” process in the instructions. In addition, it is generally best practice to ask the model to explain its reasoning in the output, and to follow a specific format.


Here is comparison of results from standard versus CoT prompting:

![](https://i.imgur.com/ZoOEcWu.png)

  

CoT is an extremely helpful technique when seeking factually accurate information because it gives the user insight into how the algorithm reached the desired output, enabling the user to validate the algorithm’s response.

  

CoT also significantly reduces the risk of hallucination in the model. Remember that “hallucinating” is the phenomenon of an AI model generating content that “feels” like a legitimate output, but isn’t based on legitimate data. It’s one of the biggest risks of using transformer models right now.

---

  

---

#### Prompting Citations

  

Forcing the model to provide citations in its response is an effective way of reducing the risk of hallucination. In the prompt, the user can either ask the model to use specific sources, or take a more general approach, such as asking it to “use only credible sources.”

**[Answer only using reliable sources and cite those sources]**

  

As with CoT, asking the model to provide sources in its response will have two benefits: it will guide the model toward a more accurate response, and it will also provide you with a method of verifying the response from the model.

  
![](https://i.imgur.com/c85pQhK.png)


####   

---
---

####   

#### Asking the Model to Play a Role

  

Asking the model to play a specific role is also an effective way to improve your output and reduce the risk of hallucination. Consider the example below:

![](https://i.imgur.com/PuRKLcS.png)

####   

---
---

####   

#### Question and Answer

  

Leading the model toward an output through a series of follow up questions is another effective way of steering the model toward the desired output. This technique allows the user to course correct if the model begins to go off track.

  

Believe it or not, some transformer models respond well to forceful language, including all capitalization and exclamation points, as in the example below:



![](https://i.imgur.com/Oz2xPDX.png)



####   

---

  

---

####   

#### Templates

  

Developing templates is one of the most effective strategies available for prompting thorough, accurate responses from a transformer model. Templates can use any combination of the engineering techniques we’ve covered so far, but the benefit is that the same well-engineered prompt can be re-used with different data points, increasing the model’s efficiency.

  

For the remainder of the course, we’ll focus on developing prompt templates.

---

---

Next, we will explore how we can modify ChatGPT's responses by changing the tone, context, or format of the prompt.

  

- We will see how we can have more control over its outputs and possibly get better results.
    
- We will also discuss the limitations of ChatGPT and how to avoid receiving misinformation.
    
- In another demo, we will see how some questions are subjective and how ChatGPT provides general methods for answering them.
    
- We will also see how users can try to misform ChatGPT and how OpenAI's engineers use training data to improve ChatGPT's algorithms.
    
- Finally, we will look at a demo where ChatGPT generates a story from a given prompt.
    
- We will see how ChatGPT can understand the context and continue the narrative based on what it has learned from its training data.
    
- Throughout this module, we will learn about the different techniques and approacheswe can use to get the best possible results from ChatGPT.