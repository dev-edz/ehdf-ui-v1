import Vue from 'vue';
import VueRouter from 'vue-router';
import Dashboard from '../views/Dashboard.vue';
import Monitoring from '../views/Monitoring.vue'
import Users from '../views/Users.vue'

Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    component: Dashboard,
    name: 'dashboard'
  },
  {
    path: '/monitoring',
    component: Monitoring,
    name: 'monitoring'
  },
  {
    path: '/users',
    component: Users,
    name: 'users'
  },
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes
});

export default router;
