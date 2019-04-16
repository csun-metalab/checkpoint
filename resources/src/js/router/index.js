import Vue from 'vue';
import VueRouter from 'vue-router';
import store from '../store';

import SignUp from './views/signup/index.vue'
import Login from './views/login/index.vue'

// INIT VUE-ROUTER
Vue.use(VueRouter);

// ROUTER MAP
const router = new VueRouter({
  routes: [
    {
      path: '/signup',
      component: SignUp,
      name: 'SignUp'
    },
    {
      path: '/login',
      component: Login,
      name: 'Login'
    }
  ],
});

export default router;