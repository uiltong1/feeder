import Api from "../_api";

const index = async (context, params) => {
    const { data } = await Api.index(params)
    context.commit("SET_TAGS", data)
}

const get = async (context, id) => {
    const { data } = await Api.get(id)
    context.commit("SET_TAG", data)
}

const store = async (context, params) => {
    const { data } = await Api.store(params)
    context.commit("SET_TAG", data)
}

const update = async (context, params) => {
    const { data } = await Api.update(params)
    context.commit("SET_TAG", data)
}

const remove = async (context, id) => {
    await Api.remove(id)
}

export default {
    index,
    get,
    store,
    update,
    remove
};
