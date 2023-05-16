import './bootstrap';
import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';

import global from './global';
import App from './../vue/App.vue';
import HeaderView from './../vue/views/HeaderView.vue';
import LoginView from './../vue/views/LoginView.vue';
import CargaView from './../vue/views/CargaView.vue';
import CargaCampaniaView from './../vue/views/CargaCampaniaView.vue';

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/', redirect: { name: 'login' } },
    { path: '/login', name: 'login', component: LoginView },
    { path: '/carga', name: 'carga', components: { default: CargaView, HeaderView } },
    { path: '/carga/:id', name: 'carga.campania', components: { default: CargaCampaniaView, HeaderView } },
  ],
});

router.beforeEach((to,from) => {
  if( to.name === 'login' && global.user !== null ) return false;
  if( to.name !== 'login' && global.user === null ) return {name:'login'};
});

const app = createApp(App);
app.use(router);
app.mount('#app');