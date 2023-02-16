import { createStore } from 'vuex';

import { authStore } from './auth-module';

import { albumsStore } from './albums-module';

import { genresStore } from './genres-module';

import { songsStore } from './songs-module';

import createPersistedState from "vuex-persistedstate";

const store = createStore({
  plugins: [createPersistedState()],
  modules: {
    authStore,
    albumsStore,
    genresStore,
    songsStore
  }
});

export default store;
