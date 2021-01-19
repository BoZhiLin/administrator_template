import axios from 'axios';

const api = axios.create({
    headers: { Accept: "application/json" }
});

export const userLogin = data => api.post('/api/auth/login', data);