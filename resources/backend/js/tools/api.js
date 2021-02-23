import axios from 'axios';
import defined from './defined.js';

class Api {
  constructor() {
    this.unauthorized = [
      defined.response.UNAUTHORIZED,
      defined.response.TOKEN_INVALID,
      defined.response.TOKEN_EXPIRED
    ];
  }

  adminLogin(data) {
    return this.sendRequest("/admin/api/auth/login", "POST", false, data);
  }

  adminLogout() {
    return this.sendRequest("/admin/api/auth/logout", "POST", true);
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

    return promise;
  }
}

export default new Api();