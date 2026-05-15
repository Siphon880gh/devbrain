By using associations and include property, it will do left joins for you. Remember that the include property in your models don't work without associations setup. Associations are setup at ./models/index.js which modifies the models with any associations before exporting them out to other files like server.js 

Sidenote: Setting up constraints like having foreign key to reference another table's record, or setting it such that the foreign key sets to NULL if the other table's record is deleted -> that does NOT do the joins for you.

## Includes
Includes look like this:
```
Albums.findAll({
  include: [{// Notice `include` takes an ARRAY
    model: Artists
  }]
})
.then(albums => console.log(albums))
.catch(console.error)
```

Multiple include:
```
include: [{
            model: models.Proposition,
            include: [{
                model: models.User,
                attributes: ['userId', 'firstname', 'lastname', 'profilePicture']
            }, {
                model: models.User,
                as: 'Fan',
                attributes: []
            }],
            required: false,
            attributes: [
                'propositionId',
                [models.sequelize.literal("CONCAT('"+ propositionsPicturesPath + "', `Propositions`.`photo`)"), 'photo'],
                [models.sequelize.literal('COUNT(`Propositions->Fan->like`.`userId`)'), 'likes'], // Show less results
                [models.sequelize.literal('IFNULL(SUM(`Propositions->Fan->like`.`userId` = ' + req.decoded.userId + '), 0)'), 'liked'] // Show less results
            ],
            group: '`Propositions->Fan->like`.`propositionId`',
        }]
```

You can rename it:
```
Albums.findAll({
  include: [{
    model: Artists,
    as: 'Singer' // specifies how we want to be able to access our joined rows on the returned data
  }]
})
.then(albums => console.log(albums))
.catch(console.error)
```
What's returned could be:
{
     id: 1,
     albumName: "Sing Aloud",
     artists: {
         artistName: "Singing Tutor"
     }
}

## Association Types
For the associations, they are setup at ./models/index.js file. There are possible two relationships between one table and another:
Has or BelongsTo. Let's ignore quantity for now (HasMany, HasOne, BelongsTo, BelongsToMany)

When you have a column that table A will use it's ID to join with another table B whose record is matches table A's column ID, then that column is foreign key. Which table has the foreign key that references the other table determines who is the haver and who is the belonger. This is actually a convention so let's go to Ruby's documentation because they explain this database convention very well: 

But ignore the quantity part. Ruby: "belongsTo: Specifies a one-to-one association with another class. This method should only be used if this class contains the foreign key. If the other class contains the foreign key, then you should use has_one instead."
https://api.rubyonrails.org/v6.1.1/classes/ActiveRecord/Associations/ClassMethods.html#method-i-belongs_to

BELONGS to should only be used to describe a class containing the foreign key (book_id, author_id, etc). If the other class contains the foreign key, then the class is describe as HAS instead.
Therefore,
```
// Artist has many Songs
Artist.hasMany(Song, {
    foreignKey: 'artist_id'
});
// One Song belongs to one Artist
Song.belongsTo(Artist, {
    foreignKey: 'artist_id'
});
```
You can also remember this as if artist gets deleted, then song's artist id should set to NULL through constraints, as a conventional practice. So this makes Artist more important than Song. So Artist has many songs, and the song belongs to artist (the song is subordinate). Song's artist_id gets owned by Artist if an Artist goes away.

An analogy: The owner has a dog. The dog belongs to the owner. This is because if the owner passes away, the dog is affected. So it's whatever table affects the other table. If an artist record is erased, then the song gets affected (artist_id foreign key sets to null by convention). The converse is not true: If a song gets deleted, no artist record gets affected.

Remember that the foreign key is the lookup id for the lookup table. In otherwords, if table A has ID's that reference table B, then joining table A to table B on A.lookup_id = B.id allows you to get the respective fields of table B.

## Association Quantity

Now you can focus on association quantity. This is a measure of how many combinations between each table.

// 1:1
Organization.belongsTo(User, { foreignKey: 'owner_id' });
User.hasOne(Organization, { foreignKey: 'owner_id' });

// 1:M
Project.hasMany(Task, { foreignKey: 'tasks_pk' });
Task.belongsTo(Project, { foreignKey: 'tasks_pk' });

// N:M
User.belongsToMany(Role, { through: 'user_has_roles', foreignKey: 'user_role_user_id' });
Role.belongsToMany(User, { through: 'user_has_roles', foreignKey: 'roles_identifier' });

## Advanced - Association with through table
If both tables affect each other's foreign key to NULL through an intermediate table, then neither of them are masters, so neither of them uses a HAS method. Both of them uses a BELONGS method. The real focus here is the intermediate table, which you will pass as a through property when setting up the association

The intermediate table for below is PostTag and has only the columns
post_id, tag_id 

Let's think of a social media network where tags like #freeWhoever trends. Then the association setup is:
```
// One Post belongs to many Tag (through PostTag)
Post.belongsToMany(Tag, { through: PostTag, foreignKey: 'product_id' });
// One Tag belongs to many Post (through PostTag)
Tag.belongsToMany(Post, { through: PostTag, foreignKey: 'tag_id' });
```