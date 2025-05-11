
cURL is not only good for downloading files but for other purposes as well:
- scraping an entire website
- testing api end points

## Testing API End Points

### POST
```
curl -X POST <URL> -H "Content-Type: application/json" -d '{"key1":"value1", "key2":"value2"}' -i
```

^ To see the full response including the headers, we added the -i option

### GET
```
curl -X GET <URL>
```