import { createSelector } from 'reselect';
import { uniqBy, isEmpty } from 'lodash';

export function getFoods({ foods: { ids, data } }) {
  return ids.map(id => data[id]);
}

export function getFoodCategories(state) {
  return uniqBy(Object.values(state.foods.data), 'category').map(f => f.category);
}

export function getSelectedFoodCategory(state) {
  return state.foods.selectedCategory;
}

export const getFoodsBySelectedCategory = createSelector(
  [getFoods, getSelectedFoodCategory],
  (foods, category) => foods.filter(f => f.category === category),
);

export function getFoodsFilter(state) {
  return state.foods.filter;
}

export const getFoodsByFilter = createSelector(
  getFoods,
  getFoodsFilter,
  (foods, filter) => foods.filter(f => f.name.hu.toLowerCase().includes(filter.toLowerCase())),
);

export function getTables(state) {
  return Object.values(state.tables).map(t => {
    return {
      ...t,
      isTaken: !(isEmpty(t.orders) || Object.values(t.orders).every(o => o === 0)),
    };
  });
}

export function getOrdersByTableId(state, id) {
  const { entries } = state.tables[id];
  return entries
    ? entries.map(foodId => ({
        id: foodId,
        amount: state.tables[id].orders[foodId],
      }))
    : [];
}

export function getTotalByTableId(state, id) {
  return Object.entries(state.tables[id].orders).reduce(
    (total, [foodId, amount]) => total + state.foods.data[foodId].price * amount,
    0,
  );
}

export function getReceiptDataByTableId(state, tableId) {
  return state.tables[tableId].entries.map(foodId => ({
    ...state.foods.data[foodId],
    amount: state.tables[tableId].orders[foodId],
  }));
}

export function isAppLoading(state) {
  return (
    state.globals.isLoading.foods ||
    state.globals.errors.foods !== '' ||
    state.globals.isLoading.tables ||
    state.globals.errors.tables !== ''
  );
}

export function getPersistError(state) {
  return state.globals.errors.persistTables;
}
