import axios from 'axios';

const API_BASE_URL = 'http://localhost:8000/api'; // Replace with your actual API URL

const roleService = {
    // Get all roles
    // roleService.js

    async getAll(params = {}) {
        try {
            const response = await axios.get(`${API_BASE_URL}/roles`, {
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

    // Create a new role
    async store(roleData) {
        try {
            const token = localStorage.getItem('auth_token');
            if (!token) {
                throw new Error('Authentication token not found. Please log in again.');
            }
            const response = await axios.post(`${API_BASE_URL}/roles`, roleData, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });
            return response.data;
        } catch (error) {
            throw this.handleError(error);
        }
    },

    // Update a role
    async update(id, roleData) {
        try {
            const response = await axios.put(`${API_BASE_URL}/roles/${id}`, roleData, {
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
    // Get all permissions for a role
    async getPermissions(roleId) {
        try {
            const token = localStorage.getItem('auth_token');
            if (!token) {
                throw new Error('Authentication token not found. Please log in again.');
            }
            const response = await axios.get(`${API_BASE_URL}/roles/${roleId}/permissions`, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });
            return response.data;
        } catch (error) {
            throw this.handleError(error);
        }
    },

    // Assign permissions to a role
    // Assign permissions to a role
    async assignPermissions(roleId, permissions) {
        try {
            const token = localStorage.getItem('auth_token');
            if (!token) {
                throw new Error('Authentication token not found. Please log in again.');
            }
            const response = await axios.post(`${API_BASE_URL}/roles/${roleId}/permissions`, permissions, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });
            return response.data;
        } catch (error) {
            throw this.handleError(error);
        }
    },

    // Sync permissions (replace all existing permissions)
    async syncPermissions(roleId, permissions) {
        try {
            const token = localStorage.getItem('auth_token');
            if (!token) {
                throw new Error('Authentication token not found. Please log in again.');
            }
            const response = await axios.put(`${API_BASE_URL}/roles/${roleId}/permissions`, permissions, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });
            return response.data;
        } catch (error) {
            throw this.handleError(error);
        }
    },

    // Delete a role
    async delete(id) {
        try {
            const response = await axios.delete(`${API_BASE_URL}/roles/${id}`, {
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
            const response = await axios.get(`${API_BASE_URL}/roles/search`, {
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
    // multiple Delete a user
    async bulkDelete(ids) {
        try {
            const response = await axios.delete(`${API_BASE_URL}/roles/bulk`, {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
                },
                data: ids,


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
            return new Error(message || 'Role operation failed');
        } else if (error.request) {
            // The request was made but no response was received
            return new Error('No response from server. Please check your connection.');
        } else {
            // Something happened in setting up the request
            return new Error(error.message || 'Error configuring role request');
        }
    }
};

export default roleService;
