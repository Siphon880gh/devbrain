
# Sequeilize show specific columns
## 
Model.findAll({
  attributes: ['foo', ['bar', 'baz']]
});
=> SELECT foo, bar AS baz

## Dont show a field
{ attributes: { exclude: ['password'] } }


