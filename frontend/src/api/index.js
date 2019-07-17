import axios from '../utils/axios';

if (window.wpApiSettings) {
  axios.defaults.headers.common['X-WP-Nonce'] = window.wpApiSettings.nonce;
}

export async function getFoods() {
  return axios.get('/foods');
}

export async function getLastTables() {
  return axios.get('/state');
}

export async function persistTables(state) {
  return axios.post('/state', state);
}
