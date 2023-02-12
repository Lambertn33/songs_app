import './bootstrap';

import { createApp } from 'vue';

import App from './App.vue';

import { createRouter, createWebHistory } from 'vue-router';

import LoginView from './components/public/Login.vue';

import RegisterView from './components/public/Register.vue';

import TheNavbar from './components/nav/TheNavbar.vue';

import "bootstrap/dist/css/bootstrap.min.css";

const app = createApp(App);

const router = createRouter({ 
  history: createWebHistory(),
  routes: [
    { path: '/', component: LoginView },
    { path: '/register', component: RegisterView },
  ]
})

app.component('the-navbar', TheNavbar);

app.use(router);

app.mount('#app');
