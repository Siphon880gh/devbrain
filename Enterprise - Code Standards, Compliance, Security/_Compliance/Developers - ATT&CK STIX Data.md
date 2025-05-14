Repository at:
https://github.com/mitre-attack/attack-stix-data/

## What is MITRE ATT&CK
[MITRE ATT&CK](https://attack.mitre.org/) is a globally-accessible knowledge base of adversary tactics and techniques based on real-world observations. The ATT&CK knowledge base is used as a foundation for the development of specific threat models and methodologies in the private sector, in government, and in the cybersecurity product and service community.

## What is STIX Data
STIX enables organizations to share CTI with one another in a consistent and machine readable manner, allowing security communities to better understand what computer-based attacks they are most likely to see and to anticipate and/or respond to those attacks faster and more effectively.

![[Pasted image 20250514033150.png]]

The data are primarily in JSON format:
![[Pasted image 20250514033225.png]]

TLDR: You can develop compliance auditing etc apps or platforms using this data.

---

## How to inspect the data as a human

For example, visiting a specific data point ICS attack 10.0: https://github.com/mitre-attack/attack-stix-data/blob/master/ics-attack/ics-attack-10.0.json

You may notice an array of objects with attack pattern ID's, for example:
```
            "x_mitre_contents": [
                {
                    "object_ref": "attack-pattern--19a71d1e-6334-4233-8260-b749cae37953",
                    "object_modified": "2021-10-08T15:14:01.612Z"
                },
                {
                    "object_ref": "attack-pattern--2900bbd8-308a-4274-b074-5b8bde8347bc",
                    "object_modified": "2021-10-08T13:04:01.612Z"
                },
                {
                    "object_ref": "attack-pattern--3de230d4-3e42-4041-b089-17e1128feded",
                    "object_modified": "2021-10-08T13:04:01.612Z"
                },
                {
                    "object_ref": "attack-pattern--008b8f56-6107-48be-aa9f-746f927dbb61",
                    "object_modified": "2021-10-08T13:04:01.612Z"
                },
                {
                    "object_ref": "attack-pattern--3f1f4ccb-9be2-4ff8-8f69-dd972221169b",
                    "object_modified": "2021-10-08T13:04:01.612Z"
                },
                {
                    "object_ref": "attack-pattern--1c478716-71d9-46a4-9a53-fa5d576adb60",
                    "object_modified": "2021-10-08T13:04:01.612Z"
                },
            
```

Choosing one of the attack pattern IDs, for example: `attack-pattern--19a71d1e-6334-4233-8260-b749cae37953`,  you can search further in that json file which can reveal a relationship and its description:
```
        {
            "type": "relationship",
            "target_ref": "attack-pattern--19a71d1e-6334-4233-8260-b749cae37953",
            "description": "The [Industroyer](https://collaborate.mitre.org/attackics/index.php/Software/S0001) SPIROTEC DoS module places the victim device into 'firmware update' mode. This is a legitimate use case under normal circumstances, but in this case is used the adversary to prevent the SPIROTEC from performing its designed protective functions. As a result the normal safeguards are disabled, leaving an unprotected link in the electric transmission.(Citation: Dragos CRASHOVERRIDE Aug 2019)",
            "created_by_ref": "identity--c78cb6e5-0c4b-4611-8297-d1b8b55e40b5",
            "created": "2018-10-17T00:14:20.652Z",
            "id": "relationship--83c8c216-7ff7-4bd3-9db4-573469628d95",
            "source_ref": "malware--e401d4fe-f0c9-44f0-98e6-f93487678808",
            "modified": "2021-10-21T14:00:00.188Z",
            "object_marking_refs": [
                "marking-definition--fa42a846-8d90-4e51-bc29-71d5b4802168"
            ],
```

And if you look at its other ID (source_ref) with CMD+F, you can find other information about this relationship: `malware--e401d4fe-f0c9-44f0-98e6-f93487678808`
```
        {
            "created": "2021-01-04T20:42:21.997Z",
            "modified": "2021-10-13T19:33:41.189Z",
            "type": "malware",
            "id": "malware--e401d4fe-f0c9-44f0-98e6-f93487678808",
            "description": "[Industroyer](https://attack.mitre.org/software/S0604) is a sophisticated malware framework designed to cause an impact to the working processes of Industrial Control Systems (ICS), specifically components used in electrical substations.(Citation: ESET Industroyer) [Industroyer](https://attack.mitre.org/software/S0604) was used in the attacks on the Ukrainian power grid in December 2016.(Citation: Dragos Crashoverride 2017) This is the first publicly known malware specifically designed to target and impact operations in the electric grid.(Citation: Dragos Crashoverride 2018)",
            "name": "Industroyer",
            "created_by_ref": "identity--c78cb6e5-0c4b-4611-8297-d1b8b55e40b5",
            "object_marking_refs": [
                "marking-definition--fa42a846-8d90-4e51-bc29-71d5b4802168"
            ],
```

If you diagram out these `relationship` connections, you’ll end up with something visually similar to a **Mind Map** or a **graph/network diagram** — which is exactly what tools like MITRE ATT&CK Navigator, STIX visualizers, or threat modeling platforms do. An example of a graph/network diagram is at [[Reference - Compliance Orchestration Chart]].


----

## AI Applications

These MITRE ATT&CK json for developers are JSON files that form graph/network diagrams. Much of the objects are nodes or relationships.

You want to ask yourself: How can I train AI, maybe a RAG with vector database, on these graph/network diagrams?  You'll likely chunk each object into the vector database.

This sounds all very expensive. You may want to ask how can I self host my own vector database. Then when there's a proof of concept, you can request budget or investment.