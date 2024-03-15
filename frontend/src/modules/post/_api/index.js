import Api from "../../../api";
const route = "posts";

const index = async (params) => {
    return await Api.get(route, {
        params: {
            ...params
        }
    })
};

const get = async (id) => {
    return await Api.get(`${route}/${id}`)
};

const store = async (params) => {
    return await Api.post(route, params)
};

const update = async (params) => {
    return await Api.put(`${route}/${params.id}`, params)
};

const remove = async (id) => {
    return await Api.delete(`${route}/${id}`)
}

export default {
    index,
    get,
    store,
    update,
    remove
};
