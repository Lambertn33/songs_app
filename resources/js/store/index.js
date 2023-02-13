import { createStore } from 'vuex';

import { authStore } from './auth-module';

import createPersistedState from "vuex-persistedstate";

const store = createStore({
  plugins: [createPersistedState()],
  modules: {
    authStore
  }
});

export default store;
