## Request Access to get Pre-Signed URL

Visit https://www.llama.com/llama-downloads/

Fill form and select the model you want. After submitting the form and clicking you agree on their legal agreement, they give you a pre-signed URL that proves you accepted the agreement. Keep this URL for downloading the model.

For each model that you request, you will receive an email that contains instructions and a pre-signed URL to download that model.

### Download the Model using their Llama CLI Downloader and your Pre-signed URL
1. Install the [Llama CLI](https://github.com/meta-llama/llama-stack) if don't have: 
   `pip install llama-stack`
    
2. Run `llama model list` to show the latest available models and determine the model ID you wish to download. **NOTE**: If you want older versions of models, run `llama model list --show-all` to show all the available Llama models.
   
   A small sample of what could show:
   ```
   Llama3.2-11B-Vision-Instruct | meta-llama/Llama-3.2-11B-Vision-Instruct | 128K
   Llama3.2-90B-Vision-Instruct | meta-llama/Llama-3.2-90B-Vision-Instruct | 128K
	```


4. Run: `llama download --source meta --model-id CHOSEN_MODEL_ID`
    
4. Pass the URL provided when prompted to start the download.
   
5. When the download is complete, it'll give you the folder path to where your model files are stored.  
	1. Your folder path could be:
		1. /Users/wengffung/.llama/checkpoints/Llama3.2-11B-Vision-Instruct
	2. Your files could be:
		1. checklist.chk
		2. params.json
		3. consolidated.00.pth
		4. tokenizer.model