import * as service from '../service';

export const ActionTypes = {
  GET_FOODS_REQUEST: '@@foods/GET_FOODS_REQUEST',
  GET_FOODS_SUCCESS: '@@foods/GET_FOODS_SUCCESS',
  GET_FOODS_FAILURE: '@@foods/GET_FOODS_FAILURE',
  SET_SELECTED_CATEGORY: '@@foods/SET_SELECTED_CATEGORY',
  SET_SEARCH_FILTER: '@@foods/SET_SEARCH_FILTER',
  RESET_FILTER_AND_SELECTED_CATEGORY: '@@foods/RESET_FILTER_AND_SELECTED_CATEGORY',

  ADD_FOOD_TO_ORDER: '@@tables/ADD_FOOD_TO_ORDER',
  REMOVE_FOOD_FROM_ORDER: '@@tables/REMOVE_FOOD_FROM_ORDER',
  REMOVE_ALL_FOODS_FROM_ORDER: '@@tables/REMOVE_ALL_FOODS_FROM_ORDER',
  SET_NOTES_FOR_TABLE: '@@tables/SET_NOTES',
  RESET_TABLE: '@@tables/RESET_TABLE',
  GET_TABLES_REQUEST: '@@tables/GET_TABLES_REQUEST',
  GET_TABLES_SUCCESS: '@@tables/GET_TABLES_SUCCESS',
  GET_TABLES_FAILURE: '@@tables/GET_TABLES_FAILURE',
  PERSIST_TABLES_REQUEST: '@@tables/PERSIST_TABLES_REQUEST',
  PERSIST_TABLES_SUCCESS: '@@tables/PERSIST_TABLES_SUCCESS',
  PERSIST_TABLES_FAILURE: '@@tables/PERSIST_TABLES_FAILURE',
};

export function getFoods() {
  return dispatch => {
    dispatch({
      type: ActionTypes.GET_FOODS_REQUEST,
    });

    service
      .getFoods()
      .then(
        res => dispatch({ type: ActionTypes.GET_FOODS_SUCCESS, payload: res }),
        err => dispatch({ type: ActionTypes.GET_FOODS_FAILURE, payload: err.message }),
      );
  };
}

export function persistTables() {
  return (dispatch, getState) => {
    dispatch({
      type: ActionTypes.PERSIST_TABLES_REQUEST,
    });

    service
      .persistTables(getState())
      .then(
        () => dispatch({ type: ActionTypes.PERSIST_TABLES_SUCCESS }),
        err => dispatch({ type: ActionTypes.PERSIST_TABLES_FAILURE, payload: err.message }),
      );
  };
}

export function getLastTables() {
  return dispatch => {
    dispatch({
      type: ActionTypes.GET_TABLES_REQUEST,
    });

    service
      .getLastTables()
      .then(
        res => dispatch({ type: ActionTypes.GET_TABLES_SUCCESS, payload: res }),
        err => dispatch({ type: ActionTypes.GET_TABLES_FAILURE, payload: err.message }),
      );
  };
}

export function setSelectedCategory(category) {
  return {
    type: ActionTypes.SET_SELECTED_CATEGORY,
    payload: category,
  };
}

export function setSearchFilter(filter) {
  return {
    type: ActionTypes.SET_SEARCH_FILTER,
    payload: filter,
  };
}

export function resetFilterAndSelectedCategory() {
  return {
    type: ActionTypes.RESET_FILTER_AND_SELECTED_CATEGORY,
  };
}

export function addFoodToOrder(foodId, tableId) {
  return {
    type: ActionTypes.ADD_FOOD_TO_ORDER,
    payload: {
      foodId,
      tableId,
    },
  };
}

export function removeFoodFromOrder(foodId, tableId) {
  return {
    type: ActionTypes.REMOVE_FOOD_FROM_ORDER,
    payload: {
      foodId,
      tableId,
    },
  };
}

export function removeAllFoodsFromOrder(foodId, tableId) {
  return {
    type: ActionTypes.REMOVE_ALL_FOODS_FROM_ORDER,
    payload: {
      foodId,
      tableId,
    },
  };
}

export function setNotesForTable(notes, tableId) {
  return {
    type: ActionTypes.SET_NOTES_FOR_TABLE,
    payload: {
      notes,
      tableId,
    },
  };
}

export function resetTable(tableId) {
  return {
    type: ActionTypes.RESET_TABLE,
    payload: {
      tableId,
    },
  };
}
