import React from 'react';
import { Grid } from '@material-ui/core';
import * as PropTypes from 'prop-types';
import SimpleCard from '../SimpleCard';

function Foods({ foods, tableId, addFoodToOrder }) {
  return (
    <Grid container spacing={16}>
      {foods.map(f => (
        <Grid key={f.id} item xs={1} sm={3}>
          <SimpleCard text={f.name.hu} onClick={() => addFoodToOrder(f.id, tableId)} />
        </Grid>
      ))}
    </Grid>
  );
}

Foods.propTypes = {
  foods: PropTypes.arrayOf(
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
  tableId: PropTypes.string.isRequired,
  addFoodToOrder: PropTypes.func.isRequired,
};

export default Foods;
