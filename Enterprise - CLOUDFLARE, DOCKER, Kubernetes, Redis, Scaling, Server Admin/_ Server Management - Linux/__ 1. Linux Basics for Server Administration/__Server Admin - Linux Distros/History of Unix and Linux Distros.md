## FreeBSD - Unix like, but Linux distro
FreeBSD is actually a Unix-like operating system, not a Linux distribution. It is part of the BSD (Berkeley Software Distribution) family, which is separate from Linux, though they share some similarities. Both FreeBSD and Linux are Unix-like operating systems, but they have different lineages and are developed separately.

FreeBSD includes:
FreeBSD
TrueNAS
GhostBSD
NomadBSD
pfSense
OPNsense
MidnightBSD

rueNAS allows you to run VMs which are using the Bhyve hypervisor. 
Bhyve is a lightweight, native FreeBSD hypervisor that supports various guest operating systems like Linux, Windows, and FreeBSD.
 
## RHEL, CentOS, Yum

**RHEL** (Red Hat Enterprise Linux) is a commercially supported distribution developed by Red Hat. It is designed for enterprise environments, with a focus on stability, security, and long-term support. RHEL is not free to use; it requires a subscription that provides access to updates, support, and other benefits.

**CentOS** (Community ENTerprise Operating System), on the other hand, was originally a free and open-source clone of RHEL. It was built from the same source code as RHEL, with the Red Hat branding and trademarks removed. This made CentOS essentially a downstream derivative of RHEL, providing the same functionality without the cost, although without official support from Red Hat.

**Relationship Between RHEL and CentOS:**
Common Ancestry: CentOS was derived from the source code of RHEL. Red Hat is required to make the source code of RHEL available under the GPL (General Public License), and CentOS developers used this code to build CentOS, making it almost identical to RHEL.
CentOS Stream: Starting from late 2020, the CentOS project shifted its focus from being a direct clone of RHEL to a "rolling-release" model called CentOS Stream. CentOS Stream serves as the upstream (development branch) of RHEL, meaning that it now receives updates before they are included in RHEL. This is a significant change from its previous role as a downstream of RHEL.

**Summary:**
RHEL is the original, commercially supported distribution developed by Red Hat.
CentOS was derived from RHEL and was originally a free, community-supported version of it. However, with CentOS Stream, it now acts as an upstream development branch for RHEL.

So, while they share a common ancestry, CentOS was originally derived from RHEL, and they have since diverged, especially with the introduction of CentOS Stream.