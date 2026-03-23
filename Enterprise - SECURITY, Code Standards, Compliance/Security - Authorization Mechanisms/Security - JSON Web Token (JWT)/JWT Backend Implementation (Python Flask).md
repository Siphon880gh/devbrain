Note JWT can be implemented in any language.

Use this boilerplate for Python:
```
import base64  
import hmac  
import hashlib  
import json  
import time  
  
SECRET_KEY = "your-very-secure-secret-key"  
  
def base64_url_encode(data):  
    """Encodes data to Base64 URL-safe format."""  
    return base64.urlsafe_b64encode(data).rstrip(b"=").decode('utf-8')  
  
def base64_url_decode(data):  
    """Decodes Base64 URL-safe data."""  
    padding = '=' * (-len(data) % 4)  
    return base64.urlsafe_b64decode(data + padding)  
  
def generate_jwt(payload, secret):  
    """Generates a JSON Web Token."""  
    header = {"alg": "HS256", "typ": "JWT"}  
    header_encoded = base64_url_encode(json.dumps(header).encode('utf-8'))  
    payload_encoded = base64_url_encode(json.dumps(payload).encode('utf-8'))  
    signature = hmac.new(  
        secret.encode('utf-8'),  
        f"{header_encoded}.{payload_encoded}".encode('utf-8'),  
        hashlib.sha256  
    ).digest()  
    signature_encoded = base64_url_encode(signature)  
    return f"{header_encoded}.{payload_encoded}.{signature_encoded}"  
  
def decode_jwt(token, secret):  
    """Decodes and verifies a JSON Web Token."""  
    try:  
        header_encoded, payload_encoded, signature_encoded = token.split(".")  
        signature = hmac.new(  
            secret.encode('utf-8'),  
            f"{header_encoded}.{payload_encoded}".encode('utf-8'),  
            hashlib.sha256  
        ).digest()  
        valid_signature = base64_url_encode(signature)  
        if not hmac.compare_digest(valid_signature, signature_encoded):  
            return {"error": "Invalid token"}  
        payload = json.loads(base64_url_decode(payload_encoded).decode('utf-8'))  
        if "exp" in payload and time.time() > payload["exp"]:  
            return {"error": "Token has expired"}  
        return payload  
    except Exception as e:  
        return {"error": f"Invalid token structure: {e}"}  
  
print("TESTING Tokens")  
  
# Setup  
user_id = 12345  
# expiration = int(time.time()) + 30 * 24 * 60 * 60  # 30 days from now  
expiration = int(time.time()) + 3 # 3 seconds from now  
payload = {"user_id": user_id, "exp": expiration}  
  
# Generating  
token = generate_jwt(payload, SECRET_KEY)  
print("Generated Token:", token)  
  
# Decoding  
decoded = decode_jwt(token, SECRET_KEY)  
if "error" in decoded:  
    print(decoded["error"])  
else:  
    print("Decoded Payload:", decoded)  
  
  
print("Token created to expire in 3 seconds. Waiting 4 seconds to test failure of the token")  
time.sleep(4)  
print("EXPECT fail token")  
decoded = decode_jwt(token, SECRET_KEY)  
if "error" in decoded:  
    print(decoded["error"])  
else:  
    print("Decoded Payload:", decoded)
```