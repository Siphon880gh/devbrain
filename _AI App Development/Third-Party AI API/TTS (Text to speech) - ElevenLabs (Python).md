Sign up for elevenlabs

[https://elevenlabs.io/](https://elevenlabs.io/)  

create .env with your api key (it’s automatically generated for you when you signup)
```
# Login ElevenLabs -> Profile -> API Key  
ELEVENLABS_API_KEY=xx
```

You need both your API key and a specific voice (by their voice ID)

Find a voice you like at the Voice Library. Remember the voice name. 
Then create and run a get_voices.py (`python get_voices.py`)

```
import requests  
from dotenv import load_dotenv  
import os  
  
# Load .env file  
load_dotenv()  
secret_key = os.getenv('ELEVENLABS_API_KEY')  
  
url = "https://api.elevenlabs.io/v1/voices"  
  
headers = {  
  "Accept": "application/json",  
  "xi-api-key": secret_key  
}  
  
response = requests.get(url, headers=headers)  
  
print(response.text)
```


Find the voice name, then its corresponding voice id (voice_id)

You will soon make a POST text to speech request
https://elevenlabs.io/docs/api-reference/text-to-speech

Make a generate function:
```
# TTS returning file path to written audio file  
def generate(text, voiceID="o8FLtfTayIsipfgTinZ0", filename="output.mp3", model_id="eleven_monolingual_v1", stability=0.5, similarity_boost=0.5):  
  CHUNK_SIZE = 1024  
  url = f"https://api.elevenlabs.io/v1/text-to-speech/{voiceID}"  
  
  headers = {  
    "Accept": "audio/mpeg",  
    "Content-Type": "application/json",  
    "xi-api-key": secret_key  
  }  
  
  data = {  
    "text": text,  
    "model_id": model_id,  
    "voice_settings": {  
      "stability": stability,  
      "similarity_boost": similarity_boost  
    }  
  }  
  
  # return data  
  
  
  try:  
    response = requests.post(url, json=data, headers=headers)  
  
    # Check if the request was successful  
    if response.status_code == 200:  
        # Save the file  
        with open(filename, 'wb') as f:  
            for chunk in response.iter_content(chunk_size=CHUNK_SIZE):  
                if chunk:  
                    f.write(chunk)  
        return {"success":True, "filepath":filename}  
  
    else:  
        # Handle the error with information  
        error_info = response.json() if response.headers.get('Content-Type') == 'application/json' else response.text  
        return {"error":True, "error_desc":f"Request failed with status code {response.status_code}: {error_info}"}  
  
  except Exception as e:  
    # Handle any exception that may occur  
    return {"error":True, "error_desc":f"An error occurred: {e}"}
```