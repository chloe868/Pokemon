import { createWebHistory, createRouter } from "vue-router";
import Login from "../components/Login.vue";
import Register from "../components/Register.vue";
import Dashboard from "../components/Dashboard.vue";
import Favorite from "../components/Favorite.vue";
import Like from "../components/Like.vue";
import Hate from "../components/Hate.vue";

const routes = [
  {
    path: "/login",
    name: "Login",
    component: Login,
  },
  {
    path: "/register",
    name: "Register",
    component: Register,
  },
  {
    path: "/",
    name: "Dashboard",
    component: Dashboard,
  },
  {
    path: "/favorite",
    name: "Favorite",
    component: Favorite,
  },
  {
    path: "/like",
    name: "Like",
    component: Like,
  },
  {
    path: "/hate",
    name: "Hate",
    component: Hate,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;