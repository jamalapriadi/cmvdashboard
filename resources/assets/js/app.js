
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import VueRouter from 'vue-router';
Vue.use(VueRouter);

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

Vue.component('example-component', require('./components/ExampleComponent.vue'));


const routes=[
    {path:'/', name:'exampleComponent', component: require('./components/ExampleComponent.vue')},
    {path:'/passport-clients',name:'passportClientsComponent',component:require('./components/passport/Clients.vue')},
    {path:'/passport-authorized-clients',name:'passportAuthorizedClient',component:require('./components/passport/AuthorizedClients.vue')},

    {path:'/groups',name:'groups',component:require('./components/group/Groups.vue')},
    {path:'/add-new-group',name:'groupsAdd',component:require('./components/group/Add.vue')},
    {path:'/group/:id',name:'groupEdit',component:require('./components/group/Edit.vue')},
    
    {path:'/business-unit',name:'sosmedBu',component:require('./components/bu/Index.vue')},
    {path:'/add-new-business-unit', name:'sosmedBuAdd',component:require('./components/bu/Add.vue')},
    {path:'/business-unit/:id',name:'unitEdit',component:require('./components/bu/Edit.vue')},

    {path:'/sosmed',name:'sosmed',component:require('./components/sosmed/Index.vue')},
    {path:'/add-new-sosial-media',name:'sosmedAdd',component:require('./components/sosmed/Add.vue')},
    {path:'/sosmed/:id',name:'sosmedEdit',component:require('./components/sosmed/Edit.vue')},

    {path:'/program-unit',name:'sosmedProgramUnit',component:require('./components/program/Index.vue')},
    {path:'/add-new-program-unit',name:'programUnitAdd',component:require('./components/program/Add.vue')}
]

const router= new VueRouter({routes});

const app=new Vue({
    router
}).$mount("#app");

// const app = new Vue({
//     el: '#app'
// });
