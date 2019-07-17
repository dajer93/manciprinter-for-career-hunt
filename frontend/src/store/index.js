import { composeWithDevTools } from 'redux-devtools-extension';
import { applyMiddleware, createStore } from 'redux';
import thunk from 'redux-thunk';
import { reducer } from '../ducks';

const composeEnhancers = composeWithDevTools({});
const store = createStore(reducer, undefined, composeEnhancers(applyMiddleware(thunk)));

export default store;
