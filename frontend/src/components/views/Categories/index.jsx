import React from 'react';
import { Grid } from '@material-ui/core';
import * as PropTypes from 'prop-types';
import uuid from 'uuid/v1';
import SimpleCard from '../SimpleCard';

function Categories({ categories, selectCategory }) {
  return (
    <Grid container spacing={16}>
      {categories.map((c, i) => {
        const current = [];
        if (i === 0) {
          current.push(
            <Grid key={uuid()} item xs={12} sm={12}>
              Ételek
            </Grid>,
          );
          current.push(
            <Grid key={c} item xs={1} sm={3}>
              <SimpleCard text={c} onClick={() => selectCategory(c)} />
            </Grid>,
          );
          return current;
        }
        if (i === 3) {
          current.push(
            <Grid key={uuid()} item xs={12} sm={12}>
              Italok
            </Grid>,
          );
          current.push(
            <Grid key={c} item xs={1} sm={3}>
              <SimpleCard text={c} onClick={() => selectCategory(c)} />
            </Grid>,
          );
          return current;
        }
        return (
          <Grid key={c} item xs={1} sm={3}>
            <SimpleCard text={c} onClick={() => selectCategory(c)} />
          </Grid>
        );
      })}
    </Grid>
  );
}

Categories.propTypes = {
  categories: PropTypes.arrayOf(PropTypes.string).isRequired,
  selectCategory: PropTypes.func.isRequired,
};

export default Categories;
