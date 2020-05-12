# Architecture
## Domains
This appliction is made up from two domains, one is being **CART** the other **CATALOGUE**. Moreover
there is another common namespace called **COMMON**

### Cart Domain
Namespace: `Task\App\Cart`<br>

This domain defines cart model and product reference model
and defines how to:
 - create cart
 - add products to cart
 - remove products to cart
 - deletes cart if all products are deleted
 
This domain is unaware of real products, it just stores references to them. 
It also defines its domain events under `Domain\Event`

### Catalogue Domain
Namespace: `Task\App\Catalogue\`<br>

This domain defines product model
and defines how to:
 - create product
 - how to modify product properties and when it's allowed
 - deletes product

This domain is unaware of cart domain. 
It also defines its domain events under `Domain\Events`

### Common
Namespace: `Task\App\Common`<br>

It stores shared classes like Price, Base Domain Event, Uuid generators etc...

## Hexagonal
The `Domain` dir in both domains/bc is totally unaware of infrastructure application layer or
other domains.

## CQRS
Under `Application` in both domains there are defined Commands and their Handlers
Under `Infrastrucutre\Query` in both domains there are defined Queries for each domain
(cart domain queries also tables managed by catalogue)

## Events
Each Domain model state change creates specified to operation domain event which is later saved
to database, so there is full history of change of every model. They are being persisted in single
database transaction as domain model change so there are never missed or broken.
Morover those events can be subscribed to and another operations
can be triggered when model state is changed. They could be emailed, published
on queue and more... Currently there are subscribers that just print Hello to each event being published.

## Api error handling
All exceptions that occur during request handling are handled by single class
`Task\App\Common\SymfonyKernelEventListener\HandleSymfonyApiErrors` which is being subscribed
to Symfony kernel.exception event. Thanks to that controllers execute only happy path
