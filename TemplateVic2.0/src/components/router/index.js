import { createRouter, createWebHistory } from 'vue-router'
import Home from "../Home.vue";
import FreeTemplate from "../FreeTemplate.vue";
import Register from '../Register.vue'
import PaidTemplate from "../PaidTemplate.vue";
import Contact from '../Contact.vue'
import Login from '../Login.vue'
import ViewAdmin from '../ViewAdmin.vue'
import Admin from '../Admin.vue'
import ViewUsers from '../ViewUsers.vue'
import Viewer from '../Viewer.vue'
import Preview from '../Preview.vue'



const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            name: 'ViewUsers',
            component: ViewUsers,
            children: [
                {
                    path: '', // Route par défaut pour `/`
                    component: Home,
                },
                {
                    path: 'FreeTemplate', // Chemin relatif
                    component: FreeTemplate,
                },
                {
                    path: 'PaidTemplate', // Chemin relatif
                    component: PaidTemplate,
                },
                {
                    path: 'Contact', // Chemin relatif 
                    component: Contact,
                },
            ]
        },
        {
            path: '/Viewer/:name',
            name: 'Viewer',
            component: Viewer
        },
        {
            path: '/Preview/:name',
            name: 'Preview',
            component: Preview
        }
        ,{
            path: '/Register',
            name: 'Register',
            component: Register
        },
        {
            path: '/Login',
            name: 'Login',
            component: Login
        },
        {
            path: '/ViewAdmin',
            name: 'ViewAdmin',
            beforeEnter:(to,from,next)=>{
                if (localStorage.getItem('token')) {
                    next()
                }else{
                    next('/Login')
                }
            },
            component: ViewAdmin,
            children: [
                {
                    path: '', // Route par défaut pour `/ViewAdmin`
                    component: Home,
                },
                {
                    path: 'FreeTemplate', // Chemin relatif
                    component: FreeTemplate,
                },
                {
                    path: 'PaidTemplate', // Chemin relatif
                    component: PaidTemplate,
                },
                {
                    path: 'Contact', // Chemin relatif
                    component: Contact,
                },
                {
                    path: 'Admin', // Chemin relatif
                    component: Admin,
                },
            ]
        }
    ]
});

export default router;
