## What are subnet masks, CIDR, etc

Most people know about **public IP addresses**. But when it comes to devices in the same company, they won't all use public IP addresses.

Notice these settings:

Public IP address
Device IP Addresses
Subnet mask

CIDR Notation is important. See CIDR in setting an Azure Virtual Network:
![](loJLi6D.png)


For example, in a private network (like a home or office network), you might use subnetting to divide the network into smaller parts for security, performance, or organizational reasons. Each subnet would have its own range of IP addresses, defined by the subnet mask, but these are typically private IP addresses, not public ones.

Take for example this address for two devices:
192.168.1.1
192.168.1.2

If the subset mask settings for that network is CIDR /25 or 255.255.255.128 there are two groups of device IP addresses. These groups are called subnets. Think of a network that's subdivided. So the two ranges are for **subnet mask** 255.255.255.128:
- 192.168.0 - 192.168.127
- 192.168.128 - 192.168.255

Why 255? Why 128? The subnet masks' 255 represents 11111111 binary which are the possible values that are designated as network values. The last octet in a subnet mask when referring to IPv4 addresses, usually determines how many subnets and how many possible assignable IP addresses to private devices per subnet. Sometimes it could be the last two octets. That last octet is usually 0, or 128, or 192, 244, 240, 248, 252, 254, 255 because that's how many possible division of the network to different groups of devices (aka subnets)

Here's an alternate scheme where it's the last two octets that represent subnetting (subdividing the network):
- **Network Setup**: A larger network might use a broader range of IP addresses.
- **IP Address**: `10.20.5.32`
- **Subnet Mask**: `255.255.0.0`
- **Explanation**: Here, the subnet mask `255.255.0.0` indicates that the first two octets (10.20) determine the network segment, while the last two (5.32) are for individual devices. Any device with an IP address from `10.20.0.1` to `10.20.255.254` would be on the same subnet.

With two subnets, for organizational purposes you can have devices and printers on first floor assigned to 192.168.1 - 192.168.126 and devices and printers on second floor assigned to 192.168.129 - 192.168.254. Then when managing them you can think of the two subnets for IP address 255.255.255.128 as two floors.

Notice that for first subnet, you can assign devices to these ip addresses 192.168.1 - 192.168.126. **The first two addresses of a subnet is not assigned to devices**: 192.168.0, 192.168.127 cannot be assigned. The first address is the network address and the final address is the broadcast address
- The **network address** identifies the network
- The **broadcast address** allows communication with all devices within that network.


Further delving into the Subnet mask. The IP address is made of octets (eg. 192.168.1.10 are four octets). From the IP address and Subnet mask, you can determine which parts determine the network and which part is for device/network/broadcast. See standard home router setup:

- **Network Setup**: A standard home router often uses the IP range `192.168.1.0` to `192.168.1.255`.
- **IP Address**: `192.168.1.10`
- **Subnet Mask**: `255.255.255.0`
- **Explanation**: The subnet mask `255.255.255.0` means the first three octets (255.255.255) are the network part, and the last octet (0) is for host addresses. In this case, any device with an IP address from `192.168.1.1` to `192.168.1.254` is part of the same subnet.

Because of the range of the subunit you can have 254 possible devices assigned each with addresses `192.168.1.1` to `192.168.1.254`.

When it comes to the nuances of whether the router device is 192.168.1.0: It is not.
- **192.168.1.0**: This address is the network address for the subnet `192.168.1.0/24`. In IP networking, the network address is used to identify the subnet itself and cannot be assigned to any individual device, including the router. It signifies the start of the IP address range for devices on that network.
- Routers are often assigned the first or last usable IP address within the subnet, such as `192.168.1.1` or `192.168.1.254`, though the default address can vary depending on the manufacturer.
- Btw, visiting the router device's IP for most manufacturers will open the router's web interface that lets you configure settings such as Wi-Fi passwords, network management, and security features.

Here is a table of subnet mask, and consequently how many subnets (groups of devices), and their possible device IP addresses / network address / broadcast address:

| # | Subnet Mask       | CIDR Notation | Possible Subnets | Addresses per Subnet | Example Network Addresses                     | Example Broadcast Addresses                      | Example Host Addresses (Ranges)                      |
|---|-------------------|---------------|------------------|----------------------|-----------------------------------------------|-------------------------------------------------|-----------------------------------------------------|
| 1 | 255.255.255.0     | /24           | 1                | 256                  | 192.168.1.0                                  | 192.168.1.255                                   | 192.168.1.1 - 192.168.1.254                         |
| 2 | 255.255.255.128   | /25           | 2                | 128                  | 192.168.1.0, 192.168.1.128                    | 192.168.1.127, 192.168.1.255                     | 192.168.1.1 - 192.168.1.126, 192.168.1.129 - 192.168.1.254 |
| 3 | 255.255.255.192   | /26           | 4                | 64                   | 192.168.1.0, 192.168.1.64, 192.168.1.128, 192.168.1.192 | 192.168.1.63, 192.168.1.127, 192.168.1.191, 192.168.1.255 | 192.168.1.1 - 192.168.1.62, 192.168.1.65 - 192.168.1.126, 192.168.1.129 - 192.168.1.190, 192.168.1.193 - 192.168.1.254 |
| 4 | 255.255.255.224   | /27           | 8                | 32                   | 192.168.1.0, 192.168.1.32, 192.168.1.64, 192.168.1.96, 192.168.1.128, 192.168.1.160, 192.168.1.192, 192.168.1.224 | 192.168.1.31, 192.168.1.63, 192.168.1.95, 192.168.1.127, 192.168.1.159, 192.168.1.191, 192.168.1.223, 192.168.1.255 | 192.168.1.1 - 192.168.1.30, 192.168.1.33 - 192.168.1.62, ..., 192.168.1.225 - 192.168.1.254 |
| 5 | 255.255.255.240   | /28           | 16               | 16                   | 192.168.1.0, 192.168.1.16, 192.168.1.32, ..., 192.168.1.240 | 192.168.1.15, 192.168.1.31, 192.168.1.47, ..., 192.168.1.255 | 192.168.1.1 - 192.168.1.14, 192.168.1.17 - 192.168.1.30, ..., 192.168.1.241 - 192.168.1.254 |
| 6 | 255.255.255.248   | /29           | 32               | 8                    | 192.168.1.0, 192.168.1.8, 192.168.1.16, ..., 192.168.1.248 | 192.168.1.7, 192.168.1.15, 192.168.1.23, ..., 192.168.1.255 | 192.168.1.1 - 192.168.1.6, 192.168.1.9 - 192.168.1.14, ..., 192.168.1.249 - 192.168.1.254 |

---

## How CIDR calculated:


- The subnet mask `255.255.255.192` is associated to /26 CIDR.
- Why? Subnet mask's binary equivalent is `11111111.11111111.11111111.11000000`.
- The `/26` CIDR notation indicates that 26 bits are used for the network portion, leaving 6 bits for host addressing.

![](WaUdRdY.png)
https://www.rapidtables.com/convert/number/decimal-to-binary.html

^ You do not choose "Octal" as the conversion from. You choose "Decimal".

---

## How subnet addresses are calculated:

Back to the subnet mask: That last octet is usually 0, or 128, or 192, 244, 240, 248, 252, 254, 255 because that's how many possible division of the network to different groups of devices (aka subnets)

### 255.255.255.128 Calculations
Let's dive deep into how the subnet mask `255.255.255.128` divides a network and how the bits determine the number of possible addresses. We're working within the context of a Class C network, where the subnet mask `255.255.255.128` is also represented in CIDR notation as `/25`.

#### Understanding the Subnet Mask: `255.255.255.128`

- **Binary Representation**: `11111111.11111111.11111111.10000000`
- **CIDR Notation**: `/25` indicates that 25 bits are designated for the network portion, with 7 bits left for host addresses.

#### Network and Host Portions:

1. **Fixed Network Portion**: The first three octets (`255.255.255`) are fully set to `1` in binary (`11111111.11111111.11111111`), marking the network section. The network part is constant across all IP addresses within this subnet.
    
2. **Subnetting with the Fourth Octet**: The fourth octet starts with a `1` (binary `10000000`), adding 1 bit to the network portion from the previous standard `/24` or `255.255.255.0` subnet mask. This leaves 7 bits for defining host addresses within each subnet.
    

#### Calculating Address Range Based on Bits:

- **7 Host Bits**: The remaining 7 bits in the last octet are used to determine host addresses. With 7 bits, the number of possible combinations is 2727.
    
- **Calculating 2727**:
    
    - 27=12827=128 possible values.
    - These values range from `0` to `127` for the first subnet, and `128` to `255` for the second, based on the binary representation of the last octet.

#### Breakdown of Possible Values:

- **For Host Addressing**:
    - Since one of the 128 values in each subnet is reserved for the network address (all host bits `0`) and one for the broadcast address (all host bits `1`), the actual number of usable host addresses in each subnet is 128−2=126128−2=126.

#### Subnet Address Range:

- **First Subnet**:
    
    - **Network Address**: `0` in the last octet (`192.168.1.0`).
    - **Broadcast Address**: `127` in the last octet (`192.168.1.127`).
    - **Usable Host Addresses**: From `192.168.1.1` to `192.168.1.126`.
- **Second Subnet**:
    
    - **Network Address**: `128` in the last octet (`192.168.1.128`).
    - **Broadcast Address**: `255` in the last octet (`192.168.1.255`).
    - **Usable Host Addresses**: From `192.168.1.129` to `192.168.1.254`.


### 255.255.255.192 Calculations

Certainly! Let's dive into the subnet mask `255.255.255.192` and its implications for network division and host allocation. This subnet mask is also represented in CIDR notation as `/26`, indicating more subdivision within a Class C network.

#### Understanding the Subnet Mask: `255.255.255.192`

- **Binary Representation**: `11111111.11111111.11111111.11000000`
- **CIDR Notation**: `/26` means that 26 bits are designated for the network portion, leaving 6 bits for host addresses.

#### Network and Host Portions:

1. **Network Portion**: The first three octets (`255.255.255`) are fully set (`11111111.11111111.11111111` in binary), indicating the network part. This is consistent across all IP addresses within this subnet range.

2. **Subnetting with the Fourth Octet**: The fourth octet includes two `1`s at the beginning (`11000000`), incorporating an additional bit into the network portion compared to the `/25` subnet mask, leaving 6 bits for host addressing within each subnet.

#### Calculating Address Range Based on Bits:

- **6 Host Bits**: With 6 bits available for defining host addresses, the number of possible combinations is \(2^6\).

- **Calculating \(2^6\)**: 
  - \(2^6 = 64\) possible values.
  - These 64 values represent the total number of addresses in each subnet, including one for the network address and one for the broadcast address.

#### Breakdown of Possible Values:

- **For Host Addressing**:
  - With one of the 64 values being the network address (where all host bits are `0`) and another being the broadcast address (where all host bits are `1`), the actual number of usable host addresses in each subnet is \(64 - 2 = 62\).

#### Subnet Address Range:

- **Subnets Created**:
  - The `/26` subnet mask divides the Class C address space into 4 subnets, each with 64 addresses, based on the 2 bits added to the network portion of the last octet.

- **Example Subnet Address Ranges**:
  - **First Subnet**:
    - **Network Address**: `192.168.1.0` (last octet `00000000`).
    - **Broadcast Address**: `192.168.1.63` (last octet `00111111`).
    - **Usable Host Addresses**: From `192.168.1.1` to `192.168.1.62`.
  - **Second Subnet**:
    - **Network Address**: `192.168.1.64` (last octet `01000000`).
    - **Broadcast Address**: `192.168.1.127` (last octet `01111111`).
    - **Usable Host Addresses**: From `192.168.1.65` to `192.168.1.126`.
  - **Third Subnet**:
    - **Network Address**: `192.168.1.128` (last octet `10000000`).
    - **Broadcast Address**: `192.168.1.191` (last octet `10111111`).
    - **Usable Host Addresses**: From `192.168.1.129` to `192.168.1.190`.
  - **Fourth Subnet**:
    - **Network Address**: `192.168.1.192` (last octet `11000000`).
    - **Broadcast Address**: `192.168.1.255` (last octet `11111111`).
    - **Usable Host Addresses**: From `192.168.1.193` to `192.168.1.254`.

----

## Calculation Fundamental: Converting to binary bits

Convert binary to decimal:
https://www.youtube.com/watch?v=a2FpnU9Mm3E

![](B5BNeVL.png)

Convert decimal to binary
https://www.youtube.com/watch?v=rsxT4FfRBaM
![](dIWoK3j.png)

![](HPdVbYJ.png)

^ Those 128 64 32 16 8 4 2 1 are from:
2^7, ,2^6, 2^5, 2^4, 2^3, 2^2, 2^1, 2^0

^ 2^7=128 represents the total number of possible permutations (or combinations) of bits when you have 7 bits. Each bit can be either a 0 or a 1, and with 7 bits, you can create 128 different combinations ranging from `0000000` to `1111111`. This is because each additional bit doubles the number of possible combinations, following the formula 2�2n, where �n is the number of bits.

Most significant bit (the left most)

Least significant bit (the right most)

Shifting means dropping the most significant bit (1000 becomes 000)

Unshifting means adding a most significant bit (1000 becomes 11000)

---

## Calculation Fundamental: Subnet and Device Addresses

`255.255.255.192` (or `/26`) can do 4 subnets, each with possible 64 addresses, out of which 62 possible device addresses (because 2 of the 64 addresses are for network and broadcast)

The capability to create 4 subnets with a subnet mask of `255.255.255.192` (or `/26`) is not directly because of dividing `255` by `64`, but rather due to how the subnet mask allocates bits for the network and host portions of the IP addresses within a Class C network. Let's clarify how this works:

#### Subnet Mask and Bit Allocation

- The subnet mask `255.255.255.192` in binary is `11111111.11111111.11111111.11000000`.
- The `/26` CIDR notation indicates that 26 bits are used for the network portion, leaving 6 bits for host addressing. However, the key to understanding the creation of 4 subnets lies in the difference between this subnet mask and a standard Class C network mask (`255.255.255.0` or `/24`).

#### How Subnetting Works

1. **Standard Class C Network (`/24`)**:
   - A standard Class C network has a subnet mask of `255.255.255.0`, using 24 bits for the network portion. This leaves 8 bits for host addresses, allowing for 256 total addresses (0-255 in the last octet), but in practice, 254 usable addresses since the first (network address) and last (broadcast address) are reserved.

2. **Subnetting to `/26`**:
   - By changing the subnet mask to `255.255.255.192` (`/26`), you are effectively taking 2 of those 8 host bits and using them for subnetting. This means instead of all 8 bits being available for different host addresses within a single network, 2 bits are now used to define subnets.
   - With 2 bits for subnetting (the `11` in `11000000` of the last octet), you can create 4 combinations: `00`, `01`, `10`, and `11`. These combinations represent the 4 subnets.

#### Calculating the Number of Subnets

- The calculation for the number of subnets created by borrowing bits from the host part is \(2^n\), where \(n\) is the number of bits borrowed for subnetting.
- In this case, \(n = 2\) (as we're using 2 bits from what was originally the host part of the address for subnetting), so \(2^2 = 4\) subnets.

#### Address Allocation

- Each subnet now has 6 bits left for host addresses, which means \(2^6 = 64\) addresses per subnet. However, one address is reserved for the subnet's network address and another for the broadcast address, leaving 62 usable addresses per subnet.

#### Summary

The ability to create 4 subnets with the `255.255.255.192` subnet mask is due to the allocation of bits for subnetting within the IP address structure, not a division of `255` by `64`. By using 2 of the original host bits for subnetting, you can create 4 distinct subnets within a Class C network, each with its own range of IP addresses.

---


## Different Setups
### Example 1: Basic Home Network

- **Network Setup**: A standard home router often uses the IP range `192.168.1.0` to `192.168.1.255`.
- **IP Address**: `192.168.1.10`
- **Subnet Mask**: `255.255.255.0`
- **Explanation**: The subnet mask `255.255.255.0` means the first three octets (255.255.255) are the network part, and the last octet (0) is for host addresses. In this case, any device with an IP address from `192.168.1.1` to `192.168.1.254` is part of the same subnet.

### Example 2: Corporate Network

- **Network Setup**: A larger network might use a broader range of IP addresses.
- **IP Address**: `10.20.5.32`
- **Subnet Mask**: `255.255.0.0`
- **Explanation**: Here, the subnet mask `255.255.0.0` indicates that the first two octets (10.20) determine the network segment, while the last two (5.32) are for individual devices. Any device with an IP address from `10.20.0.1` to `10.20.255.254` would be on the same subnet.

### Example 3: Subdivided Corporate Network

- **Network Setup**: A larger corporate network might be further divided into smaller subnets.
- **IP Address**: `172.16.4.22`
- **Subnet Mask**: `255.255.255.192`
- **Explanation**: In this case, the subnet mask `255.255.255.192` (in binary, the mask is `11111111.11111111.11111111.11000000`) allows for smaller subnets. This network is divided into smaller blocks; the `4.22` falls into one of these. The range for this specific subnet would be `172.16.4.0` to `172.16.4.63`.

### How to Determine the Range:

- The range of addresses in a subnet is determined by the subnet mask. The network portion (represented by `255` in the mask) is fixed for all addresses in the subnet. The host portion (where the mask has `0`) varies for each device in the subnet.
- For instance, in Example 3, `255.255.255.192` leaves the last 6 bits for host addresses (`192` in binary is `11000000`). So, the host part ranges from `000000` to `111111`, giving a range of 64 addresses (from `0` to `63`), but typically the first and last addresses are reserved for network identifier and broadcast address, respectively.

These examples illustrate how different subnet masks can define networks of various sizes, suitable for different organizational needs.
