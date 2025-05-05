import { createRouter, createWebHistory } from 'vue-router';
import Login from '../pages/Login.vue';
import ProductList from '../pages/ProductList.vue';

const routes = [
  { path: '/login', component: Login },
  { path: '/', component: ProductList },
];

export default createRouter({
  history: createWebHistory(),
  routes,
});
