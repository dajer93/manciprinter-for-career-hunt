import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter } from 'react-router-dom';
import { Provider } from 'react-redux';
import App from './App';
import './globals/style.scss';
import store from './store';

ReactDOM.render(
  <Provider store={store}>
    <BrowserRouter basename="/wp-admin/order-management">
      <App />
    </BrowserRouter>
  </Provider>,
  document.getElementById('root'),
);
