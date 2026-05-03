
Try to create this workflow (you dont need the correct settings yet):
![[Pasted image 20250611002054.png]]

Code Node 1.. renamed to LeadNumbers:
- **Code**:
```
return [
  {
    "first_name": "Alice",
    "last_name": "Johnson",
    "phone_number": "+1-555-123-4567"
  },
  {
    "first_name": "Bob",
    "last_name": "Smith",
    "phone_number": "+1-555-987-6543"
  }
]
```

Code Node 2... renamed to LeadEmails:
```
return [
  {
    "first_name": "Alice",
    "last_name": "Johnson",
    "email": "alice.johnson@example.com"
  },
  {
    "first_name": "Bob",
    "last_name": "Smith",
    "email": "bob.smith@example.com"
  }
]
```

Merge Node:
- **Mode**: `Combine` 
- **Combine By**: `Matching Fields` 
- **Fields to Match**: `first_name,last_name` 
- **Output Type**: `Keep Everything`. Akin to an outer join. `

Expected output (Output panel to the right inside Merge Node) should be:
```
[
  {
    "first_name": "Alice",
    "last_name": "Johnson",
    "phone_number": "+1-555-123-4567",
    "email": "alice.johnson@example.com"
  },
  {
    "first_name": "Bob",
    "last_name": "Smith",
    "phone_number": "+1-555-987-6543",
    "email": "bob.smith@example.com"
  }
]
```

Double click into Merge node, then press Execute step. You'll get this screen if successful:
![[Pasted image 20250611002126.png]]

Notice on the left panel you can view the individual data

1... LeadNumbers
![[Pasted image 20250611002207.png]]

2... LeadEmails
![[Pasted image 20250611002232.png]]

And that the final output shows the merged results of two datasets that were combined by matching fields first_name and last_name. This caused the fields phone_number and email to collapse into one dataset.
![[Pasted image 20250611002438.png]]

Tutorial done. In the real world, the data sources would be coming form http calls and the final nodes will be updating Hubspot CRM.