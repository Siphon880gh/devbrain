
Requirements: You have your own webhost where you can create a server api endpoint that gets sent information from a Langflow flow run. We will implement timestamped logging of Langflow AI responses. Therefore, logging will be an external service at your own webhost.

---

Let's say that you want to log all Chat outputs to an external logger. You have created a php file or a NodeJS express endpoint or a Python Flask endpoint at https://yourcustomwebhotsing.com/api/logger/langflow-ID

And you can view the log file at https://yourcustomwebhotsing.com/api/logger/langflow-ID/log.txt

And it logs like this to a question about how tall Mount Everest is:
```
2025-02-13 05:52:05 - POST request - Data: "{\n    \"timestamp\": \"2025-02-13 07:52:05 UTC\",\n    \"sender\": \"Machine\",\n    \"sender_name\": \"AI\",\n    \"session_id\": \"2b2f54b0-228c-4c83-9160-237edc609311\",\n    \"text\": \"Mount Everest is approximately 8,848.86 meters (29,031.7 feet) tall, according to a 2020 survey conducted by China and Nepal. This height is widely recognized as the official elevation of the world's highest peak.\",\n    \"files\": [],\n    \"error\": false,\n    \"edit\": false,\n    \"properties\": {\n        \"text_color\": \"\",\n        \"background_color\": \"\",\n        \"edited\": false,\n        \"source\": {\n            \"id\": \"OpenAIModel-vUuHz\",\n            \"display_name\": \"OpenAI\",\n            \"source\": \"gpt-4o-mini\"\n        },\n        \"icon\": \"OpenAI\",\n        \"allow_markdown\": false,\n        \"positive_feedback\": null,\n        \"state\": \"complete\",\n        \"targets\": []\n    },\n    \"category\": \"message\",\n    \"content_blocks\": [],\n    \"id\": \"41e4d985-ccb4-498c-bbe1-c7008865229d\",\n    \"flow_id\": \"2b2f54b0-228c-4c83-9160-237edc609311\"\n}"
```


---

**Sneak Peak**

You will take a basic prompt without system message:

![[Pasted image 20250213010814.png]]

And then you will log the AI response to a text file at your own web host (more components):
![[Pasted image 20250213010407.png]]


---

Langflow's library of components has an API Request component that can perform operations like GET and POST. It can send GET url query parameters (which is inappropriate here because AI chat response that you're logging could get very long for query parameters). It can send POST body which is more appropriate.

Unfortunately with POST body, it accepts TableInput instead of a Message or Data directly from prior components. This would cause a lot more work. So we will customize the API Request component by going into its code and simplifying the code:

This is the original API Request component:
![[Pasted image 20250213004925.png]]

Hover over near the top so we can go into the component's code:
![[Pasted image 20250213004958.png]]

Replace with this code. Briefly here are changes we made to simplify the code and force Post body to directly accept data (of any structure) from a previous component:
- Removed cURL fields and implementations
- Body field type changed to DataInput and gottten rid of validation (allowing any Data schema)
- URLs and requests - only allow one url now and then simplified the async request
- No changes: Continue to allow query parameters
- No changes: Continue to refresh the component's fields based on selection such as GET or POST
- Please replace the code with this:
```
import asyncio  
import json  
import re  
import tempfile  
from datetime import datetime, timezone  
from pathlib import Path  
from typing import Any  
from urllib.parse import parse_qsl, urlencode, urlparse, urlunparse  
  
import aiofiles  
import aiofiles.os as aiofiles_os  
import httpx  
import validators  
  
from langflow.custom import Component  
from langflow.io import (  
    BoolInput,  
    DataInput,  
    DropdownInput,  
    FloatInput,  
    IntInput,  
    MessageTextInput,  
    MultilineInput,  
    Output,  
    StrInput,  
    TableInput,  
)  
from langflow.schema import Data  
from langflow.schema.dotdict import dotdict  
  
  
class APIRequestComponent(Component):  
    display_name = "API Request (Custom)"  
    description = "Make HTTP requests using URL. Modified so that POST body can accept Data directly from a prior component."  
    icon = "Globe"  
    name = "APIRequest"  
  
    default_keys = ["url", "method", "query_params"]  
  
    inputs = [  
        StrInput(  
            name="url",  
            display_name="URLs",  
            list=False,  
            info="Enter one or more URLs, separated by commas.",  
            advanced=False,  
            tool_mode=True,  
        ),  
        DropdownInput(  
            name="method",  
            display_name="Method",  
            options=["GET", "POST", "PATCH", "PUT", "DELETE"],  
            info="The HTTP method to use.",  
            real_time_refresh=True,  
        ),  
        DataInput(  
            name="query_params",  
            display_name="Query Parameters",  
            info="The query parameters to append to the URL.",  
            advanced=True,  
        ),  
        DataInput(  
            name="body",  
            display_name="Body",  
            info="The body to send with the request as a dictionary (for POST, PATCH, PUT).",  
            advanced=True,  
        ),  
        TableInput(  
            name="headers",  
            display_name="Headers",  
            info="The headers to send with the request as a dictionary.",  
            table_schema=[  
                {  
                    "name": "key",  
                    "display_name": "Header",  
                    "type": "str",  
                    "description": "Header name",  
                },  
                {  
                    "name": "value",  
                    "display_name": "Value",  
                    "type": "str",  
                    "description": "Header value",  
                },  
            ],  
            value=[],  
            advanced=True,  
            input_types=["Data"],  
        ),  
        IntInput(  
            name="timeout",  
            display_name="Timeout",  
            value=5,  
            info="The timeout to use for the request.",  
            advanced=True,  
        ),  
        BoolInput(  
            name="follow_redirects",  
            display_name="Follow Redirects",  
            value=True,  
            info="Whether to follow http redirects.",  
            advanced=True,  
        ),  
        BoolInput(  
            name="save_to_file",  
            display_name="Save to File",  
            value=False,  
            info="Save the API response to a temporary file",  
            advanced=True,  
        ),  
        BoolInput(  
            name="include_httpx_metadata",  
            display_name="Include HTTPx Metadata",  
            value=False,  
            info=(  
                "Include properties such as headers, status_code, response_headers, "  
                "and redirection_history in the output."  
            ),  
            advanced=True,  
        ),  
    ]  
  
    outputs = [  
        Output(display_name="Data", name="data", method="make_requests"),  
    ]  
  
    def _parse_json_value(self, value: Any) -> Any:  
        """Parse a value that might be a JSON string."""  
        if not isinstance(value, str):  
            return value  
  
        try:  
            parsed = json.loads(value)  
        except json.JSONDecodeError:  
            return value  
        else:  
            return parsed  
  
    def _process_body(self, body: Any) -> dict:  
        """Process the body input into a valid dictionary.  
  
        Args:  
            body: The body to process, can be dict, str, or list  
        Returns:  
            Processed dictionary  
        """  
        if body is None:  
            return {}  
        if isinstance(body, dict):  
            return self._process_dict_body(body)  
        if isinstance(body, str):  
            return self._process_string_body(body)  
        if isinstance(body, list):  
            return self._process_list_body(body)  
  
        return {}  
  
    def _process_dict_body(self, body: dict) -> dict:  
        """Process dictionary body by parsing JSON values."""  
        return {k: self._parse_json_value(v) for k, v in body.items()}  
  
    def _process_string_body(self, body: str) -> dict:  
        """Process string body by attempting JSON parse."""  
        try:  
            return self._process_body(json.loads(body))  
        except json.JSONDecodeError:  
            return {"data": body}  
  
    def _process_list_body(self, body: list) -> dict:  
        """Process list body by converting to key-value dictionary."""  
        processed_dict = {}  
  
        try:  
            for item in body:  
                if not self._is_valid_key_value_item(item):  
                    continue  
  
                key = item["key"]  
                value = self._parse_json_value(item["value"])  
                processed_dict[key] = value  
  
        except (KeyError, TypeError, ValueError) as e:  
            self.log(f"Failed to process body list: {e}")  
            return {}  # Return empty dictionary instead of None  
  
        return processed_dict  
  
    def _is_valid_key_value_item(self, item: Any) -> bool:  
        """Check if an item is a valid key-value dictionary."""  
        return isinstance(item, dict) and "key" in item and "value" in item  
  
    def update_build_config(self, build_config: dotdict, field_value: Any, field_name: str | None = None) -> dotdict:  
        if field_name == "method":  
            build_config = self._update_method_fields(build_config, field_value)  
        return build_config  
  
    def _update_method_fields(self, build_config: dotdict, method: str) -> dotdict:  
        common_fields = [  
            "urls",  
            "method"  
        ]  
  
        always_advanced_fields = [  
            "body",  
            "headers",  
            "timeout",  
            "follow_redirects",  
            "save_to_file",  
            "include_httpx_metadata",  
        ]  
  
        body_fields = ["body"]  
  
        for field in self.inputs:  
            field_name = field.name  
            field_config = build_config.get(field_name)  
            if isinstance(field_config, dict):  
                if field_name in common_fields:  
                    field_config["advanced"] = False  
                elif field_name in body_fields:  
                    field_config["advanced"] = method not in ["POST", "PUT", "PATCH"]  
                elif field_name in always_advanced_fields:  
                    field_config["advanced"] = True  
                else:  
                    field_config["advanced"] = True  
            else:  
                self.log(f"Expected dict for build_config[{field_name}], got {type(field_config).__name__}")  
  
        return build_config  
  
    async def make_request(  
        self,  
        client: httpx.AsyncClient,  
        method: str,  
        url: str,  
        headers: dict | None = None,  
        body: Any = None,  
        timeout: int = 5,  
        *,  
        follow_redirects: bool = True,  
        save_to_file: bool = False,  
        include_httpx_metadata: bool = False,  
    ) -> Data:  
        method = method.upper()  
        if method not in {"GET", "POST", "PATCH", "PUT", "DELETE"}:  
            msg = f"Unsupported method: {method}"  
            raise ValueError(msg)  
  
        # Process body using the new helper method  
        processed_body = self._process_body(body)  
  
        try:  
            response = await client.request(  
                method,  
                url,  
                headers=headers,  
                json=processed_body,  
                timeout=timeout,  
                follow_redirects=follow_redirects,  
            )  
  
            redirection_history = [  
                {  
                    "url": redirect.headers.get("Location", str(redirect.url)),  
                    "status_code": redirect.status_code,  
                }  
                for redirect in response.history  
            ]  
  
            is_binary, file_path = await self._response_info(response, with_file_path=save_to_file)  
            response_headers = self._headers_to_dict(response.headers)  
  
            metadata: dict[str, Any] = {  
                "source": url,  
            }  
  
            if save_to_file:  
                mode = "wb" if is_binary else "w"  
                encoding = response.encoding if mode == "w" else None  
                if file_path:  
                    # Ensure parent directory exists  
                    await aiofiles_os.makedirs(file_path.parent, exist_ok=True)  
                    if is_binary:  
                        async with aiofiles.open(file_path, "wb") as f:  
                            await f.write(response.content)  
                            await f.flush()  
                    else:  
                        async with aiofiles.open(file_path, "w", encoding=encoding) as f:  
                            await f.write(response.text)  
                            await f.flush()  
                    metadata["file_path"] = str(file_path)  
  
                if include_httpx_metadata:  
                    metadata.update(  
                        {  
                            "headers": headers,  
                            "status_code": response.status_code,  
                            "response_headers": response_headers,  
                            **({"redirection_history": redirection_history} if redirection_history else {}),  
                        }  
                    )  
                return Data(data=metadata)  
  
            if is_binary:  
                result = response.content  
            else:  
                try:  
                    result = response.json()  
                except json.JSONDecodeError:  
                    self.log("Failed to decode JSON response")  
                    result = response.text.encode("utf-8")  
  
            metadata.update({"result": result})  
  
            if include_httpx_metadata:  
                metadata.update(  
                    {  
                        "headers": headers,  
                        "status_code": response.status_code,  
                        "response_headers": response_headers,  
                        **({"redirection_history": redirection_history} if redirection_history else {}),  
                    }  
                )  
            return Data(data=metadata)  
        except httpx.TimeoutException:  
            return Data(  
                data={  
                    "source": url,  
                    "headers": headers,  
                    "status_code": 408,  
                    "error": "Request timed out",  
                },  
            )  
        except Exception as exc:  # noqa: BLE001  
            self.log(f"Error making request to {url}")  
            return Data(  
                data={  
                    "source": url,  
                    "headers": headers,  
                    "status_code": 500,  
                    "error": str(exc),  
                    **({"redirection_history": redirection_history} if redirection_history else {}),  
                },  
            )  
  
    def add_query_params(self, url: str, params: dict) -> str:  
        url_parts = list(urlparse(url))  
        query = dict(parse_qsl(url_parts[4]))  
        query.update(params)  
        url_parts[4] = urlencode(query)  
        return urlunparse(url_parts)  
  
  
    async def make_request(  
        self, client: httpx.AsyncClient, method: str, url: str, headers: dict, body: Any, timeout: int, follow_redirects: bool  
    ) -> dict:  
        try:  
            response = await client.request(  
                method, url, headers=headers, json=str(body), timeout=timeout, follow_redirects=follow_redirects  
            )  
            return {"status_code": response.status_code, "response": response.json() if response.headers.get("Content-Type") == "application/json" else response.text}  
        except httpx.TimeoutException:  
            return {"error": "Request timed out"}  
        except Exception as exc:  
            return {"error": str(exc)}  
  
    async def make_requests(self) -> dict:  
        method = self.method.upper()  
        url = self.url.strip() if isinstance(self.url, str) else self.url[0].strip()  
        headers = {h["key"]: h["value"] for h in self.headers} if self.headers else {}  
        body = self.body  # Directly sending the body as a string  
        timeout = self.timeout  
        follow_redirects = self.follow_redirects  
  
        if not validators.url(url):  
            raise ValueError(f"Invalid URL provided: {url}")  
  
        if isinstance(self.query_params, str):  
            query_params = dict(parse_qsl(self.query_params))  
        else:  
            query_params = self.query_params.data if self.query_params else {}  
        url = self.add_query_params(url, query_params)  
  
        async with httpx.AsyncClient() as client:  
            result = await self.make_request(client, method, url, headers, body, timeout, follow_redirects)  
        return result
```

Your resulting API Request component is now:
![[Pasted image 20250213005352.png]]

---

At the server side, implement your endpoint to receive any json or string in the POST request body and log it to a `langflow.txt`. PHP would be the quickest to implement if you have a PHP server.

[https://wengindustries.com/test_langflow/index.php](https://wengindustries.com/test_langflow/index.php)
```
<?php  
    // Define the log file path  
    $logFile = 'langflow.txt';  
  
    // Get the current timestamp  
    $timestamp = date('Y-m-d H:i:s');  
  
    // Check if the request method is GET or POST  
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {  
        // Log the GET request  
        file_put_contents($logFile, "$timestamp - GET request\n", FILE_APPEND);  
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {  
        // Check if the content type is JSON  
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';  
        if (stripos($contentType, 'application/json') !== false) {  
            // Read the raw input  
            $rawData = file_get_contents('php://input');  
            $postData = json_decode($rawData, true);  
            $postData = json_encode($postData); // Re-encode to ensure it's a string  
        } else {  
            // Handle form data  
            $postData = json_encode($_POST);  
        }  
        // Log the POST request with data  
        file_put_contents($logFile, "$timestamp - POST request - Data: $postData\n", FILE_APPEND);  
    }  
    $arr = array(  
        "message" => "Logged to langflow.txt",  
        "url" => $_SERVER['REQUEST_URI']  
    );  
    echo json_encode($arr);  
?>
```

Then logs will be viewable at:
[https://wengindustries.com/test_langflow/langflow.txt](https://wengindustries.com/test_langflow/langflow.txt)

It's suggested you test that the external logging service actually works.

Using Insomnia or Postman (or fetch in Chrome DevTools console), let's use Postman:
![[Pasted image 20250213005726.png]]

![[Pasted image 20250213010327.png]]

Both form data and raw json works. If you're implementing yourself, what you need to work is raw json (form data isn't what Langflow's API Request will send).

Visiting langflow.txt will show (bottom two are the relevant logs):
![[Pasted image 20250213010210.png]]

Once you sure it works, proceed:

---

Let's test that your Langflow can send information to an external api endpoint

At Chat Input, make sure to ask a generic question, eg. `How tall is Mt Everest?`

Note where there's a "Chat Output", it can send the AI prompt response to other components.

**Let's create this workflow**
Here Chat Output sends a `Message` type to "Message to Data" component
The "Message to Data" component converts the Message into a `Data` type that's more suitable.
That `Data` is sent to the custom "API Request"'s POST Body:
![[Pasted image 20250213010407.png]]

Click Play button on API Request component. If you visit the log text file, you should see the new entry.

The log could look like:
```
2025-02-13 05:34:35 - GET request  
2025-02-13 05:37:55 - POST request - Data: []  
2025-02-13 05:39:09 - POST request - Data: {"data":"1","data2":"2"}  
2025-02-13 05:39:09 - POST request - Data: {"data":"1","data2":"2"}  
2025-02-13 05:52:05 - POST request - Data: "{\n    \"timestamp\": \"2025-02-13 07:52:05 UTC\",\n    \"sender\": \"Machine\",\n    \"sender_name\": \"AI\",\n    \"session_id\": \"2b2f54b0-228c-4c83-9160-237edc609311\",\n    \"text\": \"Mount Everest is approximately 8,848.86 meters (29,031.7 feet) tall, according to a 2020 survey conducted by China and Nepal. This height is widely recognized as the official elevation of the world's highest peak.\",\n    \"files\": [],\n    \"error\": false,\n    \"edit\": false,\n    \"properties\": {\n        \"text_color\": \"\",\n        \"background_color\": \"\",\n        \"edited\": false,\n        \"source\": {\n            \"id\": \"OpenAIModel-vUuHz\",\n            \"display_name\": \"OpenAI\",\n            \"source\": \"gpt-4o-mini\"\n        },\n        \"icon\": \"OpenAI\",\n        \"allow_markdown\": false,\n        \"positive_feedback\": null,\n        \"state\": \"complete\",\n        \"targets\": []\n    },\n    \"category\": \"message\",\n    \"content_blocks\": [],\n    \"id\": \"41e4d985-ccb4-498c-bbe1-c7008865229d\",\n    \"flow_id\": \"2b2f54b0-228c-4c83-9160-237edc609311\"\n}"
```

**Congratulations!** You've now successfully logged your AI responses to a text file at your own webhost separate from LangFlow! This means your Langflow can send api requests to external endpoints

---

**Discussion**

Chat Output’s message out port when clicked:
![[Pasted image 20250213011259.png]]

And you can expand the AI response by clicking the text value:
![[Pasted image 20250213011305.png]]

Message to Data out port when clicked will look exactly identical. There is no information changed. However, the type is now Data instead of Message. This means literally every column is information your next component can use (rather than it just being displayed information for the Langflow user - you):
![[Pasted image 20250213011259.png]]

At the next connected component, when you click API Request (Custom)’s Data out port, you’ll see what the PHP or api endpoint echoed back:
![[Pasted image 20250213011416.png]]


