import Vuex from "vuex";
import Vue from "vue";
import user from "./modules/user";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    theme: {
      dark: false,
      drawerMini: false,
    },
  },
  mutations: {
    setTheme(state, payload) {
      // state.theme.dark = payload;
      // vuetify.framework.theme.dark = state.theme.dark;
    },
  },
  actions: {
    setTheme(context, payload) {
      context.commit("setTheme", payload.dark);
    },
  },
  modules: {
    user,
  },
});
