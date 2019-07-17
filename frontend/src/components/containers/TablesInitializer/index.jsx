import React from 'react';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import * as PropTypes from 'prop-types';
import { actions } from '../../../ducks';

function TablesInitializer({ getLastTables }) {
  getLastTables();
  return <></>;
}

function mapDispatchToProps(dispatch) {
  return bindActionCreators(
    {
      getLastTables: actions.getLastTables,
    },
    dispatch,
  );
}

TablesInitializer.propTypes = {
  getLastTables: PropTypes.func.isRequired,
};

export default connect(
  null,
  mapDispatchToProps,
)(TablesInitializer);
