import axios from "axios";

const endpointUrl = "http://localhost:8000/api";

const token = localStorage.getItem('token');

let headers = {
  'Authorization': `Bearer ${token}`,
}; 

class AlbumsService {
  getMyAlbums() {
    return axios.get(`${endpointUrl}/albums`, { headers });
  }

  createNewAlbum(newAlbum) {
   const newAlbumObject = {
    title: newAlbum.title,
    description: newAlbum.description,
    release_date: newAlbum.release_date,
    image: newAlbum.image
   };

   headers['content-type'] = 'multipart/form-data';

   return axios.post(`${endpointUrl}/albums`, newAlbumObject, { headers });
  }

  getSingleAlbum(albumId) { 
     return axios.get(`${endpointUrl}/albums/${albumId}`, { headers });
  }

  editAlbum(editedAlbum, albumId) {

  }

  deleteAlbum(albumId) {  
    return axios.delete(`${endpointUrl}/albums/${albumId}`, { headers });
  }
}

export default new AlbumsService();