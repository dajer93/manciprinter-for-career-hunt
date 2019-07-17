import React from 'react';
import { Card, CardContent, Typography } from '@material-ui/core';
import * as PropTypes from 'prop-types';
import style from './style.module.scss';

function SimpleCard({ text, className, onClick }) {
  const card = (
    <Card className={style.card}>
      <CardContent className={className}>
        <Typography align="center">{text}</Typography>
      </CardContent>
    </Card>
  );

  if (onClick) {
    return (
      <button type="button" onClick={onClick} className={style.button}>
        {card}
      </button>
    );
  }
  return card;
}

SimpleCard.propTypes = {
  text: PropTypes.string,
  className: PropTypes.string,
  onClick: PropTypes.func,
};

SimpleCard.defaultProps = {
  text: '',
  className: '',
  onClick: undefined,
};

export default SimpleCard;
