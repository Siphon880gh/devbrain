
Testing Express routes
https://github.com/visionmedia/supertest
```
app.get('/user', function(req, res) {

  res.status(200).json({ name: 'john' });

});


request(app)

  .get('/user')

  .expect('Content-Type', /json/)

  .expect('Content-Length', '15')

  .expect(200)

  .end(function(err, res) {

    if (err) throw err;

  });
