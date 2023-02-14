import axios from "axios";

const endpointUrl = "http://localhost:8000/api";

const token = localStorage.getItem('token');

class GenresService {
  getAllGenres() {
    return axios.get(`${endpointUrl}/albums/genres`, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    });
  }
}

export default new GenresService();