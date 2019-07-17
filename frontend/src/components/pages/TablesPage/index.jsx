import React from 'react';
import { Button } from '@material-ui/core';
import { Tables } from '../../containers';
import style from './style.module.scss';

function TablesPage() {
  return (
    <div className={style.container}>
      <Tables />
      <Button
        className={style.button}
        variant="outlined"
        color="secondary"
        href={process.env.REACT_APP_WP_ADMIN_URL}
      >
        Vissza az Wordpress adminra
      </Button>
    </div>
  );
}

export default TablesPage;
