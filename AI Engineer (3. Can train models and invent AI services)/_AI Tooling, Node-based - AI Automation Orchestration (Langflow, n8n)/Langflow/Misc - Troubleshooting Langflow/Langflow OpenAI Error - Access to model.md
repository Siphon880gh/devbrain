Error reads:
```
Error building Component OpenAl:
Error code: 403 - {'error': {'message':
'Project proj_****** does not have access to model gpt-4o',
'type': 'invalid_request_error', 'param': None,
'code': 'model_not_found'}}
```

![[Pasted image 20250211015200.png]]

Make sure to enable that model you'll be using.
[https://platform.openai.com/settings](https://platform.openai.com/settings)
![[Pasted image 20250210234531.png]]

If still fails, then select another model at the canvas component that you know have been enabled.