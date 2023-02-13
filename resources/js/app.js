import './bootstrap';

import { createApp } from 'vue';

import App from './App.vue';

import { createRouter, createWebHistory } from 'vue-router';

import LoginView from './components/public/Login.vue';

import RegisterView from './components/public/Register.vue';

import MyAlbumsView from './components/private/albums/MyAlbums.vue';

import TheNavbar from './components/nav/TheNavbar.vue';

import TheAlert from './components/reusable/Alert/TheAlert.vue';

import TheInput from './components/reusable/Form/TheInput.vue';

import TheSpinner from './components/reusable/Spinner/TheSpinner.vue';

import NotFound from './components/public/NotFound.vue';

import store  from './store';

import "bootstrap/dist/css/bootstrap.min.css";

import 'bootstrap/dist/js/bootstrap.bundle';

const app = createApp(App);

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
    { path: '/my-albums', component: MyAlbumsView, beforeEnter: checkAuth },
    { path: '/:pathMatch(.*)*', component: NotFound }
  ]
});

app.component('the-navbar', TheNavbar);

app.component('the-alert', TheAlert);

app.component('the-input', TheInput);

app.component('the-spinner', TheSpinner);

app.use(router);

app.use(store);

app.mount('#app');
