
# Order Management
In this project we (UX Jam) created an order management plugin for a Wordpress based restaurant website. 

The plugin adds an admin interface, where the user can place orders for tables, manage these orders (add foods, comment, increment/decrement quantity, calculate price, ect.), print a receipt, and close the order. 

In case of emergency (restaurant laptop broken / no wifi) one can open up the actual orders on phone with a pincode secured public URL.
## Configuration
In order to make this work, you need to create a `.env` file in the frontend folder (project_root/frontend). The `.env` should contain the following variables:
```
REACT_APP_API_URL=[url of the WP json api]
REACT_APP_WP_ADMIN_URL=[url of the WP admin]
```
## API
### Get foods
Route
```
GET /wp-json/order-management/foods
```
Returns array of foods.
Food object
```javascript
const food = {
  id: 0,
  price: 0,
  category: "hu-Category",
  name: {
    en: "en-name",
    hu: "hu-name"
  }
};
```
### Set state
Route
```
POST /wp-json/order-management/state
```
Expects form-data `state: "stringified json"`.
Saves the state stringified in a WP option record.
Returns boolean whether the request was successful.
### Get state
Route
```
GET /wp-json/order-management/state
```
Returns string.
