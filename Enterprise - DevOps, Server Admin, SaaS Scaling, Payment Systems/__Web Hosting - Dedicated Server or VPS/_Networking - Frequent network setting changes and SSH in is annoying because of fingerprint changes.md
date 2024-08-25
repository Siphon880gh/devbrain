
\< I am changing the network settings a lot and also SSHing into the server from my local machine each time to confirm I didn't break the network and that the network settings applied. Each time, it says known_hosts fingerprint no longer matches, then I have to modify the known_hosts, which is very annoying. Can I ignore fingerprints for now?

\>
Yes, you can temporarily ignore SSH host key checking (fingerprints) if you're testing and frequently changing network configurations, which may cause that server's fingerprint to change. However, be aware that this reduces security, as SSH relies on host key verification to prevent man-in-the-middle attacks. Once you are done changing networking settings, you'll want to have your local computer pay attention to server fingerprint changes again (revert instructions at the bottom)

### Temporarily Disabling Host Key Checking:

You have two options:

1. **Ignore Host Key Checking (Insecure):**
   You can use the `-o StrictHostKeyChecking=no` and `-o UserKnownHostsFile=/dev/null` options with your `ssh` command to ignore the fingerprint checking:

   ```bash
   ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null user@your_vm_ip
   ```

   - **StrictHostKeyChecking=no**: This option prevents SSH from asking you to verify the host's fingerprint.
   - **UserKnownHostsFile=/dev/null**: This tells SSH not to store the host key in your `~/.ssh/known_hosts` file, effectively ignoring changes to the host key.

2. **Automate with SSH Config:**
   If you're frequently connecting to this host and want to avoid adding these options each time, you can configure this in your `~/.ssh/config` file:

   ```bash
   Host your_vm_ip_or_*
       StrictHostKeyChecking no
       UserKnownHostsFile /dev/null
   ```

   Replace `your_vm_ip` with the actual IP address of your VM. This configuration will apply every time you SSH into this particular host.

### Reverting Back:
Once your testing or network adjustments are complete, you should re-enable host key checking to ensure secure connections depending on which method you used:

- Remove the temporary options from your SSH command.
- If you edited the `~/.ssh/config` file, remove the corresponding entries.
- If fingerprints changed, you can remove the hosts from your `~/.ssh/known_hosts` or run `ssh-keygen -R your_vm_ip` which does it for you
