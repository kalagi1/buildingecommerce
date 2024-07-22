

export const baseUrl = "http://private.emlaksepette.com/react/";
export const frontEndUrl = "http://private.emlaksepette.com/";


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
