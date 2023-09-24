import { useStore } from '@/store/store'
import axios from 'axios'
import { inject } from 'vue'
import { RouteRecordRaw, createRouter, createWebHashHistory } from 'vue-router'

const routes: RouteRecordRaw[] = [
  {
    name: 'login',
    path: '/login',
    component: () => import('@views/login.vue'),
    meta: { require_auth: false },
  },
  {
    name: 'home',
    path: '/',
    component: () => import('@views/home.vue'),
    meta: { require_auth: true },
  },
  {
    name: 'user',
    path: '/user',
    component: () => import('@views/user.vue'),
    meta: { require_auth: true },
  },
  {
    name: 'group',
    path: '/group',
    component: () => import('@views/group.vue'),
    meta: { require_auth: true },
  },
  {
    name: 'profile',
    path: '/profile',
    component: () => import('@views/profile.vue'),
    meta: { require_auth: true },
  },
  {
    name: 'search',
    path: '/search',
    component: () => import('@views/search.vue'),
    meta: { require_auth: true },
  },
]

const router = createRouter({
  routes,
  history: createWebHashHistory(),
})

router.beforeEach(async (to, _from, next) => {
  const store = useStore()
  const http = inject('http', axios)
  if (to.meta.require_auth) {
    try {
      const { data } = await http.get<User>('me')
      store.setUser(data)
      return next()
    } catch ({ response }: any) {
      return next({ name: 'login' })
    }
  }
  next()
})

export default router
