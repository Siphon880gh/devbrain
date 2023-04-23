# Model Config object - Timestamps

Besides passing Sequelize connection, you can have time stamp column. Here are createdAt and updatedAt Timestamps
    // Create a new todo with the data in 'req.body'
    const todo = await Todo.create({
        text: 'Have meeting',
        createdAt: "",
        updatedAt: ""
    }, {
        // Timestamps
        createdAt: Sequelize.DATE,
        updatedAt: Sequelize.DATE,
    });