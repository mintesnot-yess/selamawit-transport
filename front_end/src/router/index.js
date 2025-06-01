import { createRouter, createWebHashHistory } from "vue-router";
import Dashboard from "../pages/Dashboard.vue";
import Orders from "@/pages/Orders.vue";
import OrdersService from "@/services/OrdersService.vue";
import LogIn from "@/pages/Login.vue";
import Register from "@/pages/Register.vue";
import ForgotPassword from "@/pages/ForgotPassword.vue";
import ResetPassword from "@/pages/ResetPassword.vue";


const routes = [
  {
    path: "/",
    name: "Dashboard",
    component: Dashboard,
    meta: { requiresAuth: true } // Requires authentication
  },
  {
    path: "/orders",
    name: "Orders",
    component: Orders,
    meta: { requiresAuth: true } // Requires authentication
  },
  {
    path: "/orders-service",
    name: "OrdersService",
    component: OrdersService,
    meta: { requiresAuth: true } // Requires authentication
  },
  // Authentication routes
  {
    path: "/login",
    name: "Login",
    component: LogIn,
    meta: { requiresAuth: false, preventIfAuth: true } // Prevent if authenticated
  },
  {
    path: "/register",
    name: "Register",
    component: Register,
    meta: { requiresAuth: true } // Prevent if authenticated
  },
  {
    path: '/forgot-password',
    name: 'ForgotPassword',

    component: ForgotPassword,
    meta: { requiresAuth: false }
  },
  {
    path: '/reset-password',
    name: 'ResetPassword',
    component: ResetPassword,
    meta: { requiresAuth: false }
  }
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

// Navigation guard to check authentication
router.beforeEach((to, from, next) => {
  const isAuthenticated = localStorage.getItem('auth_token'); // Your auth check

  // Check if route is only for non-authenticated users
  if (to.meta.preventIfAuth && isAuthenticated) {
    next({ name: 'Dashboard' }); // Redirect to dashboard if logged in
    return;
  }

  // Check if route requires authentication
  if (to.meta.requiresAuth && !isAuthenticated) {
    next({ name: 'Login' }); // Redirect to login if not authenticated
    return;
  }

  // Otherwise proceed
  next();
});

export default router;