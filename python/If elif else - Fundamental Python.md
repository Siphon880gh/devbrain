
```
    if request.is_json:
        data = request.get_json()
    elif request.form:
        data = request.form.to_dict()
    elif request.args:
        data = request.args.to_dict()
    else:
        data = request.data
    print(data)
```