1. React + Wordpress
2. Minimal framework complexity (no TS, no Sagas etc.)
3. No CD
4. Server save with throttled function calls on every action 
5. App state is sent in stringified
6. No auth
7. No internet / request error check
8. 3 end-points for food, save state, get last state


# API Endpoints
## Get foods
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
## Set state
Route
```
POST /wp-json/order-management/state
```
Expects form-data `state: "stringified json"`.
Returns boolean whether the request was successful.
## Get state
Route
```
GET /wp-json/order-management/state
```
Returns string.
