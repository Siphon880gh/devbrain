
This mechanism is a prompt + context. 

Frontend calls backend PHP's api.php. Notice the function receives parameters *prompt* and *context*.

Example prompt is: Please sort these concepts from easiest to hardest to learn.
Example context  is: 
- Binary Search
- LIFO and FIFO
- Hashed tables


```
        function connectThenRender(prompt, context) {
            console.log(context);
            fetch("api.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
	                prompt,
                    context
                })
            }).then(response=>response.text())
            .then(resource=>{
                console.log({resource})
                document.querySelector(".result").innerHTML = '<pre>' + resource + '</pre>';
            })
        }
```


Backend api.php built to receive requests from frontend, send request to OpenAPI servers, receive request, then send request back to frontend
```
<?php
include('service/index.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get the raw POST data
    $rawData = file_get_contents('php://input');

    // Decode the JSON payload
    $decodedData = json_decode($rawData, true);

    // Check if the 'context' key exists in the decoded data
    if (isset($decodedData['prompt']) && isset($decodedData['context'])) {
        $prompt = $decodedData['prompt'];
        $context = $decodedData['context'];

        $response = getTextResponse($prompt, $context);
        
        echo $response;


    } else {
        echo "Context not found in request body.";
    }
} else {
    echo "Please send a POST request.";
}

?>
```

That above api.php includes this service layer: service/index.php
```
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Load environment variables from .env file
include('dotenv.php');
$dotenv = new DotEnv('./.env');
$dotenv->load();

// Required libraries
include('OpenAI.php');

$apiKey = getenv('OPENAI_API_KEY');
$openAIModel = "gpt-3.5-turbo";

$model = new OpenAI($apiKey, 0, $openAIModel);

/**
 * Get text response from model
 *
 * @param string $basePrompt
 * @param string $context
 * @return string
 */
function getTextResponse($prompt, $context) {
    global $model;

    try {
		$response = $model->call($prompt, $context);
        return $response;
    } catch (Exception $e) {
        error_log($e->getMessage());
    }
}

?>

```

Which for security reasons, have isolated the OpenAI API key with a dotenv.php:
```
<?php
class DotEnv {
    private $filePath;

    public function __construct($filePath) {
        $this->filePath = $filePath;
    }

    public function load() {
        if (!file_exists($this->filePath)) {
            return false;
        }

        $lines = file($this->filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);
            putenv("$name=$value");
        }
    }
}

function dotenv() {
    return new DotEnv(__DIR__ . '/.env');
}
?>

```

Which pulls OPENAI_API_KEY from .env at the project root.

That api.php also imports an OpenAI class that is the immediate point of entry to OpenAI's server:
```
<?php
class OpenAI {
    public $apiKey;
    public $temperature;
    public $model;

    public function __construct($apiKey, $temperature, $model) {
        $this->apiKey = $apiKey;
        $this->temperature = $temperature;
        $this->model = $model;
    }

    public function call($prompt, $context) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.openai.com/v1/chat/completions");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $this->apiKey",
            "Content-Type: application/json"
        ]);


        $postData = [
            "model" => "gpt-3.5-turbo",
            "messages" => [
                [
                    "role" => "system",
                    "content" => "You are a helpful assistant."
                ],
                [
                    "role" => "user",
                    "content" => "$prompt\n$context"
                ]
            ]
        ];
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));


        $response = curl_exec($ch);
        curl_close($ch);

        $decodedResponse = json_decode($response, true);

        // Old format of response
        // $text = isset($decodedResponse['choices'][0]['text']) 
        // ? $decodedResponse['choices'][0]['text'] 
        // : (isset($decodedResponse[0]) 
        //     ? $decodedResponse[0] 
        //     : (isset($decodedResponse['choices']) 
        //         ? $decodedResponse['choices'] 
        //         : "Key not found"));
    
        // return $text;

        // New format of response
        // $decodedResponse.choices[0].message.content
        $content = isset($decodedResponse['choices'][0]['message']['content']) 
        ? $decodedResponse['choices'][0]['message']['content'] 
        : (isset($decodedResponse[0]) 
            ? $decodedResponse[0] 
            : (isset($decodedResponse['choices']) 
                ? $decodedResponse['choices'] 
                : "Key not found"));

        return $content;
    }
}
?>

```