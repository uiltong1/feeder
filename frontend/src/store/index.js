import { createStore } from 'vuex'
import $_users from "@/modules/user/_store"
import $_tags from "@/modules/tag/_store"
import $_posts from "@/modules/post/_store"


export default createStore({
  state: {
  },
  mutations: {
  },
  actions: {
  },
  modules: {
    $_users,
    $_tags,
    $_posts
  }
})
