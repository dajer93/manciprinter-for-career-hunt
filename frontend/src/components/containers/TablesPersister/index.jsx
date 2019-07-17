import React, { useRef } from 'react';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { throttle } from 'lodash';
import * as PropTypes from 'prop-types';
import { actions } from '../../../ducks';

/**
 * Tries to persist the current tables on the server every 5 seconds.
 */
function TablesPersister({ persistTables }) {
  const isInitialMount = useRef(true);
  const { current: throttledPersist } = useRef(throttle(persistTables, 5000));

  if (isInitialMount.current) {
    isInitialMount.current = false;
  } else {
    throttledPersist();
  }

  return <></>;
}

/**
 * Subscribe to state changes to force rerender, and try to initiate an another persist request.
 */
function mapStateToProps(state) {
  return {
    tables: state.tables,
  };
}

function mapDispatchToProps(dispatch) {
  return bindActionCreators(
    {
      persistTables: actions.persistTables,
    },
    dispatch,
  );
}

TablesPersister.propTypes = {
  persistTables: PropTypes.func.isRequired,
};

export default connect(
  mapStateToProps,
  mapDispatchToProps,
)(TablesPersister);
