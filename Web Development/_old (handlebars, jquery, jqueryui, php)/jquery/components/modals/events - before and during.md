Before and during open modal events

Placed it outside the document.ready function. When I placed within document.ready, It was not working:

            $(document).on("show.bs.modal", "#modal-force-mode", ()=> {
                alert("b4 shown");
            });

            $(document).on("shown.bs.modal", "#modal-force-mode", ()=> {
                alert("b4 shown");
            });
