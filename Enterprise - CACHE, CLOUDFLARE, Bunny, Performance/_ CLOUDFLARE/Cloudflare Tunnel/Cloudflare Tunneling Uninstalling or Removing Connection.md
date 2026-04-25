The clean way to shut down and remove a Cloudflare Tunnel is to first identify the tunnel, then check for active connections, then clean up anything left behind, and finally delete it. 

Start with `cloudflared tunnel list` to get the tunnel ID. 

After that, run `cloudflared tunnel info <tunnel-id>` to see whether there were still any active connections. If Cloudflare still sees a connector or replica attached, the tunnel may not delete cleanly yet. 

Run `cloudflared tunnel cleanup <tunnel-id>` for all connections. 

Once cleanup is done, `cloudflared tunnel delete <tunnel-id>` removes the tunnel itself. 

Then confirm the tunnel is removed on the server side by running `cloudflared tunnel list`

If needed (no other tunnels needed), you can disable the cloudflare daemon with `sudo systemctl disable cloudflared` 

How about at cloudflare.com's side? Cloudflare removes the tunnel from their side too when you run the delete subcommand. But double check just in case. You can easily find the tunnel after selecting a domain by going to search and searching for Tunnel:
![[Pasted image 20260415061953.png]]
