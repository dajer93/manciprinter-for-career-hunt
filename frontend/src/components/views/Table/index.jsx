import React from 'react';
import * as PropTypes from 'prop-types';
import { Link } from 'react-router-dom';
import style from './style.module.scss';
import CardWithText from '../SimpleCard';

function Table({ tableNumber, isTaken, tableName }) {
  return (
    <Link to={`tables/${tableNumber}`} className={`${style.link}`}>
      <CardWithText className={isTaken ? style.isTaken : ''} text={`#${tableName}`} />
    </Link>
  );
}

Table.propTypes = {
  tableNumber: PropTypes.string.isRequired,
  tableName: PropTypes.string.isRequired,
  isTaken: PropTypes.bool.isRequired,
};

export default Table;
