import React from 'react';
import { Grid, TextField, Typography } from '@material-ui/core';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import * as PropTypes from 'prop-types';
import { actions, selectors } from '../../../ducks';
import { Categories, Foods, SimpleCard } from '../../views';
import style from './style.module.scss';

function FoodSelector({
  tableId,
  categories,
  selectedCategory,
  foodsByCategory,
  filter,
  foodsByFilter,
  selectCategory,
  setFilter,
  addFoodToOrder,
  resetFilterAndSelectedCategory,
}) {
  const categoriesHeader = `Kategóriák ${selectedCategory ? `› ${selectedCategory}` : ''}`;
  const backCard = (
    <Grid container spacing={16}>
      <Grid item xs={1} sm={3}>
        <SimpleCard text="Vissza" onClick={resetFilterAndSelectedCategory} />
      </Grid>
    </Grid>
  );

  let cards = <Categories categories={categories} selectCategory={selectCategory} />;
  if (selectedCategory) {
    cards = (
      <>
        {backCard}
        <Foods foods={foodsByCategory} tableId={tableId} addFoodToOrder={addFoodToOrder} />
      </>
    );
  } else if (filter) {
    cards = (
      <>
        {backCard}
        <Foods foods={foodsByFilter} tableId={tableId} addFoodToOrder={addFoodToOrder} />
      </>
    );
  }

  return (
    <div className="h-100">
      <Grid
        container
        direction="row"
        justify="space-between"
        alignItems="flex-start"
        className={style.top}
      >
        <Grid item xs={8}>
          <Typography>{categoriesHeader}</Typography>
        </Grid>

        <Grid item xs={4}>
          <TextField
            autoFocus
            id="filter"
            label="Keresés"
            value={filter}
            onChange={e => setFilter(e.target.value)}
            className={style.input}
          />
        </Grid>
      </Grid>

      {cards}
    </div>
  );
}

function mapStateToProps(state) {
  return {
    categories: selectors.getFoodCategories(state),
    selectedCategory: selectors.getSelectedFoodCategory(state),
    foodsByCategory: selectors.getFoodsBySelectedCategory(state),

    filter: selectors.getFoodsFilter(state),
    foodsByFilter: selectors.getFoodsByFilter(state),
  };
}

function mapDispatchToProps(dispatch) {
  return bindActionCreators(
    {
      selectCategory: actions.setSelectedCategory,
      setFilter: actions.setSearchFilter,
      resetFilterAndSelectedCategory: actions.resetFilterAndSelectedCategory,
      addFoodToOrder: actions.addFoodToOrder,
    },
    dispatch,
  );
}

const FoodsPropType = PropTypes.arrayOf(
  PropTypes.shape({
    id: PropTypes.string.isRequired,
    price: PropTypes.number.isRequired,
    category: PropTypes.string.isRequired,
    name: PropTypes.shape({
      en: PropTypes.string.isRequired,
      hu: PropTypes.string.isRequired,
    }),
  }),
);

FoodSelector.propTypes = {
  tableId: PropTypes.string.isRequired,
  categories: PropTypes.arrayOf(PropTypes.string).isRequired,
  selectedCategory: PropTypes.string.isRequired,
  foodsByCategory: FoodsPropType.isRequired,
  filter: PropTypes.string.isRequired,
  foodsByFilter: FoodsPropType.isRequired,

  selectCategory: PropTypes.func.isRequired,
  setFilter: PropTypes.func.isRequired,
  addFoodToOrder: PropTypes.func.isRequired,
  resetFilterAndSelectedCategory: PropTypes.func.isRequired,
};

export default connect(
  mapStateToProps,
  mapDispatchToProps,
)(FoodSelector);
