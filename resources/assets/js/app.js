
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
Vue.use(Vuetify)

Vue.component('wthr-root', require('./components/WthrRoot.vue'));
Vue.component('weather-view', require('./components/partials/WeatherView.vue'));
Vue.component('profile', require('./components/partials/Profile.vue'));


// Create Router

require ('./routing-config');
const router = new VueRouter({
    routes: routes(Vue) // short for `routes: routes`
})

const app = new Vue({
    router,
    el: '#app'
});
