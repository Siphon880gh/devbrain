
This mechanism is a prompt + context. 

Frontend calls backend PHP's api.php. Notice the function receives a parameter *context*

```

        function connectThenRender(context) {
            console.log(context);
            fetch("api.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
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
    if (isset($decodedData['context'])) {
        $context = $decodedData['context'];


        $response = getTextResponse("Please explain this concept like I'm 13 years old.", $context);
        
        echo $response;


    } else {
        echo "Context not found in request body.";
    }
} else {
    echo "Please send a POST request.";
}

?>
```

The api.php includes this service layer: service/index.php
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
function getTextResponse($basePrompt, $context) {
    global $model;

    $defaultQuestion = "Write me an explanation.";
    $finalBasePrompt = $basePrompt ? $basePrompt : $defaultQuestion;

    try {
        $response = $model->call($finalBasePrompt . "\n" . $context);
        //var_dump($response);
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