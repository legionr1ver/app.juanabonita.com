import './bootstrap';
import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';

import global from './global';
import App from './../vue/App.vue';
import Header from './../vue/header/Header.vue';
import Nav from './../vue/nav/Nav.vue';
import Login from './../vue/login/Login.vue';
import Carga from './../vue/carga/Carga.vue';
import CargaCampania from './../vue/carga-campania/CargaCampania.vue';

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/', redirect: { name: 'login' } },
    { path: '/login', name: 'login', component: Login },
    { path: '/carga', name: 'carga', components: { default: Carga, Nav, Header } },
    { path: '/carga/:campania', name: 'carga.campania', components: { default: CargaCampania, Nav, Header } },
  ],
});

router.beforeEach((to,from) => {
  if( to.name === 'login' && global.user !== null ) return false;
  if( to.name !== 'login' && global.user === null ) return {name:'login'};
});

const app = createApp(App);
app.use(router);
app.mount('#app');