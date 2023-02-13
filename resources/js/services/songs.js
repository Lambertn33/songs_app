import axios from "axios";

const endpointUrl = "http://localhost:8000/api";

const token = localStorage.getItem('token');

class SongsService {
  getAllSongs() {
    return axios.get(`${endpointUrl}/songs`, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    });
  }
}

export default new SongsService();