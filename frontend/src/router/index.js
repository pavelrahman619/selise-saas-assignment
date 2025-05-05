import { createRouter, createWebHistory } from 'vue-router';
import Login from '../pages/Login.vue';
import ProductList from '../pages/ProductList.vue';
import EmployeeDashboard from '../pages/EmployeeDashboard.vue';

const routes = [
  { path: '/login', component: Login },
  // { path: '/', component: ProductList },
  { path: '/', redirect: '/employees' },
  { path: '/employees', component: EmployeeDashboard },
];

export default createRouter({
  history: createWebHistory(),
  routes,
});
