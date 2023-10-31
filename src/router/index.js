import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component:  () => import('../views/home.vue')
    },
    {
      path: '/analysis',
      name: 'analysis',
      component: () => import('../views/analysis.vue')
    },
    {
      path: '/bank',
      name: 'bank',
      component: () => import('../views/bank.vue')
    },
    {
      path: '/daydetail',
      name: 'daydetail',
      component: () => import('../views/daydetail.vue')
    }
  ]
})

export default router
