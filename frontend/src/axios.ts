import axios, {AxiosRequestConfig} from 'axios';

let config: AxiosRequestConfig = {
    baseURL: 'http://localhost:8000/api',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
    },
    validateStatus: (status) => {
        return status > 199 && status < 300
    }
};


const instance = axios.create(config);

instance.interceptors.request.use(config => {
    const token = localStorage.getItem('token');
    if (!token) {
        return config;
    }
    const parsedToken = JSON.parse(token);
    config.headers['Authorization'] = `Bearer ${parsedToken.authToken}`;
    config.headers['X-Refresh-Token'] = parsedToken.refreshToken;
    return config;
});

instance.interceptors.response.use(res => {
    const auth = res.data['auth'];
    if (auth) {
        localStorage.setItem('token', JSON.stringify({
            authToken: auth.token,
            refreshToken: auth.refreshToken
        }));
        localStorage.setItem('user', JSON.stringify(auth.user));
    }
    return res;

}, err => {
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    throw err;
});

export default instance;