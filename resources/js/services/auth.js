import axios from "axios";

const endpointUrl = "http://localhost:8000/api";

class AuthService {
  userRegistration(newUserData) {
    return axios.post(`${endpointUrl}/register`, {
      names: newUserData.names,
      email: newUserData.email,
      password: newUserData.password
    })
  }
}

export default new AuthService();