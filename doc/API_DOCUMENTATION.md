# API DOCUMENTATION
## Product
1. Create product

   `POST /products`, input data:
   ```json
    {
        "title": "The title 11",
        "price_amount": "5000"
    }
    ```
    - both fields required
    - 5000 means 50.00$ - only integerish strings are accepted
    - title is unique, try to insert another product with the same title - 409
    
    returns body:
    ```json
     {
        "new_product_id": "someuuidasdfaf" 
     }
    ```
   
   returns Location header:
   ```text
   Location: /products/someuuidasdfaf
    ```
    
1. Edit product, input data:

   `PUT /products`, input data:
   ```json
    {
        "title": "The title 11",
        "price_amount": "5000"
    }
    ```
    - one or both fields are required
    - 5000 means 50.00$ - only integerish strings are accepted
    - title is unique, try to change title to product that already exists - 409
    
1. Get single product:

   `GET /products/{id}`
   - id must be provided in uuid format
   
   example (200) response:
   ```json
    {
      "id": "22ea4379-f028-4ddf-90bd-e0ec106a275f",
      "title": "The title",
      "price_amount": "50.00",
      "price_currency": "USD"
    }
    ```
   
1. Get many products:

    `GET /products?page=1`
    - page is not required
    - page must be over 0
    - page must be int
    
    example (200) response data:
    ```json
    [
      {
        "id": "22ea4379-f028-4ddf-90bd-e0ec106a275f",
        "title": "The title",
        "price_amount": "50.00",
        "price_currency": "USD"
      },
      {
        "id": "ca2e09f2-4b9b-47ce-940a-3eb1cc34b023",
        "title": "The title 8",
        "price_amount": "50.00",
        "price_currency": "USD"
      },
      {
        "id": "30fa6fa1-ec95-4425-a1f6-4c4ab918588f",
        "title": "The title 9",
        "price_amount": "50.00",
        "price_currency": "USD"
      }
    ]
    ```

## Cart
1. Create cart

   `POST /carts`, input data:
   ```json
    {
        "product_id": "30fa6fa1-ec95-4425-a1f6-4c4ab918588f"
    }
    ```
    - product_id required
    - product_id must be string uuid format
    
    returns body:
    ```json
     {
        "new_cart_id": "7460254c-d3b2-419d-866b-78ca73e3d790" 
     }
    ```
   
   returns Location header:
   ```text
   Location: /carts/7460254c-d3b2-419d-866b-78ca73e3d790/products
    ```
    
1. Add product to cart
    > Operation non idempotent

   `PUT /cart/{id}/products`, input data:
   ```json
    {
        "product_id": "30fa6fa1-ec95-4425-a1f6-4c4ab918588f"
    }
   ```

    - product_id is required
    - product_id must be string in uuid format
    - remember you can add non existing product in catalogue, but it will not be returned under GET /carts/{id}/products
    

1. Remove product from cart

    `DELETE /carts/{id}/products/{productId}`
    
1. Get all carts

    `GET /carts`, example return data:
    ```json
     [
       "3b24fd5f-db24-43a3-a8af-81be3f7c9733",
       "85a6b4a2-d470-4db7-b68a-689383b6c9eb"
     ]
    ```
   
1. Get cart with its content (products)

    `GET /carts/{id}/products?page=1`
    - page is not required
    - page must be int
    - page must be over 0
    
    example input data:
    ```json
      "0": {
        "id": "30fa6fa1-ec95-4425-a1f6-4c4ab918588f",
        "title": "The title 9",
        "price_amount": "50.00",
        "price_currency": "USD"
      },
      ... another products,
      "cart_total_price_amount": "50.00",
      "cart_total_price_currency": "USD"
    ```
