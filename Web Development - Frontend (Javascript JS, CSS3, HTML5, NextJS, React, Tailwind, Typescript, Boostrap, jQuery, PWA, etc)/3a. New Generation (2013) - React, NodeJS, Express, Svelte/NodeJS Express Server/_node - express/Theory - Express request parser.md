

// Lets say ksdjfhkdshfdskjfhklds is encrypted string
// client-> send data is obj
// {
//   name:"John",
//   hobbies:"walk"
// }  -> send it to PORT->encrpyted->ksdjfhkdshfdskjfhklds
//
// from server data is received -> ksdjfhkdshfdskjfhklds-> converts client data to orginal format {
//   name:"John"
//   hobbies:"walk"
// } -> stores the results of original format in req.body
// Sets up the Express app to handle data parsing

app.use(express.urlencoded({ extended: true }));
app.use(express.json());