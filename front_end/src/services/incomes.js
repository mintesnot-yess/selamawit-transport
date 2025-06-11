import axios from 'axios';

const API_BASE_URL = 'http://localhost:8000/api'; // Replace with your actual API URL

const incomeService = {
    /**
     * Get all incomes with optional pagination and filters
     */
    async getAll(params = {}) {
        try {
            const response = await axios.get(`${API_BASE_URL}/incomes`, {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
                },
                params: {
                    page: params.page || 1,
                    per_page: params.perPage || 15,
                    search: params.search || ''
                }
            });

            const responseData = response.data;

            if (Array.isArray(responseData)) {
                return {
                    data: responseData,
                    meta: {
                        current_page: 1,
                        per_page: params.perPage || 15,
                        total: responseData.length,
                        last_page: 1,
                        from: 1,
                        to: responseData.length
                    }
                };
            }

            if (responseData.items && responseData.pagination) {
                return {
                    data: responseData.items,
                    meta: responseData.pagination
                };
            }

            if (responseData.data && responseData.meta) {
                return responseData;
            }

            throw new Error('Unexpected API response format');
        } catch (error) {
            throw this.handleError(error);
        }
    },

    /**
     * Create a new income
     */
    async store(incomeData) {
        try {
            const response = await axios.post(`${API_BASE_URL}/incomes`, incomeData, {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
                    'Content-Type': 'multipart/form-data'
                }
            });
            return response.data;
        } catch (error) {
            throw this.handleError(error);
        }
    },

    /**
     * Update an income by ID
     */
    async update(id, incomeData) {
        try {
            const response = await axios.put(`${API_BASE_URL}/incomes/${id}`, incomeData, {
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

    /**
     * Delete an income by ID
     */
    async delete(id) {
        try {
            const response = await axios.delete(`${API_BASE_URL}/incomes/${id}`, {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
                }
            });
            return response.data;
        } catch (error) {
            throw this.handleError(error);
        }
    },

    /**
     * Search incomes
     */
    async search(params = {}) {
        try {
            const response = await axios.get(`${API_BASE_URL}/incomes/search`, {
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

    /**
     * Get income by ID
     */
    async getIncomeById(id) {
        try {
            const response = await axios.get(`${API_BASE_URL}/incomes/${id}`, {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
                }
            });
            return response.data;
        } catch (error) {
            throw this.handleError(error);
        }
    },

    /**
     * Handle errors consistently
     */
    handleError(error) {
        if (error.response) {
            const message = error.response.data?.message || error.response.statusText;
            return new Error(message || 'Income operation failed');
        } else if (error.request) {
            return new Error('No response from server. Please check your connection.');
        } else {
            return new Error(error.message || 'Error configuring income request');
        }
    }
};

export default incomeService;