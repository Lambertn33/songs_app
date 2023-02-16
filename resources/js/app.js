import './bootstrap';

import { createApp } from 'vue';

import App from './App.vue';

import router from './router';

import TheNavbar from './components/nav/TheNavbar.vue';

import TheAlert from './components/reusable/TheAlert.vue';

import TheCard from './components/reusable/TheCard.vue';

import TheHeader from './components/reusable/TheHeader.vue';

import TheInput from './components/reusable/TheInput.vue';

import TextArea from './components/reusable/TextArea.vue';

import TheSpinner from './components/reusable/TheSpinner.vue';

import store  from './store';

import "bootstrap/dist/css/bootstrap.min.css";

import 'bootstrap/dist/js/bootstrap.bundle';

const app = createApp(App);

app.component('the-navbar', TheNavbar);

app.component('text-area', TextArea);

app.component('the-alert', TheAlert);

app.component('the-card', TheCard);

app.component('the-header', TheHeader);

app.component('the-input', TheInput);

app.component('the-spinner', TheSpinner);

app.use(router);

app.use(store);

app.mount('#app');
