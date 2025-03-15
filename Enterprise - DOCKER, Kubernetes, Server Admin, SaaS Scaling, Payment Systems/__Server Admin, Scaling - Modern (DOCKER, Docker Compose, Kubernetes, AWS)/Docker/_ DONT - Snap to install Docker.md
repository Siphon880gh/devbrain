If you ran docker and it suggests to install the missing docker with snap install docker  - **DON'T**

Snap packages are sandboxed. This can cause issues with mounting volumes (-v option) because Snap Docker runs inside a restricted environment.

If you want the full, unrestricted Docker experience, it's best to install it regularly.

If you already had installed with snap, remove with: `sudo snap remove docker`. Then install Docker regularly.

---

OS saw this Snap recommendation on:
Ubuntu 22.04.5 LTS