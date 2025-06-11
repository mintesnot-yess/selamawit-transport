import api from "@/api";
import { useProfileStore } from "@/stores/profile";

export default {
  async register(userData) {
    try {
      const response = await api.post("/register", userData);
      return response.data;
    } catch (error) {
      throw new Error(
        error.response?.data?.message ||
        error.response?.data?.errors ||
        "Registration failed",
      );
    }
  },


  async login(credentials) {
    try {
      const response = await api.post("/login", credentials);
      return response.data;
    } catch (error) {
      throw new Error(error.response?.data?.message || "Login failed");
    }
  },


  async logout() {
    try {
      await api.post("/logout");
    } catch (error) {
      console.error("Logout error:", error);
    } finally {
      // Clear local storage
      localStorage.removeItem("auth_token");
      localStorage.removeItem("user");

      // Remove axios authorization header
      delete api.defaults.headers.common["Authorization"];
      // Redirect to login page
      window.location.href = "/";

    }
  },

  setAuthToken(token) {
    localStorage.setItem("auth_token", token);
    api.defaults.headers.common["Authorization"] = `Bearer ${token}`;
  },

  isAuthenticated() {
    return !!localStorage.getItem("auth_token");
  },


  async fetchUser() {
    const token = localStorage.getItem("auth_token");
    if (!token) {
      throw new Error("Authentication required.");
    }

    try {
      const response = await api.get("/user");

      const profile = useProfileStore();
      profile.$patch({
        user: response.data.user,
        permissions: response.data.permissions
      });

      return response.data;
    } catch (error) {
      console.error("Fetch user error:", error);
      // Optionally dispatch logout
      // useAuthStore().logout();
      throw error;
    }
  }
};
