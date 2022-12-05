import { createWebHistory, createRouter } from "vue-router";
import home from "./pages/home.vue";
import login from "./pages/login.vue";
import register from "./pages/register.vue";
import forgotPassword from "./pages/forgot-password.vue";
import changePassword from "./pages/change-password.vue";

const routes = [
    {
        path: "/",
        name: "Home",
        component: home,
    },
    {
        path: "/register",
        name: "Register",
        component: register,
    },
    {
        path: "/login",
        name: "Login",
        component: login,
    },
    {
        path: "/forgot-password",
        name: "ForgotPassword",
        component: forgotPassword
    },
    {
        path: "/password/reset",
        name: "ChangePassword",
        component: changePassword
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
