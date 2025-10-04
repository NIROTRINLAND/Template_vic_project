import axios from 'axios'

// Create an Axios instance
export const apiClient = axios.create({
    baseURL: 'http://localhost:8000/api',
});

// Add a request interceptor
apiClient.interceptors.request.use(config => {
    // Dynamically add headers
    config.headers['Authorization'] = 'Bearer ' + localStorage.getItem('token')
    config.headers['Access-Control-Allow-Origin'] = '*'
    return config;
}, error => {
    return Promise.reject(error);
});