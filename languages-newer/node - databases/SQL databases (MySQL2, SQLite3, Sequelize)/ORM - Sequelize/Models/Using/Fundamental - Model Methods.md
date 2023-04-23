# Sequelize Model Methods
## Sequelize creating (create vs bulkCreate)
.create vs .bulkCreate
## Sequelize deleting (destroying)
.destroy
## Sequelize select all (findOne, findAll)
.findOne
.findAll
Example
```
Post.findAll({
  where: {
    [Op.or]: [{authorId: 12}, {authorId: 13}]
  }
});
```
There are other operators like [Op.gte] or [Op.ne]. Read lesson on operators.
