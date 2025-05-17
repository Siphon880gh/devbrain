
Visiting [http://localhost:3200/](http://localhost:3200/) out of curiosity?

You'll get an:
```
Error: Unauthorized: Authorization header is missing
```


is coming from Botpress NLU server, which listens on localhost:3200 and expects API requests to include an Authorization header — usually a JWT or Botpress internal API token.

It’s meant to be accessed only by the **main Botpress server**, which acts as a gateway and attaches the required Authorization headers. You seeing this message when visiting directly in the web browser is expected.