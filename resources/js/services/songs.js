import axios from "axios";

const endpointUrl = "http://localhost:8000/api";

const token = localStorage.getItem('token');

let headers = {
  'Authorization': `Bearer ${token}`,
};

class SongsService {
  getAllSongs() {
    return axios.get(`${endpointUrl}/songs`, { headers });
  }
}

export default new SongsService();