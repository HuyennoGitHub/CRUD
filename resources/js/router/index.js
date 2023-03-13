import { createRouter, createWebHistory } from 'vue-router'

import productIndex from '../components/products/index.vue'
import productNew from '../components/products/new.vue'
import productUpdate from '../components/products/edit.vue'
import productSearch from '../components/products/search.vue'
import notFound from '../components/notFound.vue'
const routes = [
    {
        path:'/',
        component: productIndex
    },
    {
        path:'/product/search',
        component: productSearch
    },
    {
        path:'/product/new',
        component: productNew
    },
    {
        path:'/product/edit/:id',
        component: productUpdate,
        props:true
    },
    {
        path:'/:pathMatch(.*)*',
        component:notFound
    }

]

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes,
})
export default router