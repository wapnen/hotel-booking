/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue'
import VueRouter from 'vue-router'


Vue.use(VueRouter)
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

import App from './components/App'
import Home from './components/Home'
import Hotels from './components/hotel/Hotels'
import Hotel from './components/hotel/Hotel'
import Login from './components/auth/Login'
import RoomType from './components/roomType/RoomType'
import Price from './components/price/Prices'
import Booking from './components/hotel/Bookings'

const router = new VueRouter({
       mode: 'history',
       routes: [
           {
               path: '/',
               name: 'home',
               component: Home
           },
           {
               path: '/hotels',
               name: 'hotels',
               component: Hotels
           },
           {
               path: '/hotels/:hotel_id',
               name: 'hotel',
               component: Hotel
           },
           {
               path: '/roomtypes',
               name: 'roomTypes',
               component: RoomType
           },
           {
               path: '/prices',
               name: 'prices',
               component: Price
           },
           {
               path: '/bookings',
               name: 'bookings',
               component: Booking
           },
           {
               path: '/login',
               name: 'login',
               component: Login
           },
       ],
   });

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: { App },
    router,

});
