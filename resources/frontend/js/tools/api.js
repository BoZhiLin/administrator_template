import axios from 'axios';
import defined from './defined.js';
import router from '../router/index.js';

// const api = axios.create({
//   headers: { Accept: "application/json" }
// });

// export const userLogin = data => api.post('/api/auth/login', data);

class Api {
  constructor() {
    this.unauthorized = [
      defined.response.UNAUTHORIZED,
      defined.response.TOKEN_INVALID,
      defined.response.TOKEN_EXPIRED
    ];
  }

  userLogin(data) {
    return this.sendRequest("/api/auth/login", "POST", false, data);
  }

  userInfo() {
    return this.sendRequest("/api/user/info", "GET", true);
  }

  getAnnouncemment(id) {
    return this.sendRequest(`/api/announcement/${id}`, "GET", true);
  }

  async sendRequest(url, method, withToken, body, queryString) {
    let headers = {
      Accept: "application/json"
    };

    if (withToken === true) {
      let token = localStorage["access_token"] || '';
      headers["Authorization"] = `bearer ${token}`;
    }

    const promise = await axios({
      url: url,
      method: method,
      data: body,
      headers: headers,
      params: queryString
    });

    // Token不合法就跳轉
    if (this.unauthorized.indexOf(promise.data.status) !== -1) {
      router.push({ name: 'login' });
    } else {
      return promise;
    }
  }
}

export default new Api();