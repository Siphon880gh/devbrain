Requirement: Model supports this method of running. You see the option available.

For a quick orientation on the different types of running or deployment, refer to: [[HuggingFace - __Different ways to run models]]

---

You need:
- You need an access token from Hugging Face. You can get your access token at [[HuggingFace - Create access token]].
- You need the endpoint URL for the deployed model.

If you want to test it with font-identifier:
https://huggingface.co/gaborcselle/font-identifier

Under Deploy for Inference Providers:
![[Pasted image 20250219181227.png]]

Click "Inference Providers" for the code:
![[Pasted image 20250219193214.png]]

Python:
```
import requests

API_URL = "https://router.huggingface.co/hf-inference/v1"
headers = {"Authorization": "Bearer hf_xxxxxxxxxxxxxxxxxxxxxxxx"}

def query(filename):
	with open(filename, "rb") as f:
		data = f.read()
	response = requests.post(API_URL, headers=headers, data=data)
	return response.json()

output = query("cats.jpg")
```

NodeJS:
```
async function query(filename) {
	const data = fs.readFileSync(filename);
	const response = await fetch(
		"https://router.huggingface.co/hf-inference/models/gaborcselle/font-identifier",
		{
			headers: {
				Authorization: "Bearer hf_xxxxxxxxxxxxxxxxxxxxxxxx",
				"Content-Type": "application/json",
			},
			method: "POST",
			body: data,
		}
	);
	const result = await response.json();
	return result;
}

query("cats.jpg").then((response) => {
	console.log(JSON.stringify(response));
});
```

Depending on how the model is used, the code slightly differs. Here it takes image inputs.

Select the language of your choice then run on your computer, making sure to replace the access token. 