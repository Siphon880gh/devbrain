

That R14 (“Memory quota exceeded”) is coming straight from your dyno running out of RAM—and the Hobby (or Standard-1X) dynos you’re on only get 512 MB of RAM. Your logs even show you’re at 845 MB (165% of quota), so Heroku is throttling/kill­ing your process.

![[Pasted image 20250620060141.png]]

You can upgrade the dyno or if you need more processing power, you can use AWS Lambda / Netlify functions / Vercel Function.