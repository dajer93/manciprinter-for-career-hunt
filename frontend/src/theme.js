import { createMuiTheme } from '@material-ui/core/styles';

const colors = {
  main: '#303030',
  pastel: '#c5ab6b',
};

export default createMuiTheme({
  typography: {
    useNextVariants: true,
    fontFamily: ['Open Sans', 'Helvetica', 'Arial', 'Lucida,sans-serif'].join(','),
    fontSize: '14px',
  },
  palette: {
    primary: {
      main: colors.main,
    },
    secondary: {
      main: colors.pastel,
    },
  },
});
