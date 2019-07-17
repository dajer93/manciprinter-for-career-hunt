import React from 'react';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import * as PropTypes from 'prop-types';
import { actions } from '../../../ducks';

function FoodsInitializer({ getFoods }) {
  getFoods();
  return <></>;
}

function mapDispatchToProps(dispatch) {
  return bindActionCreators(
    {
      getFoods: actions.getFoods,
    },
    dispatch,
  );
}

FoodsInitializer.propTypes = {
  getFoods: PropTypes.func.isRequired,
};

export default connect(
  null,
  mapDispatchToProps,
)(FoodsInitializer);
