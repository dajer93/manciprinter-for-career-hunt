import React from 'react';
import { Grid, Divider, List, ListItem } from '@material-ui/core';
import * as PropTypes from 'prop-types';
import uuid from 'uuid/v1';
import Logo from '../../../assets/manci_logo_2.png';
import style from './style.module.scss';

/**
 * This is not a functional component because this is a printable component and
 * `react-to-print` requires class components.
 */
// eslint-disable-next-line react/prefer-stateless-function
class Receipt extends React.Component {
  render() {
    const { locale, orders, total } = this.props;

    const goodBye =
      locale === 'hu' ? (
        <>
          <Grid item>Köszönjük!</Grid>
          <Grid item>Reméljük hamarosan újra látunk!</Grid>
        </>
      ) : (
        <>
          <Grid item>Thank you!</Grid>
          <Grid item>We hope to see you soon again!</Grid>
        </>
      );

    const mappedFoods = orders.map(f =>
      locale === 'hu'
        ? { id: uuid(), name: f.name.hu, price: f.price, amount: f.amount }
        : { id: uuid(), name: f.name.en, price: f.price, amount: f.amount },
    );

    return (
      <Grid
        container
        direction="column"
        justify="flex-start"
        alignItems="center"
        className={style.container}
      >
        <Grid item>
          <img className={style.logo} src={Logo} alt="Vas Manci Logo" />
        </Grid>
        <Grid item className={style.title}>
          Vas Manci
        </Grid>
        <Grid item className={style.address}>
          1088 Budapest, Vas utca 3
        </Grid>
        <Grid item className={style.phone}>
          Tel: +36 20 800 8953
        </Grid>
        <Grid item className={style.web}>
          www.vasmanci.hu
        </Grid>

        <Grid item className={style.list}>
          <List className={style.container}>
            <Divider className={style.divider} />

            {mappedFoods.map(f => (
              <ListItem key={f.id}>
                <Grid container direction="row" justify="space-between" alignItems="flex-start">
                  <Grid className={style.fixedWidth} item>
                    {f.name} {f.amount > 1 ? ` x${f.amount}` : ''}
                  </Grid>
                  <Grid item>{f.price * f.amount} Ft</Grid>
                </Grid>
              </ListItem>
            ))}

            <Divider className={style.divider} />

            <ListItem>
              <Grid
                container
                direction="row"
                justify="space-between"
                alignItems="flex-start"
                className={style.total}
              >
                <Grid item>{locale === 'hu' ? 'Összesen' : 'Total'}</Grid>
                <Grid item>{total} Ft</Grid>
              </Grid>
            </ListItem>

            <Divider className={style.divider} />
          </List>
        </Grid>

        {goodBye}
      </Grid>
    );
  }
}

Receipt.propTypes = {
  orders: PropTypes.arrayOf(
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
  locale: PropTypes.string,
  total: PropTypes.number.isRequired,
};

Receipt.defaultProps = {
  locale: 'hu',
};

export default Receipt;
