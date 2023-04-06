import { createRouter,createWebHashHistory } from "vue-router";


import PageHome from '../components/PageHome.vue'
import PageLogin from '../components/PageLogin.vue'
import PageRegister from '../components/PageRegister.vue'


const routes = [
    // {path: '/' , component : ApiList},

    
    {path: '/', component: PageHome},
    {path: '/login', component: PageLogin},
    {path: '/register', component: PageRegister}


]

const router = createRouter(
    {
        history : createWebHashHistory(),
        routes
    }
)

export default router;