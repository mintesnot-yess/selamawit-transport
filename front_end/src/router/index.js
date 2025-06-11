import { createRouter, createWebHashHistory } from "vue-router";
import Dashboard from "../pages/Dashboard.vue";
import Orders from "@/pages/Orders.vue";
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
import OrdersLayout from "@/layouts/orders/OrdersLayout.vue";
import OrdersDetailsLayout from "@/layouts/orders/detail/OrdersDetailsLayout.vue";
import Forbidden from "@/layouts/auth/Forbidden.vue";
import { useUserStore } from "@/stores/userStore";
import { useProfileStore } from "@/stores/profile";
import userService from "@/services/users";
import auth from "@/services/auth";


const routes = [
  {
    path: "/",
    name: "Dashboard",
    component: Dashboard,
    meta: {
      requiresAuth: true,

      title: 'Dashboard'
    } // Requires authentication
  },
  {
    path: "/users",
    name: "Users",
    component: Users,
    meta: {
      requiresAuth: true,
      title: 'Users',


    } // Requires authentication
  },
  {
    path: "/login",
    name: "Login",
    component: LogIn,
    meta: { requiresAuth: false, isGuest: true } // Prevent if authenticated
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
    meta: {
      requiresAuth: true,
      title: 'Orders',
      requiredPermissions: ['view-order']



    } // Requires authentication
  },
  {
    path: "/orders/:id",
    name: "OrdersDetail",
    component: OrdersDetailsLayout,
    meta: { requiresAuth: true } // Requires authentication
  },

  {
    path: "/banks",
    name: "Banks",
    component: Banks,
    meta: { requiresAuth: true, title: 'Banks' } // Requires authentication
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
  {
    path: "/forbidden",
    name: "Forbidden",
    component: Forbidden,
    meta: { requiresAuth: false } // Requires authentication
  },
  { path: "/:catchAll(.*)", redirect: "/forbidden" }


];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});
router.beforeEach(async (to, from, next) => {
  const profileStore = useProfileStore();
  const token = localStorage.getItem('auth_token');

  if (to.meta.isGuest && token) {
    // If guest-only page and user is already logged in
    return next({ name: "Dashboard" });
  }

  if (to.meta.requiresAuth) {
    if (!token) {
      // Redirect to login if not authenticated
      return next({ name: "Login" });
    }

    try {
      // Fetch user data if not already loaded
      if (!profileStore.user || !profileStore.permissions) {
        await auth.fetchUser();
      }

      const userPermissions = profileStore.permissions || [];

      // Check required permissions
      const requiredPermissions = to.meta.requiredPermissions;

      if (requiredPermissions) {
        // Check if the user has at least one of the required permissions
        const hasPermission = requiredPermissions.some(perm => userPermissions.includes(perm));

        if (!hasPermission) {
          return next({ name: "Forbidden" });
        }
      }

      // Proceed to the route
      return next();

    } catch (error) {
      console.error("Failed to fetch user data:", error);
      return next({ name: "Login" });
    }
  }

  // For public routes, proceed
  next();
});

export default router;