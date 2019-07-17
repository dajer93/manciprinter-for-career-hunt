import React, { useRef } from 'react';
import { Grid, Button, TextField } from '@material-ui/core';
import { connect } from 'react-redux';
import * as PropTypes from 'prop-types';
import { bindActionCreators } from 'redux';
import ReactToPrint from 'react-to-print';
import { selectors, actions } from '../../../ducks';
import OrdersTable from '../OrdersTable';
import style from './style.module.scss';
import { Receipt } from '../../views';

function Orders({ tableId, total, resetTable, receiptData, notes, setNotesForTable }) {
  const receiptHun = useRef();
  const receiptEng = useRef();

  return (
    <>
      <Grid
        container
        direction="column"
        justify="flex-start"
        alignItems="flex-start"
        className={style.OrdersPanel}
      >
        <Grid item className={style.tableContainer}>
          <OrdersTable tableId={tableId} />
        </Grid>
        <Grid item className={style.bottom}>
          <Grid item>
            <TextField
              id="notes"
              label="Megjegyzés"
              multiline
              rowsMax="4"
              value={notes}
              onChange={e => setNotesForTable(e.target.value, tableId)}
              margin="normal"
              variant="outlined"
              className={style.textarea}
            />
          </Grid>

          <Grid item className={style.total}>
            Összesen: {total} Ft
          </Grid>

          <Grid
            container
            direction="row"
            justify="space-between"
            alignItems="center"
            className={style.bottomButtonContainer}
          >
            <Button variant="outlined" color="primary" onClick={() => resetTable(tableId)}>
              Törlés
            </Button>

            <ReactToPrint
              trigger={() => (
                <Button disabled={total === 0} variant="outlined" color="primary">
                  Blokk (HU)
                </Button>
              )}
              content={() => receiptHun.current}
            />

            <ReactToPrint
              trigger={() => (
                <Button disabled={total === 0} variant="outlined" color="primary">
                  Blokk (EN)
                </Button>
              )}
              content={() => receiptEng.current}
            />
          </Grid>
        </Grid>
      </Grid>

      <div style={{ display: 'none' }}>
        <Receipt locale="hu" orders={receiptData} total={total} ref={receiptHun} />
        <Receipt locale="en" orders={receiptData} total={total} ref={receiptEng} />
      </div>
    </>
  );
}

function mapStateToProps(state, { tableId }) {
  return {
    notes: state.tables[tableId].notes,
    total: selectors.getTotalByTableId(state, tableId),
    receiptData: selectors.getReceiptDataByTableId(state, tableId),
  };
}

function mapDispatchToProps(dispatch) {
  return bindActionCreators(
    {
      resetTable: actions.resetTable,
      setNotesForTable: actions.setNotesForTable,
    },
    dispatch,
  );
}

Orders.propTypes = {
  tableId: PropTypes.string.isRequired,
  total: PropTypes.number.isRequired,
  receiptData: PropTypes.arrayOf(
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
  notes: PropTypes.string.isRequired,

  resetTable: PropTypes.func.isRequired,
  setNotesForTable: PropTypes.func.isRequired,
};

export default connect(
  mapStateToProps,
  mapDispatchToProps,
)(Orders);
