import axios from 'axios';

const Login = axios.create({
    headers: { Accept: "application/json" }
});

export const userLogin = data => Login.post('/api/auth/login', data);