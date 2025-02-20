Aka Pipelines, Transformers

The pipelines are a great and easy way to use models for inference. These pipelines are objects that abstract most of the complex code from the library, offering a simple API dedicated to several tasks, including Named Entity Recognition, Masked Language Modeling, Sentiment Analysis, Feature Extraction and Question Answering.

See supported pipeline tasks:
https://huggingface.co/docs/transformers/task_summary

There are two categories of pipeline abstractions to be aware about:
- The [pipeline()](https://huggingface.co/docs/transformers/v4.49.0/en/main_classes/pipelines#transformers.pipeline) which is the most powerful object encapsulating all other pipelines.
- Task-specific pipelines are available for [audio](https://huggingface.co/docs/transformers/main_classes/pipelines#audio), [computer vision](https://huggingface.co/docs/transformers/main_classes/pipelines#computer-vision), [natural language processing](https://huggingface.co/docs/transformers/main_classes/pipelines#natural-language-processing), and [multimodal](https://huggingface.co/docs/transformers/main_classes/pipelines#multimodal) tasks.
  
- Read more: [https://huggingface.co/docs/transformers/main_classes/pipelines#pipelines](https://huggingface.co/docs/transformers/main_classes/pipelines#pipelines)

---

At hugging face, I can only use transformers on a model if under "Use this model" has "Transformers":
![[Pasted image 20250219181304.png]]

Clicking it reveals:
Using as example https://huggingface.co/gaborcselle/font-identifier
![[Pasted image 20250219194524.png]]


---

Then at your computer's side

Make sure you have HF Transformers installed https://huggingface.co/docs/transformers/en/installation (`pip install transformers`)

If the model is **public**, you can use transformers/pipelines without authentication. Otherwise
- Code authentication using login syntax:
  ```
	  from huggingface_hub import login  
	  login("YOUR_ACCESS_TOKEN")
	```
	- Then proceed with transformers/pipelines AI tasks (We assume you will adjust the code to use env variables):
	```
	from huggingface_hub import login
	from transformers import AutoModelForCausalLM, AutoTokenizer, pipeline
	
	# Log into Hugging Face (enter token when prompted)
	login("YOUR_ACCESS_TOKEN")
	
	# Define the model name (e.g., a GPT-style model)
	model_name = "mistralai/Mistral-7B-Instruct-v0.1"
	
	# Load the model and tokenizer
	tokenizer = AutoTokenizer.from_pretrained(model_name)
	model = AutoModelForCausalLM.from_pretrained(model_name)
	
	# Create a text generation pipeline
	generator = pipeline("text-generation", model=model, tokenizer=tokenizer)
	
	# Generate text
	prompt = "Once upon a time,"
	output = generator(prompt, max_length=50, do_sample=True)
	
	# Print result
	print(output[0]['generated_text'])
	```
- Code authentication using token syntax:
```
import os
from transformers import AutoModel, AutoTokenizer

model_name = "your-private-model"
token = "YOUR_ACCESS_TOKEN" # OR: os.getenv("HUGGINGFACE_TOKEN")

tokenizer = AutoTokenizer.from_pretrained(model_name, use_auth_token=token)
model = AutoModel.from_pretrained(model_name, use_auth_token=token)
```
- CLI authentication using storage space (where token is stored as a file)
	- Before running the script, authenticate with hf cli (hf cli can be installed as follows https://huggingface.co/docs/huggingface_hub/main/en/guides/cli):
  ```
	  huggingface-cli login
	```
	- It will ask for your access token which you can get from [[HuggingFace - Create access token]], then it saves the access token to your computer at a location such as (if Mac) /Users/USER/.cache/huggingface/token
	- Your script code needs to transmit the parameter "use_auth_token=True" to model and tokenizer. It'll know where to look for your access token on the computer:
		```
		from transformers import pipeline
		
		# Define the private model name
		model_name = "your-private-model"  # Replace with your actual private model
		
		# Example 1: Text Generation Pipeline (e.g., GPT-style model)
		generator = pipeline("text-generation", model=model_name)
		
		prompt = "Once upon a time, there was a"
		output = generator(prompt, max_length=50, do_sample=True)
		print("Generated Text:", output[0]['generated_text'])
		
		# Example Output:
		# "Once upon a time, there was a brave young knight who set out on a journey to find the legendary sword of his ancestors. 
		# Along the way, he encountered fierce dragons and made unexpected allies..."
		
		# Example 2: Text Classification Pipeline (e.g., sentiment analysis)
		classifier = pipeline("text-classification", model=model_name)
		
		text = "I love AI! It's so exciting."
		classification = classifier(text)
		print("Classification Result:", classification)
		
		# Example Output:
		# [{'label': 'POSITIVE', 'score': 0.98}]
		
		# Example 3: Embedding Pipeline (for feature extraction)
		embedding_pipeline = pipeline("feature-extraction", model=model_name)
		
		text_embedding = embedding_pipeline("Transformers make NLP easy!")
		print("Embedding:", text_embedding[0][:5])  # Print first 5 values for preview
		
		# Example Output:
		# Embedding: [[0.123, -0.045, 0.789, -0.342, 0.512], ...] (List of floats representing text embeddings)
		```


During the first time you use a specific model (`pipe = pipeline("fill-mask", model="model_name")`), it will download the necessary model files and tokenizer to your local cache directory. Subsequent uses will load the model from the local cache, speeding up the process

---

Code Snippet: A sentiment analysis:
```
from transformers import pipeline, AutoModelForTokenClassification, AutoTokenizer  
  
# Sentiment analysis pipeline  
analyzer = pipeline("sentiment-analysis")  
  
# Question answering pipeline, specifying the checkpoint identifier  
oracle = pipeline(  
    "question-answering", model="distilbert/distilbert-base-cased-distilled-squad", tokenizer="google-bert/bert-base-cased"  
)  
  
# Named entity recognition pipeline, passing in a specific model and tokenizer  
model = AutoModelForTokenClassification.from_pretrained("dbmdz/bert-large-cased-finetuned-conll03-english")  
tokenizer = AutoTokenizer.from_pretrained("google-bert/bert-base-cased")  
recognizer = pipeline("ner", model=model, tokenizer=tokenizer)
```