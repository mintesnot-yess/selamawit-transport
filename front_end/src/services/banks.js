import axios from 'axios';

const API_BASE_URL = 'http://localhost:8000/api'; // Replace with your actual API URL

const bankService = {
    // Get all banks
    // bankService.js
    async getAll(params = {}) {
        try {
            const response = await axios.get(`${API_BASE_URL}/banks`, {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
                },
                params: {
                    page: params.page || 1,
                    per_page: params.perPage || 10,
                    search: params.search || ''
                }
            });
            return response.data; // Ensure this returns { data: [], meta: {} } structure
        } catch (error) {
            throw this.handleError(error);
        }
    },

    async search(params = {}) {
        try {
            const response = await axios.get(`${API_BASE_URL}/banks/search`, {
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

    // Create a new bank
    async store(bankData) {
        try {
            const response = await axios.post(`${API_BASE_URL}/banks`, bankData, {
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

    // Update a bank
    async update(id, bankData) {
        try {
            const response = await axios.put(`${API_BASE_URL}/banks/${id}`, bankData, {
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

    // Delete a bank
    async delete(id) {
        try {
            const response = await axios.delete(`${API_BASE_URL}/banks/${id}`, {
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
            return new Error(message || 'Bank operation failed');
        } else if (error.request) {
            // The request was made but no response was received
            return new Error('No response from server. Please check your connection.');
        } else {
            // Something happened in setting up the request
            return new Error(error.message || 'Error configuring bank request');
        }
    }
};

export default bankService;

