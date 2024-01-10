This is frontend only mocking of a fetch, likely to demonstrate a delay and a re-render for demonstration purposes

```
              // TODO: This is where ChatGPT api will be called
              function willFetchAiAPI() {
              // Mock fetch
              (new Promise((resolve, reject) => {
                setTimeout(() => {

                  const response = {
                    a:1,b:2
                  }
                  resolve(response);
                }, 2000);
              })).then(response => {
                console.log({response})

                document.querySelector(".result-a").classList.add("hidden");
                document.querySelector(".result-b").classList.remove("hidden");
                document.querySelector(".result-b").dispatchEvent(new Event('input'));
              });
              
			willFetchAiAPI();
```