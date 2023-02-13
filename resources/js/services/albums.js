import axios from "axios";

const endpointUrl = "http://localhost:8000/api";

const token = localStorage.getItem('token');

class AlbumsService {
  getMyAlbums() {
    return axios.get(`${endpointUrl}/albums`, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    });
  }
}

export default new AlbumsService();