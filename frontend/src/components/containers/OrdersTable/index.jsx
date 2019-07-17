import React from 'react';
import { Table, TableHead, TableRow, TableCell, TableBody } from '@material-ui/core';
import { bindActionCreators } from 'redux';
import * as PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { actions, selectors } from '../../../ducks';
import style from './style.module.scss';

function OrdersTable({
  tableId,
  orders,
  foods,
  addOrderToTable,
  removeOrderFromTable,
  removeAllFoodsFromOrder,
}) {
  return (
    <Table id={tableId} className={style.Table}>
      <TableHead className={style.TableHeader}>
        <TableRow>
          <TableCell>Név</TableCell>
          <TableCell align="center">Mennyiség</TableCell>
          <TableCell>Törlés</TableCell>
        </TableRow>
      </TableHead>
      <TableBody className={style.TableBody}>
        {orders.map(order => (
          <TableRow key={order.id}>
            <TableCell align="left">{foods[order.id].name.hu}</TableCell>
            <TableCell align="center">
              <button
                className={style.button}
                type="button"
                onClick={() => removeOrderFromTable(order.id, tableId)}
              >
                -
              </button>{' '}
              {order.amount}{' '}
              <button
                className={style.button}
                type="button"
                onClick={() => addOrderToTable(order.id, tableId)}
              >
                +
              </button>
            </TableCell>
            <TableCell align="center">
              <button
                className={style.button}
                type="button"
                onClick={() => removeAllFoodsFromOrder(order.id, tableId)}
              >
                ×
              </button>
            </TableCell>
          </TableRow>
        ))}
      </TableBody>
    </Table>
  );
}

function mapStateToProps(state, { tableId }) {
  return {
    orders: selectors.getOrdersByTableId(state, tableId),
    foods: state.foods.data,
  };
}

function mapDispatchToProps(dispatch) {
  return bindActionCreators(
    {
      addOrderToTable: actions.addFoodToOrder,
      removeOrderFromTable: actions.removeFoodFromOrder,
      removeAllFoodsFromOrder: actions.removeAllFoodsFromOrder,
    },
    dispatch,
  );
}

OrdersTable.propTypes = {
  tableId: PropTypes.string.isRequired,

  orders: PropTypes.arrayOf(
    PropTypes.shape({
      id: PropTypes.string.isRequired,
      amount: PropTypes.number.isRequired,
    }),
  ).isRequired,
  foods: PropTypes.objectOf(
    PropTypes.shape({
      id: PropTypes.string.isRequired,
      price: PropTypes.number.isRequired,
      category: PropTypes.string.isRequired,
      name: PropTypes.shape({
        en: PropTypes.string.isRequired,
        hu: PropTypes.string.isRequired,
      }),
    }),
  ).isRequired,

  addOrderToTable: PropTypes.func.isRequired,
  removeOrderFromTable: PropTypes.func.isRequired,
  removeAllFoodsFromOrder: PropTypes.func.isRequired,
};

export default connect(
  mapStateToProps,
  mapDispatchToProps,
)(OrdersTable);
