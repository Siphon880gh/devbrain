Interfaces is defining keys and their data types.

Interfaces are useful for many cases but one use case is when an object from like an API sometimes has a property and sometimes doesn't. You have no control over it because that API is an external developer's. They decided, for example, when an inventory item has no tags, then instead of an empty array tags, the property tag is just missing:

```
interface InventoryBananas {
  price: number
  stock: number
  label: string
  tags?: Array<string>
}

const inventoryResponse:InventoryBananas = {
  price: 0.58,
  stock: 20,
  label: "Banana"
}
```



With this code, the inventoryResponse from the API could have tags or not. Furthermore, the tags must be an array of strings if it's provided.


---

Say you have an API object that has a property that occasionally are strings instead of numbers. You can have union inside that property (think of the interface as an object schema whose properties are key name and type definitions):

```
interface InventoryBananas {
	price: number | string
	// ...
}
```

Then an inventoryResponse with inventoryResponse.price as 0.58 or as "0.58" will not error