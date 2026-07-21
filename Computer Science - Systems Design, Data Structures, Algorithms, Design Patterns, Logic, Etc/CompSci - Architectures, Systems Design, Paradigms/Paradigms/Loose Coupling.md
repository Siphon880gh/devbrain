# Loose Coupling

To keep the code you use to pull data from your data store (database, flat files, web services, whatever) separate from business logic and presentation code. This way, if you have to change data stores, you don't end up rewriting the whole thing.
These days, various ORM frameworks are kind of blending the DAL with other layers. This typically makes development easier, but changing data stores can be painful. To be fair, changing data stores like that is pretty uncommon.