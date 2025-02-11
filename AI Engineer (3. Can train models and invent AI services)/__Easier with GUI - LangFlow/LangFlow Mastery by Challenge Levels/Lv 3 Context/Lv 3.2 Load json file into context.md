We will add json file as context to the AI model.

Prepare at your computer by creating a d1.json:
```
{  
    "name": "John Doe",  
    "age": 30,  
    "email": "john.doe@example.com",  
    "dept": "IT",  
    "salary": 60000,  
    "job": "Technician",  
    "phone": "1234567890",  
    "address": "123 Main St, Anytown, USA",  
    "city": "Anytown",  
    "state": "CA",  
    "zip": "12345",  
    "country": "USA"  
}
```


At LangFlow, start with Basic Prompt template.

Add system message prompt:
```
You are a helpful assistant named Cody that answer questions about datasets.  
  
Use markdown to format your answer, properly embedding images and urls.  
  
Below are the datasets for employees:   
  
{JSONString}
```

This will create a field called JSONString:
![[Pasted image 20250210185045.png]]

The canvas so far
![[Pasted image 20250210185708.png]]

Let’s have Langflow read d1.json using File component (Found under “Data” components category):
![[Pasted image 20250210185806.png]]

If you click Data you’ll see the datapoints are `file_path` and `text`:
![[Pasted image 20250210185821.png]]

This means you have access to the Data file_path and text, meaning `file_path` and `text` are labels and in order to get their underlying value, you need to extract it. Also notice that the connection out is the type Data (NOT type Message):
![[Pasted image 20250210185907.png]]

We connect the Data out to a component that can extract data labels for their value:
![[Pasted image 20250210185955.png]]

^ Notice the template. The template is what builds the string that will be sent to the JSONString at Systems Message's Prompt. We don't need any fancy labeling so we will get the text value directly and send it as the JSONString. By having `{text}`, the curly brackets instruct Langflow to extract the value from that data label.

And then that value gets passed into {JSONString} of the Prompt message
![[Pasted image 20250210190117.png]]

FYI, and that Prompt message gets passed as System Message. Therefore the AI model now has the json information as part of its system message at.
What was:
```
You are a helpful assistant named Cody that answer questions about datasets.  
  
Use markdown to format your answer, properly embedding images and urls.  
  
Below are the datasets for employees:   
  
{JSONString}
```

Is actually under the hood:
```
You are a helpful assistant named Cody that answer questions about datasets.  
  
Use markdown to format your answer, properly embedding images and urls.  
  
Below are the datasets for employees: 

{  
    "name": "John Doe",  
    "age": 30,  
    "email": "john.doe@example.com",  
    "dept": "IT",  
    "salary": 60000,  
    "job": "Technician",  
    "phone": "1234567890",  
    "address": "123 Main St, Anytown, USA",  
    "city": "Anytown",  
    "state": "CA",  
    "zip": "12345",  
    "country": "USA"  
}
```

---

**Let's see the response**

Now we ask it (either at the Chat Input’s field or in Playground):
```
Please summarize the employee
```

This proves AI model was able to take in your JSON file:
![[Pasted image 20250210190302.png]]