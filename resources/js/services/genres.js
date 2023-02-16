import axios from "axios";

const endpointUrl = "http://localhost:8000/api";

const token = localStorage.getItem('token');

let headers = {
  'Authorization': `Bearer ${token}`,
};

class GenresService {
  getAllGenres() {
    return axios.get(`${endpointUrl}/albums/genres`, { headers });
  }
}

export default new GenresService();