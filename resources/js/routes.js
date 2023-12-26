import VueRouter from 'vue-router'

const Home = () => import('./components/Home.vue')
const Login = () => import('./components/Login.vue')
const Registro = () => import('./components/Registro.vue')
const Players = () => import('./components/Players.vue')
const Editar = () => import('./components/Editar.vue')

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home,
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'registro',
        path: '/registro',
        component: Registro
    },
    {
        name: 'editar',
        path: '/editar/:id',
        component: Editar
    },
    {
        name: 'players',
        path: '/players',
        component: Players
    }
    
]

