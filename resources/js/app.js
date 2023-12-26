require('./bootstrap');
import vue from 'vue'
window.Vue = vue;

import App from './components/App.vue';

//importamos Axios
import VueAxios from 'vue-axios';
import axios from 'axios';

//Importamos y configuramos el Vue-router
import VueRouter from 'vue-router';
import {routes} from './routes';
 
Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.config.productionTip = false
 
const router = new VueRouter({
    mode: 'history',
    routes: routes
});


router.beforeEach((to, from, next) => {
    // ...
    // explicitly return false to cancel the navigation
    
    if(to.matched.some(route=> route.meta.requiresAuth)){
        console.log(localStorage.auth)
        if(localStorage.auth == "undefined" || localStorage.auth === "false"){
            next({ name: 'login' })    
        }else{
            next()
        }

    }else{
        next()
    }
   
  })
 
//finalmente, definimos nuestra app de Vue
const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App),
});