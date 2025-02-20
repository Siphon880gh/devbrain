
There are different ways to run models on HuggingFace. A model may not support all ways to run

## Find out what methods to run a model

Under Deploy are:
Inference Providers, Inference Endpoints, and Spaces
![[Pasted image 20250219181227.png]]

Under Use this model is:
Transformers
![[Pasted image 20250219181304.png]]


If an option is missing, then that means that model DOES NOT support that method of running.

## Inference (Remote Resources)

To help remember Inference Providers vs Inference Endpoint
 - Inference: **inference** refers to the process of using a trained model to make predictions or generate outputs based on new, unseen data.
 - Inference Provider means HuggingFace's servers and partner servers will host it for you so your code can just make requests to their hugging face facing server Aka serverless
 - Inference Endpoints mean you choose the Cloud service and resources (eg. 4 GB space). It can cost very cheaply like cents every hour. Aka Dedicated.


Here’s a table summarizing the differences between **Hugging Face Inference API (Router-based)** and **Hugging Face Inference Endpoints**:

| **Feature**                | **Hugging Face Inference API**                                 | **Hugging Face Inference Endpoint**                                                                                                    |
| -------------------------- | -------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------- |
| **Aka's**                  | Serverless, Router                                             | Dedicated, Cloud                                                                                                                       |
| **API URL**                | `https://router.huggingface.co/hf-inference/models/{model_id}` | Custom URL: `https://<your-endpoint-subdomain>.hf.space/`<br><br>Or could be:<br>`https://<your-endpoint-subdomain>.huggingface.cloud` |
| **Hosting & Scaling**      | Managed by Hugging Face, shared across users                   | Fully private, dedicated to you                                                                                                        |
| **Rate Limits**            | May have rate limits depending on your HF plan                 | No rate limits (depends on your hosting setup)                                                                                         |
| **Authentication**         | Requires Hugging Face API token (`Bearer hf_xxx`)              | Also requires API token (`Bearer hf_xxx`)                                                                                              |
| **File Upload**            | Supports raw file uploads (binary image)                       | May require Base64 encoding or a different format                                                                                      |
| **Request Payload Format** | Direct binary file or JSON `{ "inputs": ... }`                 | Typically requires JSON `{ "image": "<base64>" }`                                                                                      |
| **Response Time**          | Can be slower due to shared infrastructure                     | Faster since it's a dedicated instance                                                                                                 |
| **Response Format**        | Model-dependent JSON response                                  | Model-dependent JSON response (may vary slightly)                                                                                      |
| **Customization**          | Cannot modify model behavior                                   | Can modify or fine-tune the model                                                                                                      |
| **Use Case**               | Quick & easy model access                                      | Production-ready deployment                                                                                                            |

---

## Spaces (Remote GUI)
 Space is using Gradio which is similar to Streamlit. It looks at your AI use code then generate common UI elements on a webpage so people can use it (eg. if your AI code takes in images, it'll have an upload image form). Then the space is available on the model's page (HuggingFace owns Gradio after acquisition on 2021):
   

Bottom right shows spaces created from that model:
![[Pasted image 20250219181627.png]]

Clicking "klick/gabor..." opens a space:
![[Pasted image 20250219181653.png]]

---

## Transformers (Local)

Transformers or pipelines SDK makes coding to use the model easier. It'll automatically download the model to your cache if not downloaded yet. However, it will use your computer's resources.


---

## Note on reading docs

https://huggingface.co/docs/inference-endpoints/index

![[Pasted image 20250219182111.png]]

Make sure you've chosen the correct set of documents. For instance, the above is for Inference Endpoints