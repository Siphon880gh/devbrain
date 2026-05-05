Close and after close modal events

Placed it outside the document.ready function. When I placed within document.ready, It was not working:

```
$(document).on("hide.bs.modal", "#modal-force-mode", ()=> {
	alert("When closing");
});

$(document).on("hidden.bs.modal", "#modal-force-mode", ()=> {
	alert("After closing");
});
```
