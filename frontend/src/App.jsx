import React from 'react';
import { Switch, Route, Redirect } from 'react-router-dom';
import { connect } from 'react-redux';
import * as PropTypes from 'prop-types';
import { CircularProgress, Snackbar } from '@material-ui/core';
import { MuiThemeProvider } from '@material-ui/core/styles';
import { TablesPage, TablePage } from './components/pages';
import { FoodsInitializer, TablesPersister, TablesInitializer } from './components/containers';
import { selectors } from './ducks';
import theme from './theme';
import style from './style.module.scss';
import { ErrorSnackbarContent } from './components/views';

function App({ isLoading, persistError }) {
  if (isLoading) {
    return (
      <>
        <FoodsInitializer />
        <TablesInitializer />
        <CircularProgress className={style.loader} />
      </>
    );
  }
  return (
    <MuiThemeProvider theme={theme}>
      <div className={style.App}>
        <TablesPersister />

        <Switch>
          <Route exact path="/tables" component={TablesPage} />
          <Route path="/tables/:tableId" component={TablePage} />

          <Route render={() => <Redirect to="/tables" />} />
        </Switch>
      </div>

      <Snackbar
        open={persistError !== ''}
        anchorOrigin={{
          vertical: 'bottom',
          horizontal: 'right',
        }}
      >
        <ErrorSnackbarContent error={persistError} />
      </Snackbar>
    </MuiThemeProvider>
  );
}

function mapStateToProps(state) {
  return {
    isLoading: selectors.isAppLoading(state),
    persistError: selectors.getPersistError(state),
  };
}

App.propTypes = {
  isLoading: PropTypes.bool.isRequired,
  persistError: PropTypes.string.isRequired,
};

export default connect(mapStateToProps)(App);
