
Docker can be used in many ways for many purposes involving VM and containerization. It can get overwhelming. So I recommend deep diving into the purposes you often need Docker for. So invest in the skill tree branches that benefits you. You may choose to master all skill tree branches. This document is **if you choose to master** all the important parts of Docker so you can use Docker for most cases.

Docker Challenges (go from top to bottom):
- At Docker Desktop or from your terminal, pull the image hello-world. Then see in the terminal the success message (You can access the terminal inside Docker Desktop)
- Create NodeJS app that at port 3003 will say “Hello”. Run this with Docker such that visiting localhots:3003 in the web browser will output “Hello”.
	- Hint: Dockerfile exposing the port and running the node script. Build image. Run container.

- Make Docker Compose (docker-compose.yml) that runs two slave servers at port 3000, 3001, and have the one master server at port 3000 to concatenate the slave servers’ responses “Hello” and “World”

- Test saving to mounted files work! Your full stack website is delivered by visiting localhost:3003 thanks to Docker, and it allows you to upload an image through an upload form. Upon uploading, you’ll see the uploaded file on your local machine at the mounted path

- Test Postgres locally or as a dependent image (Hint: [[Metabase BI - _PRIMER]] covers Postgres locally or as a dependent image for Metabase to work). Continuing from the upload form, have postgres saves to a table chronologically: the upload time and the upload path. You may test it’s been successful by going into postgres shell and selecting all rows. Learn postgres at [[PostgreSQL - _PRIMER]]