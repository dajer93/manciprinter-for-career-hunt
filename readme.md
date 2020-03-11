
# Order Management
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
