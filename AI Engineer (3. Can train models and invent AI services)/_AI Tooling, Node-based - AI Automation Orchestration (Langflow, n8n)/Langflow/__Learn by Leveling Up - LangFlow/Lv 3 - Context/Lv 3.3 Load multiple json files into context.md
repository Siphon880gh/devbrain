
Follow the same steps as [[Lv 3.2 Load json file into context]], very importantly, the System Message Prompt is the same:
```
You are a helpful assistant named Cody that answer questions about datasets.  
  
Use markdown to format your answer, properly embedding images and urls.  
  
Below are the datasets for employees:   
  
{JSONString}
```

Instead of a File component, use a Directory component (Also in the “Data” components category)
![[Pasted image 20250210190702.png]]


For the directory component, as of 2/2025, there’s no browse dialogue. Paste or type the path to a folder of json files. You can test in the terminal if it’s a correct path with the command: ls ____  where the underline is your path.

The folder’s json files could be:
├── d1.json
├── d2.json
└── d3.json

> [!note] d1.json:
> ```
> {  
>     "name": "John Doe",  
>     "age": 30,  
>     "email": "john.doe@example.com",  
>     "dept": "IT",  
>     "salary": 60000,  
>     "job": "Technician",  
>     "phone": "1234567890",  
>     "address": "123 Main St, Anytown, USA",  
>     "city": "Anytown",  
>     "state": "CA",  
>     "zip": "12345",  
>     "country": "USA"  
> }
> ```

> [!note] d2.json:
> ```
> {  
>     "name": "Jane Smith",  
>     "age": 25,  
>     "email": "jane.smith@example.com",  
>     "dept": "HR",  
>     "salary": 45000,  
>     "job": "Manager",  
>     "phone": "9876543210",  
>     "address": "456 Oak Ave, Anytown, USA",  
>     "city": "Anytown",  
>     "state": "CA",  
>     "zip": "67890",  
>     "country": "USA"  
> }
> ```

> [!note] d3.json:
> ```
> {  
>     "name": "Cody Johnson",  
>     "age": 30,  
>     "email": "cody.johnson@example.com",  
>     "dept": "Engineering",  
>     "salary": 70000,  
>     "job": "Developer",  
>     "phone": "1234567890",  
>     "address": "124 Main St, Anytown, USA",  
>     "city": "Anytown",  
>     "state": "CA",  
>     "zip": "12345",  
>     "country": "USA"  
> }
> ```


Use a Chat Input like “Give me JSONString”. 
![[Pasted image 20250210190951.png]]

The response proves to you that the Directory component had combined the multiple json's into an array of objects, and then passed that as a json array string into JSONString which is part of the System Message Prompt. So under the hood, the context or system message is actually:
```
You are a helpful assistant named Cody that answer questions about datasets.  
  
Use markdown to format your answer, properly embedding images and urls.  
  
Below are the datasets for employees:   
  
[  
    {  
        "name": "Jane Smith",  
        "age": 25,  
        "email": "jane.smith@example.com",  
        "dept": "HR",  
        "salary": 45000,  
        "job": "Manager",  
        "phone": "9876543210",  
        "address": "456 Oak Ave, Anytown, USA",  
        "city": "Anytown",  
        "state": "CA",  
        "zip": "67890",  
        "country": "USA"  
    },  
    {  
        "name": "Cody Johnson",  
        "age": 30,  
        "email": "cody.johnson@example.com",  
        "dept": "Engineering",  
        "salary": 70000,  
        "job": "Developer",  
        "phone": "1234567890",  
        "address": "124 Main St, Anytown, USA",  
        "city": "Anytown",  
        "state": "CA",  
        "zip": "12345",  
        "country": "USA"  
    },  
    {  
        "name": "John Doe",  
        "age": 30,  
        "email": "john.doe@example.com",  
        "dept": "IT",  
        "salary": 60000,  
        "job": "Technician",  
        "phone": "1234567890",  
        "address": "123 Main St, Anytown, USA",  
        "city": "Anytown",  
        "state": "CA",  
        "zip": "12345",  
        "country": "USA"  
    }  
]
```

---

**More - Test Analytical Ability**

Type into Chat Input or ask in Playground:
```
Which employees are neighbors?
```

Its response would be:
```
To determine which employees are neighbors, we can look at their addresses. In this dataset, the addresses are as follows:  
  
1. **Jane Smith**: 456 Oak Ave, Anytown, USA  
2. **Cody Johnson**: 124 Main St, Anytown, USA  
3. **John Doe**: 123 Main St, Anytown, USA  
  
From the addresses, we can see that:  
  
- **Cody Johnson** and **John Doe** live on the same street (Main St), with John Doe at **123 Main St** and Cody Johnson at **124 Main St**. Therefore, they are neighbors.  
  
- **Jane Smith** lives on a different street (Oak Ave) and is not a neighbor to either Cody Johnson or John Doe.  
  
### Conclusion:  
- **Neighbors**:   
  - Cody Johnson and John Doe  
- **Not Neighbors**:   
  - Jane Smith
```