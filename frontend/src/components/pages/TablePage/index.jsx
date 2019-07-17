import React from 'react';
import { Grid, Typography } from '@material-ui/core';
import ReactRouterPropTypes from 'react-router-prop-types';
import { Orders, FoodSelector } from '../../containers';
import style from './style.module.scss';

function TablePage({ history, match }) {
  return (
    <Grid container className="h-100">
      <Grid item xs={1} sm={4} className={style.Orders}>
        <Grid container className={style.OrderNav}>
          <Grid item xs={6}>
            <Typography onClick={history.goBack} className={style.back}>
              Vissza
            </Typography>
          </Grid>
          <Grid item xs={6} className={style.backContainer}>
            <Typography className={style.tableName}>Asztal #{match.params.tableId}</Typography>
          </Grid>
        </Grid>

        <Orders tableId={match.params.tableId} />
      </Grid>
      <Grid item xs={1} sm={8} className={style.right}>
        <FoodSelector tableId={match.params.tableId} />
      </Grid>
    </Grid>
  );
}

TablePage.propTypes = {
  history: ReactRouterPropTypes.history.isRequired,
  match: ReactRouterPropTypes.match.isRequired,
};

export default TablePage;
