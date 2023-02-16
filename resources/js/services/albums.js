import axios from "axios";

const endpointUrl = "http://localhost:8000/api/albums";

const token = localStorage.getItem('token');

let headers = {
  'Authorization': `Bearer ${token}`,
}; 

class AlbumsService {
  getMyAlbums() {
    return axios.get(`${endpointUrl}`, { headers });
  }

  createAlbum(newAlbum) {
   const newAlbumObject = {
    title: newAlbum.title,
    description: newAlbum.description,
    release_date: newAlbum.release_date,
    image: newAlbum.image
   };

   headers['content-type'] = 'multipart/form-data';

   return axios.post(`${endpointUrl}`, newAlbumObject, { headers });
  }

  getAlbum(albumId) { 
    return axios.get(`${endpointUrl}/${albumId}`, { headers });
  }

  getAlbumSongs(albumId) {
    return axios.get(`${endpointUrl}/${albumId}/songs`, { headers });
  }

  editAlbum(editedAlbum, albumId) {
    const editedAlbumObject = {
      title: editedAlbum.title,
      description: editedAlbum.description,
      release_date: editedAlbum.release_date,
     };
    return axios.put(`${endpointUrl}/${albumId}`, editedAlbumObject, { headers });
  }

  deleteAlbum(albumId) {  
    return axios.delete(`${endpointUrl}/${albumId}`, { headers });
  }
}

export default new AlbumsService();