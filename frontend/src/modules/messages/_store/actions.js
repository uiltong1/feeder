const setMessages = async (context, messages) => {
  context.commit("SET_MESSAGES", messages);
};

const destroyMessages = async (context) => {
  context.commit("SET_MESSAGES", []);
};

const setErrorsFormRequest = async (context, data) => {
  let errors = {
    type: "error",
    errors: [],
  };

  Object.entries(data).forEach(async (element) => {
    let feature = element[0].split(".");
    errors.errors.push({
      field: feature.length > 1 ? `${feature[0]}` : feature[0],
      error: element[1][0],
    });
  });
  errors.message = `Existe(m) ${errors.errors.length} campo(s) com erro(s) de preenchimento:`;
  context.commit("SET_MESSAGES", errors);
};

export default {
  setMessages,
  destroyMessages,
  setErrorsFormRequest,
};
