Requirement: Model supports this method of running. You see the option available.

For a quick orientation on the different types of running or deployment, refer to: [[HuggingFace - __Different ways to run models]]

---

## Setup Inference Endpoint

Deploy model with Inference Endpoints:
![[Pasted image 20250219182953.png]]

> [!note] First time running? Then authorize:
> ![[Pasted image 20250219183121.png]]

It'll let you choose the compute resource and also informs you of the pricing (here it's 3 cents an hour)
![[Pasted image 20250219183103.png]]


Deploying a new Endpoint can take up to several minutes, depending on the model size.

> [!note] First time deploying a model?
> Allow **browser notifications** for alerts when your Endpoints are ready!
> ![[Pasted image 20250219183300.png]]

If it runs successfully proceed, it'll give you the endpoint URL. Proceed to next section.

If it fails to run, refer to troubleshooting docs:
[[Module torch has no attribute float8_e4m3fn]]
[[Workload evicted, storage limit exceeded]]

---

## Figure out the code

You're given an endpoint URL and very likely, nothing much. Look at the repo's Readme for example code snippets.

You need:
- You need an access token from Hugging Face. You can get your access token at [[HuggingFace - Create access token]].
- You need the endpoint URL for the deployed model. It becomes available when the starting is successful.

STATUS: Untested

Depending on what AI task you're performing, the code will slightly differ.
- Text gen is the simplest
- Images as inputs require Base64 format for Inference Endpoint (However, Inference Provider handles binary data directly)

See supported types on the correct code depending on what AI task your model supports and that you're doing:
[https://huggingface.co/docs/inference-endpoints/supported_tasks](https://huggingface.co/docs/inference-endpoints/supported_tasks)


Image as inputs (NodeJS):
```
const fs = require("fs");  
const fetch = require("node-fetch");  
  
async function query(filename) {  
    // Read the image file and encode it as Base64  
    const imageBuffer = fs.readFileSync(filename);  
    const base64Image = imageBuffer.toString("base64");  
  
    // Define the API request  
    const response = await fetch("https://<your-endpoint-subdomain>.hf.space/", {  
        headers: {  
            Authorization: "Bearer hf_xxxxxxxxxxxxxxxxxxxxxxxx",  
            "Content-Type": "application/json",  
        },  
        method: "POST",  
        body: JSON.stringify({  
            image: base64Image, // Ensure this matches the expected model input format  
        }),  
    });  
  
    const result = await response.json();  
    return result;  
}  
  
// Example usage  
query("cats.jpg").then((response) => {  
    console.log(JSON.stringify(response, null, 2));  
});
```

Here's a Python boilerplate for text gen models to translate English to French:
```
import requests

# Your Hugging Face API key
HF_API_KEY = "your_huggingface_api_key"

# The endpoint URL of your deployed model
HF_ENDPOINT_URL = "https://api-inference.huggingface.co/models/your-model-id"

# Headers for authentication
HEADERS = {
    "Authorization": f"Bearer {HF_API_KEY}",
    "Content-Type": "application/json",
}

def query_hf_model(payload):
    """
    Sends a request to the Hugging Face inference endpoint.

    Args:
        payload (dict): The input data in JSON format.
    
    Returns:
        dict: The response from the model.
    """
    response = requests.post(HF_ENDPOINT_URL, headers=HEADERS, json=payload)
    if response.status_code == 200:
        return response.json()
    else:
        return {"error": response.status_code, "message": response.text}

# Example usage
if __name__ == "__main__":
    sample_input = {
        "inputs": "Translate 'Hello, how are you?' to French.",
        "parameters": {"max_length": 100}  # Optional model parameters
    }
    
    output = query_hf_model(sample_input)
    print(output)

```

Here's a NodeJS boilerplate:
```
const fetch = require("node-fetch");

// Your Hugging Face API key
const HF_API_KEY = "your_huggingface_api_key";

// The endpoint URL of your deployed model
const HF_ENDPOINT_URL = "https://api-inference.huggingface.co/models/your-model-id";

// Headers for authentication
const HEADERS = {
  "Authorization": `Bearer ${HF_API_KEY}`,
  "Content-Type": "application/json",
};

async function queryHFModel(payload) {
  /**
   * Sends a request to the Hugging Face inference endpoint.
   *
   * @param {Object} payload - The input data in JSON format.
   * @returns {Promise<Object>} - The response from the model.
   */
  try {
    const response = await fetch(HF_ENDPOINT_URL, {
      method: "POST",
      headers: HEADERS,
      body: JSON.stringify(payload),
    });

    if (!response.ok) {
      throw new Error(`HTTP ${response.status}: ${await response.text()}`);
    }

    return await response.json();
  } catch (error) {
    return { error: error.message };
  }
}

// Example usage
(async () => {
  const sampleInput = {
    inputs: "Translate 'Hello, how are you?' to French.",
    parameters: { max_length: 100 }, // Optional model parameters
  };

  const output = await queryHFModel(sampleInput);
  console.log(output);
})();
```

If