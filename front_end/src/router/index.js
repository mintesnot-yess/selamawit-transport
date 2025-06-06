import { createRouter, createWebHashHistory } from "vue-router";
import Dashboard from "../pages/Dashboard.vue";
import Orders from "@/pages/Orders.vue";
import OrdersService from "@/services/OrdersService.vue";
import LogIn from "@/pages/Login.vue";
import Register from "@/pages/Register.vue";
import ForgotPassword from "@/pages/ForgotPassword.vue";
import ResetPassword from "@/pages/ResetPassword.vue";
import Banks from "@/pages/Banks.vue";
import BankAccounts from "@/pages/BankAccounts.vue";
import Vehicles from "@/pages/Vehicles.vue";
import VehiclesDetail from "@/pages/VehiclesDetail.vue";
import Clients from "@/pages/Clients.vue";
import Employees from "@/pages/Employees.vue";
import ExpenseTypes from "@/pages/ExpenseTypes.vue";
import Expenses from "@/pages/Expenses.vue";
import Locations from "@/pages/Locations.vue";
import LoadTypes from "@/pages/LoadTypes.vue";
import Logs from "@/pages/Logs.vue";
import RoleLayout from "@/layouts/roles/RoleLayout.vue";
import PermissionLayout from "@/layouts/permissions/PermissionLayout.vue";
import Users from "@/pages/Users.vue";


const routes = [
  {
    path: "/",
    name: "Dashboard",
    component: Dashboard,
    meta: { requiresAuth: true } // Requires authentication
  }, {
    path: "/users",
    name: "Users",
    component: Users,
    meta: { requiresAuth: true } // Requires authentication
  },
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
    meta: { requiresAuth: false } // Prevent if authenticated
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
  {
    path: "/banks",
    name: "Banks",
    component: Banks,
    meta: { requiresAuth: true } // Requires authentication
  },

  {
    path: "/bank-accounts/:id",
    name: "Bank Accounts",
    component: BankAccounts,
    meta: { requiresAuth: true } // Requires authentication
  },
  {
    path: "/vehicles",
    name: "Vehicles",
    component: Vehicles,
    meta: { requiresAuth: true } // Requires authentication
  },
  {
    path: "/vehicle/:id",
    name: "VehicleDetails",
    component: VehiclesDetail,
    meta: { requiresAuth: true } // Requires authentication
  },
  {
    path: "/clients",
    name: "Clients",
    component: Clients,
    meta: { requiresAuth: true } // Requires authentication
  },
  {
    path: "/employees",
    name: "Employees",
    component: Employees,
    meta: { requiresAuth: true } // Requires authentication
  },
  {
    path: "/expense_type",
    name: "Expense_type",
    component: ExpenseTypes,
    meta: { requiresAuth: true } // Requires authentication
  },
  {
    path: "/expense",
    name: "Expense",
    component: Expenses,
    meta: { requiresAuth: true } // Requires authentication
  },
  {
    path: "/location",
    name: "Location",
    component: Locations,
    meta: { requiresAuth: true } // Requires authentication
  },
  {
    path: "/load_types",
    name: "LoadTypes",
    component: LoadTypes,
    meta: { requiresAuth: true } // Requires authentication
  },
  {
    path: "/logs",
    name: "Logs",
    component: Logs,
    meta: { requiresAuth: true } // Requires authentication
  }, {
    path: "/new_role",
    name: "new_role",
    component: Logs,
    meta: { requiresAuth: true } // Requires authentication
  },
  {
    path: "/roles",
    name: "role",
    component: RoleLayout,
    meta: { requiresAuth: true } // Requires authentication
  },

  {
    path: "/permissions",
    name: "permissions",
    component: PermissionLayout,
    meta: { requiresAuth: true } // Requires authentication
  },



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