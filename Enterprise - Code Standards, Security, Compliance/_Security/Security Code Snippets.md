
How to use: You can open persistent "Table of Contents"

---

#### PHP: Sanitize GET search param that gets fed into shell_exec to avoid os command injection, directory traversal, and local file inclusion:

```
$name = isset($_GET["name"]) ? $_GET["name"] : "";  
  
// Decode against encoded once/twice/thrice/etc:  
function recursiveUrldecode($input) {    
    $prev = '';    
    $current = $input;    
    
    // Decode until the input stops changing    
    while ($current !== $prev) {    
        $prev = $current;    
        $current = urldecode($current);    
    }    
    
    return $current;    
}  
$name = recursiveUrldecode($name);  
  
// Sanitize name input to prevent directory traversal and command injection  
$name = isset($_GET["name"]) ? $_GET["name"] : "";  
$name = trim($name); // Remove head and tail whitespaces  
$name = escapeshellarg($name); // Escape shell arguments  
  
// Convert to UTF-8 if not already  
if (!mb_check_encoding($name, 'UTF-8')) {  
    $name = mb_convert_encoding($name, 'UTF-8', 'auto');  
}  
// Normalize Unicode characters  
$name = Normalizer::normalize($name, Normalizer::FORM_C);  
  
// Remove any remaining control characters and normalize spaces  
$name = preg_replace('/[\x00-\x1F\x7F]/u', '', $name);  
$name = preg_replace('/\s+/u', ' ', $name);  
  
// Remove directory traversal patterns while preserving legitimate characters  
$name = preg_replace('/(?:\.\.\/|\.\.\\\|\.\/|\.\\\|\\|\/)/u', '', $name);  
  
// Escape for shell usage  
$name = escapeshellarg($name);  
  
$name = preg_replace('/[^a-zA-Z0-9\s,]/', '', $name); // Only allow alphanumeric, spaces and commas  
if (empty($name)) {  
    die("Invalid search term");  
}  
  
$opts = isset($_GET["checked"]) && gettype($_GET["checked"])==="array" ? $_GET["checked"] : [];
```

#### JS: Sanitize local filepath before fetch to avoid directory traversal and local file inclusion?

- Not necessary
- Fetch is the same thing as someone trying to access a directory or file by typing into the address bar and pressing enter. It's only a problem if the backend processes the path.
- But for completeness, a frontend JS sanitization is here:**

```
function sanitizeNameInput(name) {  
    if (typeof name !== 'string') return '';  
  
    // Trim whitespace  
    name = name.trim();  
  
    // Convert to UTF-8 and normalize Unicode (NFC is like PHP's Normalizer::FORM_C)  
    try {  
        name = name.normalize('NFC');  
    } catch (e) {  
        // Fallback or log error; malformed Unicode strings may cause this  
        name = '';  
    }  
  
    // Remove control characters (0x00-0x1F, 0x7F)  
    name = name.replace(/[\x00-\x1F\x7F]/g, '');  
  
    // Normalize internal whitespace  
    name = name.replace(/\s+/g, ' ');  
  
    // Remove directory traversal attempts  
    name = name.replace(/(\.\.\/|\.\/|\\|\/)/g, '');  
  
    // Remove shell-sensitive or dangerous characters (keep alphanumeric, space, comma)  
    name = name.replace(/[^a-zA-Z0-9 ,]/g, '');  
  
    // Final fallback  
    if (!name) {  
        throw new Error('Invalid search term');  
    }  
  
    return name;  
}
```


#### JS: Sanitize before rendering into HTML

```
/**  
 * Sanitizes input to prevent XSS attacks by escaping HTML special characters  
 * @param {string} str - The string to sanitize  
 * @returns {string} - The sanitized string  
 */  
function sanitize(str) {  
    if (typeof str !== 'string') return '';  
      
    return str  
        .replace(/&/g, '&amp;')  
        .replace(/</g, '&lt;')  
        .replace(/>/g, '&gt;')  
        .replace(/"/g, '&quot;')  
        .replace(/'/g, '&#39;');  
}
```

#### PHP: Before saving to server storage

```
$str = htmlspecialchars($str, ENT_QUOTES, 'UTF-8'), 0, 1000);  
$str = preg_replace('/[^a-zA-Z0-9-_]/', '', $str);
```

#### PHP: Validate json object

Echoing checkmarks to frontend fetch in order to render which checkmarks are ticked when user revisits the page. In case the persisting file has been compromised by a hacker (if from another server you don't own - this is a server or service for developers to save checkmarks), we check formatting:  

We expect the format of the json from the service to be json: `[{"selector":"0"}, {"selector":"2"}]`. In this example, the first and third checkboxes on the website will be checked (when you write render logic).

```
        $prepared["checkmarks"] = [];
    
        $checkmarkJobs = @file_get_contents("https://we-save-checkmarks.com/......./checkmarks.json");
        $checkmarkJobs = json_decode($checkmarkJobs, true);
        
        // Check formatting in case we-save-checkmarks is hacked or compromised
        for($i=0; $i<count($checkmarkJobs); $i++) {
            $checkmarkJob = $checkmarkJobs[$i];
            if(!is_numeric($checkmarkJob["selector"])) {
                throw new Exception("Not a number: " . $checkmarkJob["selector"]);
            }
        }

        $prepared["checkmarks"] = json_encode($checkmarkJobs);

// ...
echo json_encode($prepared);
```

Say if it's text that you're checking from external server that you don't own:
```
$textJob["comment"] = preg_match('/^[a-zA-Z0-9\s\']+$/', $textJob["selector"]) ? $textJob["selector"] : throw new Exception("Invalid selector: " . $textJob["selector"] . ". Only alphanumeric characters, spaces and apostrophes allowed.");
```

But let's say you're saving to this source that's internal (you own on your server), then definitely sanitize while validating format (not only validate format on frontend, because a hacker can POST directly to the endpoint once they figure it out).. and then you're less concerned about validating and sanitizing on reading (the previous example) although you still should do the above. Here's writing internally and you're validating and sanitizing:
```
    if(isset($_POST["checkmarks"])) {  
        $checkmarks = $_POST["checkmarks"];  
          
        // Validate checkmarks format  
        if (!is_array($checkmarks)) {  
            echo json_encode(["error" => "Invalid checkmarks format: must be an array"]);  
            exit;  
        }  
          
        foreach ($checkmarks as $checkmark) {  
            if (!is_array($checkmark) || !isset($checkmark['selector'])) {  
                echo json_encode(["error" => "Invalid checkmark format: each item must be an object with a selector property"]);  
                exit;  
            }  
            if(!is_numeric($checkmark['selector'])) {  
                echo json_encode(["error" => "Invalid checkmark format: selector must be a number"]);  
                exit;  
            }  
            // Escape the selector value to prevent XSS  
            // $checkmark['selector'] = htmlspecialchars($checkmark['selector'], ENT_QUOTES, 'UTF-8');  
        }  
          
        @file_put_contents("../data/checkmarks.json", json_encode($checkmarks));  
        echo json_encode(["post"=>"checkmarks"]);  
  
    }
```