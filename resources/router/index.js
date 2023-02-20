import { createWebHistory, createRouter } from "vue-router";
import Login from "../components/Login.vue";
import Register from "../components/Register.vue";
import Dashboard from "../components/Dashboard.vue";
import Favorite from "../components/Favorite.vue";
import Like from "../components/Like.vue";
import Hate from "../components/Hate.vue";
import UserInfo from "../components/UserInformation.vue";
import AUTH from '../services/auth'

function checkUser(to, from, next) 
{
  let loggedIn = false
  if (AUTH.userId != null && AUTH.token != null){
    loggedIn = true
  }
  if(loggedIn){
    if(to.path === '/' || to.meta.tokenRequired === false){
      next("/dashboard")
    }else{
      next()
    }
  }else{
    if(to.path === '/' || to.meta.tokenRequired === true){
      next("/login")
    }else{
      next()
    }
  }
}

const routes = [
  {
    path: "/",
    name: "Home",
    meta: {
      tokenRequired: false
    },
    beforeEnter: checkUser
  },
  {
    path: "/login",
    name: "Login",
    component: Login,
    meta: {
      tokenRequired: false
    },
    beforeEnter: checkUser
  },
  {
    path: "/register",
    name: "Register",
    component: Register,
    meta: {
      tokenRequired: false
    },
    beforeEnter: checkUser
  },
  {
    path: "/dashboard",
    name: "Dashboard",
    component: Dashboard,
    meta: {
      tokenRequired: true
    },
    beforeEnter: checkUser
  },
  {
    path: "/favorite",
    name: "Favorite",
    component: Favorite,
    meta: {
      tokenRequired: true
    },
    beforeEnter: checkUser
  },
  {
    path: "/like",
    name: "Like",
    component: Like,
    meta: {
      tokenRequired: true
    },
    beforeEnter: checkUser
  },
  {
    path: "/hate",
    name: "Hate",
    component: Hate,
    meta: {
      tokenRequired: true
    },
    beforeEnter: checkUser
  },
  {
    path: "/user-info",
    name: "User Info",
    component: UserInfo,
    meta: {
      tokenRequired: true
    },
    beforeEnter: checkUser
  },
  {
    path: '/:pathMatch(.*)*',
    redirect: "/"
},
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;