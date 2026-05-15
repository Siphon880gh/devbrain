# Sequelize sorting
You can sort:
```
Post.findAll({
  attributes: ['id', 'post_url', 'title', 'created_at'],
  order: [['created_at', 'DESC']], 
  include: [
    {
      model: User,
      attributes: ['username']
    }
  ]
})
```