import axios from 'axios';

const API_BASE_URL = 'http://localhost:8000/api'; // Replace with your actual API URL

const orderService = {
    // Get all orders
    // orderService.js

    async getAll(params = {}) {
        try {
            const response = await axios.get(`${API_BASE_URL}/orders`, {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
                },
                params: {
                    page: params.page || 1,
                    per_page: params.perPage || 15, // Match your frontend default
                    search: params.search || ''
                }
            });

            // Transform response if needed
            const responseData = response.data;

            // If API returns data directly without meta wrapper
            if (Array.isArray(responseData)) {
                return {
                    data: responseData,
                    meta: {
                        current_page: 1,
                        per_page: params.perPage || 5,
                        total: responseData.length,
                        last_page: 1,
                        from: 1,
                        to: responseData.length
                    }
                };
            }

            // If API returns items/pagination instead of data/meta
            if (responseData.items && responseData.pagination) {
                return {
                    data: responseData.items,
                    meta: responseData.pagination
                };
            }

            // If already in correct format
            if (responseData.data && responseData.meta) {
                return responseData;
            }

            throw new Error('Unexpected API response format');

        } catch (error) {
            throw this.handleError(error);
        }
    },


    // Create a new order
    async store(orderData) {
        try {
            const response = await axios.post(`${API_BASE_URL}/orders`, orderData, {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
                    'Content-Type': 'application/json'
                }
            });
            return response.data;
        } catch (error) {
            throw this.handleError(error);
        }
    },

    // Update an order
    async update(id, orderData) {
        try {
            const response = await axios.put(`${API_BASE_URL}/orders/${id}`, orderData, {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
                    'Content-Type': 'application/json',

                }
            });
            return response.data;
        } catch (error) {
            throw this.handleError(error);
        }
    },

    // Delete an order
    async delete(id) {
        try {
            const response = await axios.delete(`${API_BASE_URL}/orders/${id}`, {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
                }
            });
            return response.data;
        } catch (error) {
            throw this.handleError(error);
        }
    },

    async search(params = {}) {
        try {
            const response = await axios.get(`${API_BASE_URL}/orders/search`, {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
                },
                params: {
                    q: params.query || '',
                    page: params.page || 1,
                    per_page: params.perPage || 15
                }
            });
            return response.data;
        } catch (error) {
            throw error.response?.data?.message || 'Search failed';
        }
    },
    async getOrderById(id) {
        try {
            const response = await axios.get(`${API_BASE_URL}/orders/${id}`, {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
                }
            });
            return response.data;
        } catch (error) {
            throw this.handleError(error);
        }
    },

    // Handle API errors
    handleError(error) {
        if (error.response) {
            // The request was made and the server responded with a status code
            const message = error.response.data?.message || error.response.statusText;
            return new Error(message || 'Order operation failed');
        } else if (error.request) {
            // The request was made but no response was received
            return new Error('No response from server. Please check your connection.');
        } else {
            // Something happened in setting up the request
            return new Error(error.message || 'Error configuring order request');
        }
    }
};

export default orderService;
