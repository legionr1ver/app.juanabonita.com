import './bootstrap';
import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import global from './global';
import App from './../vue/App.vue';
import LoginView from './../vue/views/LoginView.vue';
import CargaPedidosView from './../vue/views/CargaPedidosView.vue';

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/', redirect: { name: 'login' } },
    { path: '/login', name: 'login', component: LoginView },
    { path: '/pedidos/carga', name: 'pedidos-carga', component: CargaPedidosView },
  ],
});

router.beforeEach((to,from) => {
  if( to.name === 'login' && global.user !== null ) return {name:'pedidos-carga'};
  if( to.name !== 'login' && global.user === null ) return {name:'login'};
});

const app = createApp(App);
app.use(router);
app.mount('#app');