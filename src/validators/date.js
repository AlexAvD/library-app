export default {
  validate(value) {
    return /\d{4}-\d{2}-\d{2}/.test(value);
  },
  message: "The {_field_} not valid date",
};
