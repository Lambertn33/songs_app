import './bootstrap';

import { createApp } from 'vue';

import App from './App.vue';

import { createRouter, createWebHistory } from 'vue-router';

import LoginView from './components/public/Login.vue';

import RegisterView from './components/public/Register.vue';

import TheNavbar from './components/nav/TheNavbar.vue';

import TheAlert from './components/reusable/Alert/TheAlert.vue';

import TheInput from './components/reusable/Form/TheInput.vue'

import store  from './store';

import "bootstrap/dist/css/bootstrap.min.css";

import 'bootstrap/dist/js/bootstrap.bundle';

const app = createApp(App);

const router = createRouter({ 
  history: createWebHistory(),
  routes: [
    { path: '/', component: LoginView },
    { path: '/register', component: RegisterView },
  ]
})

app.component('the-navbar', TheNavbar);

app.component('the-alert', TheAlert);

app.component('the-input', TheInput);

app.use(router);

app.use(store);

app.mount('#app');
