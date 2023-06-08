# Sequelize WHERE Operators

Example
```
Post.findAll({
  where: {
    [Op.or]: [{authorId: 12}, {authorId: 13}]
  }
});
```
There are other operators like [Op.gte] or [Op.ne]. 
More info: https://sequelize.org/v5/manual/querying.html#operators
