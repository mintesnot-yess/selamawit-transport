import axios from 'axios';

const API_BASE_URL = 'http://localhost:8000/api'; // Replace with your actual API URL

const vehicleService = {
    async getAll(params = {}) {
        try {

            const response = await axios.get(`${API_BASE_URL}/vehicles`, {
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
    // async getById(id)


    // Create a new vehicle
    async store(vehicleData) {
        try {
            const formData = new FormData();
            for (const key in vehicleData) {
                formData.append(key, vehicleData[key]);
            }
            const response = await axios.post(`${API_BASE_URL}/vehicles`, vehicleData, {
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
    // Get a vehicle by ID
    async getById(id) {
        try {
            const response = await axios.get(`${API_BASE_URL}/vehicles/${id}`, {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
                }
            });
            return response.data;
        } catch (error) {
            throw this.handleError(error);
        }
    },



    // Update a vehicle by ID
    async update(id, vehicleData) {
        try {
            const formData = new FormData();
            for (const key in vehicleData) {
                formData.append(key, vehicleData[key]);
            }
            const response = await axios.post(`${API_BASE_URL}/vehicles/${id}?_method=PUT`, formData, {
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

    // Delete a vehicle by ID
    async delete(id) {
        try {
            const response = await axios.delete(`${API_BASE_URL}/vehicles/${id}`, {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
                }
            });
            return response.data;
        } catch (error) {
            throw this.handleError(error);
        }
    },


    handleError(error) {
        if (error.response && error.response.data && error.response.data.message) {
            return new Error(error.response.data.message);
        }
        return new Error(error.message || 'An unknown error occurred');
    }
}

export default vehicleService;
