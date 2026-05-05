
For virtualization, it's not enough that the software (called hypervisor) is booted in before the kernel, and that the CPU supports it, but also the BIOS have it enabled

To check if nested virtualization, KVM, hardware virtualization, and paravirtualization are enabled in your BIOS or UEFI, you will need to access your system's BIOS/UEFI settings during the boot process. The exact steps to do this can vary depending on your motherboard or system manufacturer, but the general process is as follows:

1. **Restart your computer.**
2. **Enter BIOS/UEFI setup:** During the initial boot sequence, press the key required to enter the BIOS/UEFI setup. Common keys include `F2`, `F10`, `Del`, or `Esc`. The exact key is usually displayed briefly on the screen during startup or can be found in your system's manual.
3. **Navigate to the CPU or Advanced settings:** Once in the BIOS/UEFI setup, look for a section related to CPU configuration or advanced settings. This section might be labeled as `Advanced`, `CPU Configuration`, `Processor Settings`, or something similar.

4. **Check for Hardware Virtualization:**
   - Look for options related to hardware virtualization technology. These settings might be labeled as `Intel Virtualization Technology (VT-x)`, `AMD Virtualization (AMD-V)`, or simply `Virtualization Technology`.
   - **Enable Hardware Virtualization:** If the setting is disabled, enable it. This is usually required for other virtualization features to work.

5. **Check for KVM (Kernel-based Virtual Machine):**
   - Ensure that hardware virtualization is enabled, as KVM requires it.
   - There may not be a direct KVM setting in the BIOS/UEFI, as KVM is managed at the OS level, but enabling hardware virtualization is crucial.

6. **Check for Nested Virtualization:**
   - Within the CPU or advanced settings, look for options specifically related to nested virtualization. This might be labeled as `Nested Virtualization`, `Nested Paging`, `VT-d`, or similar.
   - **Enable Nested Virtualization:** If the setting is disabled, enable it.

7. **Check for Paravirtualization:**
   - Paravirtualization settings are less common in BIOS/UEFI and more often managed within the hypervisor or operating system.
   - Ensure that hardware virtualization is enabled, as it is a prerequisite for many paravirtualization technologies.

8. **Save and Exit:**
   - After making the necessary changes, save your changes and exit the BIOS/UEFI setup. This is usually done by pressing `F10`, but it may vary depending on your system.

### Accessing BIOS/UEFI via IPMI:

If your server or system supports IPMI (Intelligent Platform Management Interface), you can remotely access and manage your BIOS/UEFI settings. Here’s how:

1. **Connect to IPMI Interface:**
   - Use a web browser to access the IPMI interface by entering the IP address of the IPMI management port. This IP address is usually configured during initial system setup.

2. **Login to IPMI:**
   - Enter your login credentials. Default credentials are often provided by the manufacturer but should be changed for security purposes.

3. **Launch Remote Console:**
   - Look for an option to launch the remote console or virtual console. This option might be labeled as `Remote Control`, `iKVM`, `Console Redirection`, or something similar.

4. **Restart and Enter BIOS/UEFI Setup:**
   - From the remote console, restart the server. During the boot process, press the key required to enter the BIOS/UEFI setup (e.g., `F2`, `F10`, `Del`, `Esc`).

5. **Navigate and Configure Settings:**
   - Follow the same steps as mentioned above to navigate to the CPU or advanced settings and enable the necessary virtualization features.

6. **Save and Exit:**
   - After making the changes, save and exit the BIOS/UEFI setup through the remote console.
