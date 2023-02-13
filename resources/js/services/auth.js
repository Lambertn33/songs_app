import axios from "axios";

const endpointUrl = "http://localhost:8000/api";

class AuthService {
  userRegistration(newUserData) {
    return axios.post(`${endpointUrl}/register`, {
      names: newUserData.names,
      email: newUserData.email,
      password: newUserData.password
    });
  }
  
  userLogin(loginData) {
    return axios.post(`${endpointUrl}/login`, {
      email: loginData.email,
      password: loginData.password
    });
  }

  userLogout() {
    let token = localStorage.getItem('token');
    return axios.post(`${endpointUrl}/logout`, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    });
  }
}

export default new AuthService();