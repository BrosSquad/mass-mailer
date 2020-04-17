import Vue from "vue";
import VueRouter, { RouteConfig } from "vue-router";
import Dashboard from "../views/Dashboard.vue";
import Applications from "../views/Dashboard/Applications.vue";
import ApplicationKeys from "../views/Dashboard/ApplicationKeys.vue";
import Subscribers from "../views/Dashboard/Subscribers.vue";
import Messages from "../views/Dashboard/Messages.vue";
import Users from "../views/Dashboard/Users.vue";
import Profile from "../views/Profile.vue";
import Login from "../views/Auth/Login.vue";
import OAuth2Redirect from "../views/Auth/OAuth2Redirect.vue";

Vue.use(VueRouter);

const routes: Array<RouteConfig> = [
  {
    path: "/",
    name: "Dashboard",
    component: Dashboard,
    children: [
      { path: "/applications", component: Applications },
      { path: "/app-keys", component: ApplicationKeys },
      { path: "/subscribers", component: Subscribers },
      { path: "/messages", component: Messages },
      { path: "/users", component: Users },
    ],
  },
  {
    alias: "/dashboard",
    path: "/",
  },
  {
    path: "login",
    component: Login,
  },
  {
    path: "/profile",
    component: Profile,
  },
  {
    path: "/oauth-redirect",
    component: OAuth2Redirect,
  },
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
});

export default router;
