import { createRouter, createWebHistory } from 'vue-router';

import LoginView from './components/public/Login.vue';

import RegisterView from './components/public/Register.vue';

import MyAlbumsView from './components/private/albums/MyAlbums.vue';

import CreateAlbum from './components/private/albums/CreateAlbum.vue';

import EditAlbum from './components/private/albums/EditAlbum.vue';

import AlbumSongs from './components/private/albums/albumSongs/AlbumSongs.vue';

import AllGenres from './components/private/genres/AllGenres.vue';

import AllSongs from './components/private/songs/AllSongs.vue';

import NotFound from './components/public/NotFound.vue';

import store from './store';

const checkAuth = () => {
  const user = store.state.authStore.user;
  const isLoggedIn = store.state.authStore.status.loggedIn;

  if (!user || !isLoggedIn) return { path: '/'};
}

const router = createRouter({ 
  history: createWebHistory(),
  routes: [
    { path: '/', component: LoginView },
    { path: '/register', component: RegisterView },
    { path: '/my-albums', beforeEnter: checkAuth, children: [
      { path: '', component:MyAlbumsView },
      { path: 'create', component: CreateAlbum },
      { path: ':id', children: [
        { path: 'edit', component: EditAlbum, },
        { path: 'songs', component: AlbumSongs }
      ] }
    ] },
    { path: '/all-songs', component: AllSongs, beforeEnter: checkAuth },
    { path: '/all-genres', component: AllGenres, beforeEnter: checkAuth },
    { path: '/:pathMatch(.*)*', component: NotFound }
  ],
  linkActiveClass: 'active'
});

export default router;
