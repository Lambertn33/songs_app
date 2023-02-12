import { createStore } from 'vuex';

import { authStore } from './auth-module';

// Vue.use(Vuex);

// export default new Vuex.Store({
//   modules: {
//     authStore
//   }
// });
const store = createStore({
  modules: {
    authStore
  }
});

export default store;
