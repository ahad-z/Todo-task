require('./bootstrap');
window.Vue = require('vue');
import VueRouter from 'vue-router'
import routes from './routes';
import toastr from 'toastr';


window.toastr = toastr

const router = new VueRouter({
    routes,
     mode: 'history'
})








Vue.use(VueRouter)


const app = new Vue({
    el: '#content',
    router
});


