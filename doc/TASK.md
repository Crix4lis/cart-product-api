# TASK DESCRIPTION
Create a simple application allowing adding products to the cart. The application should
consist of two HTTP APIs (in a RESTful manner if possible)

## GUIDELINES
 - there is no need for frontend UI (unless you really want to show your frontend skills
as well ;)), just expose every action through REST APIs.
 - Code should be PHP-based
 - Tests are very welcome
 - Impress us, you can over-engineer it - we want to see your programming skills.
 
### Product catalog API:
Catalogue contains following products:

ID | Title | Price |
|---|---|---|
1| Fallout | 1.99 USD
2| Don't Starve| 2.99 USD
3| Baldur’s Gate| 3.99 USD
4| Icewind Dale| 4.99 USD
5| Bloodborne| 5.99 USD

Api should expose methods to:
1. ADD new product
    - product name must be unique
2. REMOVE a product
1. UPDATE product tittle and/or price
1. LIST all the products
    - there MUST BE at least 5 products in the catalogues
    - list MUST BE paginated, max 3 products per page
    
### Cart API
API that allow adding products to the carts. User can add multiple items of the same product
(max 10 units of the same product).

Api should expose methods to:
1. CREATE a cart
1. ADD a product to the cart
1. REMOVE product from the cart
1. LIST all the products in the cart
    - user should not be able to add more than 3 products to the cart
    - return a total price of all the products in the cart
