// src/services/orderService.js
import api from "@/api";

export default {
  async getAllOrders() {
    try {
      const response = await api.get("/orders");
      return response.data;
    } catch (error) {
      console.error("Error fetching orders:", error);
      throw error;
    }
  },

  async getOrderById(id) {
    try {

      const response = await api.get(`/orders/${id}`);
      return response.data;

    } catch (error) {
      console.error(`Error fetching order ${id}:`, error);
      throw error;
    }
  },
};
