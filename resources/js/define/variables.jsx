import { openDB } from "idb";


export const baseUrl = "http://127.0.0.1:8000/react/";
export const baseUrl = "https://private.emlaksepette.com/react/";
export const frontEndUrl = "http://127.0.0.1:8000/";


export const dotNumberFormat = (number) => {
  if (number) {
    if (
      number
        ?.replace(".", "")
        .replace(".", "")
        .replace(".", "")
        .replace(".", "") !=
      parseInt(
        number
          ?.replace(".", "")
          .replace(".", "")
          .replace(".", "")
          .replace(".", "")
          .replace(".", "")
      )
    ) {
      return "";
    } else {
      var inputValue = number.replace(/\D/g, "");
      inputValue = inputValue.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

      return inputValue;
    }
  } else {
    return "";
  }
};

export const telNumberFormat = (input) => {
  const parsed = Number(input);
    return isNaN(parsed) ? 0 : parsed;
}


const dbPromise = openDB('large-data-db', 1, {
  upgrade(db) {
    if (!db.objectStoreNames.contains('large-data-store')) {
      db.createObjectStore('large-data-store');
    }
  },
});

export async function saveLargeData(key, data) {
  const db = await dbPromise;
  await db.put('large-data-store', data, key);
}

export async function getLargeData(key) {
  const db = await dbPromise;
  return await db.get('large-data-store', key);
}
