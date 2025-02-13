In this example we will give the LLM agent ability to use calculator and web browser!

A questions we can ask can be
```
Find the current exchange rate from USD to EUR and calculate how much 500 USD is worth in EUR.
```

The LLM's knowledge will know where to look online, so it'll use the web browser tool to look online, fetch the data, then the AI knows how to parse that data for specific numbers, then it uses the calculator which are function calls that the AI is instructed how to use, then evaluates the answer. The LLM is used to reword its finding into a proper response.

We can also expand LLM agent to grab image url's from the internet for appropriate prompts. Eg.
```
Find the current U.S. average mortgage interest rate for a 30-year fixed loan and calculate the monthly payment for a $350,000 loan.

Give me a diagram of how this is usually calculated.
```

Remember that the Agent decides which tool to use to solve a problem.

---

Start with the "Simple Agent" template:
![[Pasted image 20250213032144.png]]

Your components will look like (Make sure to input your OpenAI API key):
![[Pasted image 20250213032213.png]]
^ The system message is: `You are a helpful assistant that can use tools to answer questions and perform tasks.... Use markdown to format your answer, properly embedding images and urls.`

At Chat Input (The Agent component moved the Input connection towards the bottom) or Playground, ask:
```
Find the current exchange rate from USD to EUR and calculate how much 500 USD is worth in EUR.
```

Then run the flow (click Play at the right-most Chat Output if in canvas mode, or submit the question if in Playground mode)

If in canvas mode, click "Messages" out port at the Chat Output to see the response:
![[Pasted image 20250213032913.png]]

- Clicked the text field to expand:
  ![[Pasted image 20250213032929.png]]

- You can see work done at URL's Toolset window:
  ![[Pasted image 20250213033113.png]]
  
- You can see work done at Calculator's window:
  ![[Pasted image 20250213033239.png]]

- Btw, the tool work done can be accessed because these components have toolmode on:
  ![[Pasted image 20250213033320.png]]

---

If you had used Playground, it would respond with:
![[Pasted image 20250213032639.png]]

And you can expand to see its work (here it tells you two tools are used):
![[Pasted image 20250213032759.png]]


**Congratulations!** You can now provide tools to an AI model and enable it to help answer your questions using those tools, such as a web browser and a calculator.

---

**Discussion**


- The tool work done can be accessed because these components have toolmode on:
  ![[Pasted image 20250213033320.png]]


- In a typical tool, their code has toolmode as well:
	```
	import ast  
	import operator  
	from collections.abc import Callable  
	  
	from langflow.custom import Component  
	from langflow.inputs import MessageTextInput  
	from langflow.io import Output  
	from langflow.schema import Data  
	  
	  
	class CalculatorComponent(Component):  
	    display_name = "Calculator"  
	    description = "Perform basic arithmetic operations on a given expression."  
	    icon = "calculator"  
	  
	    # Cache operators dictionary as a class variable  
	    OPERATORS: dict[type[ast.operator], Callable] = {  
	        ast.Add: operator.add,  
	        ast.Sub: operator.sub,  
	        ast.Mult: operator.mul,  
	        ast.Div: operator.truediv,  
	        ast.Pow: operator.pow,  
	    }  
	  
	    inputs = [  
	        MessageTextInput(  
	            name="expression",  
	            display_name="Expression",  
	            info="The arithmetic expression to evaluate (e.g., '4*4*(33/22)+12-20').",  
	            tool_mode=True,  
	        ),  
	    ]
	```

-   The Agent decides which tool to use to solve a problem.
	- Already done for you with these components, but the Langflow team named and described tools to help agents understand when to use each tool.
	- You can see these descriptions by going into Tools Mode for a component, then clicking "Edit tools"
	- The "Edit tools" buttons:
		![[Pasted image 20250213033902.png]]
	  
	- Web browser:
		![[Pasted image 20250213034002.png]]
	  
	- Calculator:
	    ![[Pasted image 20250213034021.png]]
	    
	- Agent:	
		![[Pasted image 20250213034047.png]]
		
	- The Agent component's code is an instance of the AgentComponent class which maintains a list of tools at `self.tools` based on incoming connections to Tools field, and that's how it's able to access the definitions of the tools.

---

**Other prompts you can test**

Here are some questions that require both the ability to go online and use a calculator:

**Questions Requiring Both Online Search & Calculator:**

1. **Currency Exchange & Conversion**
    - Find the current exchange rate from USD to EUR and calculate how much 500 USD is worth in EUR.
2. **Stock Market Calculation**
    - Look up the latest stock price of Tesla (TSLA) and calculate the percentage change from its closing price a week ago.
3. **Weather Impact on Solar Energy**
    - Find the solar irradiance (W/m²) in your city today and calculate how much energy (kWh) a 5 kW solar panel would generate in 6 hours.
4. **Travel Cost Estimation**
    - Find the current gas price per gallon in Los Angeles and calculate the cost of a 300-mile trip in a car that gets 25 mpg.
5. **Loan Interest Calculation**
    - Find the current U.S. average mortgage interest rate for a 30-year fixed loan and calculate the monthly payment for a $350,000 loan.

Questions Requiring **Only Online Search**:

1. What are the top products on Product Hunt today?
2. What are the latest interest rates for 1-year fixed deposits in major U.S. banks?
3. Who won the Super Bowl this year?
4. What is the latest GDP growth rate for the U.S.?

Questions Requiring **Only Calculator**:

1. What is the compound interest on $5,000 at 5% annual interest compounded monthly for 3 years?
2. Solve this equation: 3x2−5x+2=03x^2 - 5x + 2 = 0.
3. What is the factorial of 12?