import { combineReducers } from 'redux';
import { omit } from 'lodash';
import { ActionTypes } from './actions';

const initialGlobals = {
  isLoading: {
    foods: true,
    tables: true,
  },
  errors: {
    foods: '',
    tables: '',
    persistTables: '',
  },
};

function globalsReducer(state = initialGlobals, action) {
  switch (action.type) {
    case ActionTypes.GET_FOODS_REQUEST:
      return {
        ...state,
        isLoading: {
          ...state.isLoading,
          foods: true,
        },
        errors: {
          ...state.errors,
          foods: '',
        },
      };
    case ActionTypes.GET_FOODS_SUCCESS:
      return {
        ...state,
        isLoading: {
          ...state.isLoading,
          foods: false,
        },
      };
    case ActionTypes.GET_FOODS_FAILURE:
      return {
        ...state,
        isLoading: {
          ...state.isLoading,
          foods: false,
        },
        errors: {
          ...state.errors,
          foods: action.payload,
        },
      };

    case ActionTypes.GET_TABLES_REQUEST:
      return {
        ...state,
        isLoading: {
          ...state.isLoading,
          tables: true,
        },
      };
    case ActionTypes.GET_TABLES_SUCCESS:
      return {
        ...state,
        isLoading: {
          ...state.isLoading,
          tables: false,
        },
      };
    case ActionTypes.GET_TABLES_FAILURE:
      return {
        ...state,
        isLoading: {
          ...state.isLoading,
          tables: false,
        },
        errors: {
          ...state.errors,
          tables: action.payload,
        },
      };

    case ActionTypes.PERSIST_TABLES_SUCCESS:
      return {
        ...state,
        errors: {
          ...state.errors,
          persistTables: '',
        },
      };
    case ActionTypes.PERSIST_TABLES_FAILURE:
      return {
        ...state,
        errors: {
          ...state.errors,
          persistTables: action.payload,
        },
      };

    default:
      return state;
  }
}

const initialFoods = {
  ids: [],
  filter: '',
  selectedCategory: '',
  data: {},
};

function foodsReducer(state = initialFoods, action) {
  switch (action.type) {
    case ActionTypes.GET_FOODS_SUCCESS:
      return {
        ...state,
        data: action.payload.foods,
        ids: action.payload.ids,
      };

    case ActionTypes.SET_SELECTED_CATEGORY:
      return {
        ...state,
        selectedCategory: action.payload,
        filter: '',
      };
    case ActionTypes.SET_SEARCH_FILTER:
      return {
        ...state,
        filter: action.payload,
        selectedCategory: '',
      };
    case ActionTypes.RESET_FILTER_AND_SELECTED_CATEGORY:
      return {
        ...state,
        filter: '',
        selectedCategory: '',
      };

    default:
      return state;
  }
}

const initialTables = {};

function tablesReducer(state = initialTables, action) {
  switch (action.type) {
    case ActionTypes.GET_TABLES_SUCCESS:
      return {
        ...action.payload,
      };

    case ActionTypes.ADD_FOOD_TO_ORDER: {
      const { foodId, tableId } = action.payload;
      const { orders, entries } = state[tableId];

      const order = orders[foodId];
      const newAmount = order ? order + 1 : 1;

      const newOrders = {
        ...orders,
        [foodId]: newAmount,
      };

      let newEntries = [foodId];
      if (entries) {
        if (entries.includes(foodId)) {
          newEntries = [...entries];
        } else {
          newEntries = [foodId, ...entries];
        }
      }

      return {
        ...state,
        [tableId]: {
          ...state[tableId],
          orders: newOrders,
          entries: newEntries,
        },
      };
    }
    case ActionTypes.REMOVE_FOOD_FROM_ORDER: {
      const { foodId, tableId } = action.payload;
      const { orders, entries } = state[tableId];
      const order = orders[foodId];

      const newAmount = order > 0 ? order - 1 : 0;
      const newOrders =
        newAmount === 0
          ? omit(orders, foodId)
          : {
              ...orders,
              [foodId]: newAmount,
            };
      const newEntries = newAmount === 0 ? entries.filter(e => e !== foodId) : entries;

      return {
        ...state,
        [tableId]: {
          ...state[tableId],
          orders: newOrders,
          entries: newEntries,
        },
      };
    }
    case ActionTypes.REMOVE_ALL_FOODS_FROM_ORDER: {
      const { foodId, tableId } = action.payload;
      const { orders, entries } = state[tableId];
      const newOrders = omit(orders, foodId);
      const newEntries = entries.filter(e => e !== foodId);

      return {
        ...state,
        [tableId]: {
          ...state[tableId],
          orders: newOrders,
          entries: newEntries,
        },
      };
    }

    case ActionTypes.SET_NOTES_FOR_TABLE: {
      const { notes, tableId } = action.payload;
      return {
        ...state,
        [tableId]: {
          ...state[tableId],
          notes,
        },
      };
    }

    case ActionTypes.RESET_TABLE: {
      const { tableId } = action.payload;
      return {
        ...state,
        [tableId]: {
          ...state[tableId],
          orders: {},
          entries: [],
          notes: '',
        },
      };
    }

    default:
      return state;
  }
}

const reducer = combineReducers({
  globals: globalsReducer,
  foods: foodsReducer,
  tables: tablesReducer,
});

export default reducer;
