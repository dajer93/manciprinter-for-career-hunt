import { normalize, schema } from 'normalizr';
import * as api from '../api';

const NO_INTERNET_CONNECTION =
  'Probléma van az internettel! Az alkalmazás nem tudja menteni a változásokat.';

export async function getFoods() {
  try {
    const { data } = await api.getFoods();

    const foodSchema = new schema.Entity('foods');
    const foodsSchema = [foodSchema];
    const normalizedData = normalize(data, foodsSchema);

    return { foods: normalizedData.entities.foods, ids: normalizedData.result };
  } catch (err) {
    throw new Error(NO_INTERNET_CONNECTION);
  }
}

export async function persistTables({ tables }) {
  try {
    const formData = new FormData();
    formData.set('state', JSON.stringify(tables));
    const { data } = await api.persistTables(formData);
    return data;
  } catch (err) {
    throw new Error(NO_INTERNET_CONNECTION);
  }
}

export async function getLastTables() {
  try {
    const { data } = await api.getLastTables();
    return data;
  } catch (err) {
    throw new Error(NO_INTERNET_CONNECTION);
  }
}
