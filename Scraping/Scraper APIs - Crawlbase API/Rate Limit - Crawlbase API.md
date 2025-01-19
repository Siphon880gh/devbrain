The API is rate limited to a maximum of 20 requests per second, per token (rate limit can be increased upon request).

This means that you can send up to 20 requests every second, which means around 51 million requests per month, regardless of the number of threads they use.

The API will respond with 429 status code when the rate limit is exceeded.
