Titled: 
Sending additional data to push that appends through scrapped results at webhook

Optionally, you can receive custom headers to your callback if you use the `callback_headers` parameter. That is great for passing additional data for identification purposes at your side.

The format is the following: `HEADER-NAME:VALUE|HEADER-NAME2:VALUE2|etc.` And it must be encoded properly.

Example for headers and values `MY-ID 1234, some-other 4321`

```
&callback_headers=MY-ID%3A1234%7Csome-other%3A4321
```
Those headers will come back in the webhook post request.