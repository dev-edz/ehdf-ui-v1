import Vue from 'vue';
import VueRouter from 'vue-router';
import Dashboard from '../views/Dashboard.vue';
import Monitor from '../views/Monitor.vue'

Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    component: Dashboard,
    name: 'dashboard'
  },
  {
    path: '/monitor',
    component: Monitor,
    name: 'monitor'
  },
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes
});

export default router;
