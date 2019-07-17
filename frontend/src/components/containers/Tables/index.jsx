import React from 'react';
import Grid from '@material-ui/core/Grid';
import { connect } from 'react-redux';
import * as PropTypes from 'prop-types';
import { Table } from '../../views';
import { selectors } from '../../../ducks';

function Tables({ tables }) {
  return (
    <Grid container spacing={16} className="Tables">
      {tables.map(t => (
        <Grid key={t.id} item xs={1} sm={3}>
          <Table tableNumber={t.id} isTaken={t.isTaken} tableName={t.name} />
        </Grid>
      ))}
    </Grid>
  );
}

function mapStateToProps(state) {
  return {
    tables: selectors.getTables(state),
  };
}

Tables.propTypes = {
  tables: PropTypes.arrayOf(
    PropTypes.shape({
      id: PropTypes.string.isRequired,
      name: PropTypes.string.isRequired,
      isTaken: PropTypes.bool.isRequired,
      orders: PropTypes.object.isRequired,
    }),
  ).isRequired,
};

export default connect(mapStateToProps)(Tables);
