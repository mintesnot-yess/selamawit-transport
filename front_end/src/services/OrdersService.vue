<template>
  <div class="orders-container">
    <h2>Orders List</h2>

    <!-- Loading state -->
    <div v-if="loading" class="loading">
      Loading orders...
    </div>

    <!-- Error state -->
    <div v-if="error" class="error">
      Error loading orders: {{ error.message }}
    </div>

    <!-- Orders table -->
    <table v-if="orders.length > 0" class="orders-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Customer</th>
          <th>Vehicle</th>
          <th>Load Type</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="order in orders" :key="order.id">
          <td>{{ order.id }}</td>
          <td>{{ order.customer.name }}</td>
          <td>{{ order.vehicle.plate_number }}</td>
          <td>{{ order.load_type.name }}</td>
          <td>
            <span :class="`status-badge ${order.status.toLowerCase()}`">
              {{ order.status }}
            </span>
          </td>
          <td>
            <router-link :to="{ name: 'OrderDetail', params: { id: order.id } }" class="btn btn-view">
              View
            </router-link>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Pagination -->
    <div v-if="meta && meta.total > meta.per_page" class="pagination">
      <button @click="fetchOrders(meta.current_page - 1)" :disabled="meta.current_page === 1">
        Previous
      </button>
      <span>Page {{ meta.current_page }} of {{ meta.last_page }}</span>
      <button @click="fetchOrders(meta.current_page + 1)" :disabled="meta.current_page === meta.last_page">
        Next
      </button>
    </div>
  </div>
</template>

<script>
import orderService from '@/services/orderService';

export default {
  name: 'OrdersList',
  data() {
    return {
      orders: [],
      loading: false,
      error: null,
      meta: null
    };
  },
  created() {
    this.fetchOrders();
  },
  methods: {
    async fetchOrders(page = 1) {
      this.loading = true;
      this.error = null;

      try {
        const response = await orderService.getAllOrders({
          page: page
        });

        this.orders = response.data;
        this.meta = response.meta;
      } catch (error) {
        this.error = error;
      } finally {
        this.loading = false;
      }
    }
  }
};
</script>

<style scoped>
.orders-container {
  padding: 20px;
}

.orders-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.orders-table th,
.orders-table td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

.orders-table th {
  background-color: #f2f2f2;
}

.status-badge {
  padding: 4px 8px;
  border-radius: 4px;
  font-size: 0.8em;
  color: white;
}

.status-badge.pending {
  background-color: #ffc107;
}

.status-badge.completed {
  background-color: #28a745;
}

.status-badge.cancelled {
  background-color: #dc3545;
}

.loading {
  padding: 20px;
  text-align: center;
}

.error {
  color: #dc3545;
  padding: 20px;
  text-align: center;
}

.pagination {
  margin-top: 20px;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 10px;
}

.btn {
  padding: 5px 10px;
  border-radius: 4px;
  text-decoration: none;
  color: white;
}

.btn-view {
  background-color: #17a2b8;
}
</style>
