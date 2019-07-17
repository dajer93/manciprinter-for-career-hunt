import React from 'react';
import * as PropTypes from 'prop-types';
import { SnackbarContent, IconButton } from '@material-ui/core';
import { Error as ErrorIcon, Close as CloseIcon } from '@material-ui/icons';
import style from './style.module.scss';

function ErrorSnackbarContent({ error, onClose }) {
  return (
    <SnackbarContent
      className={style.backgroundColor}
      message={
        <span className={style.message}>
          <ErrorIcon className={style.icon} />
          {error}
        </span>
      }
      action={
        onClose && [
          <IconButton key="close" aria-label="Close" color="inherit" onClick={onClose}>
            <CloseIcon />
          </IconButton>,
        ]
      }
    />
  );
}

ErrorSnackbarContent.propTypes = {
  error: PropTypes.string.isRequired,
  onClose: PropTypes.func,
};

ErrorSnackbarContent.defaultProps = {
  onClose: undefined,
};

export default ErrorSnackbarContent;
