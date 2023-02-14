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

  createNewAlbum(newAlbum) {
   const newAlbumObject = {
    title: newAlbum.title,
    description: newAlbum.description,
    release_date: newAlbum.release_date,
    image: newAlbum.image
   };

   const headers = {
    'Authorization': `Bearer ${token}`,
    'content-type': 'multipart/form-data'
   };

   return axios.post(`${endpointUrl}/albums`, newAlbumObject, {headers});
  }

  deleteAlbum(albumId) {
    const headers = {
      'Authorization': `Bearer ${token}`,
     };  
     return axios.delete(`${endpointUrl}/albums/${albumId}`, {headers});
  }
}

export default new AlbumsService();