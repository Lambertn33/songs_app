import AlbumsService from '../services/albums';

let initialState = {
  myAlbums: []
}

export const albumsStore = {
  state: initialState,

  actions: {
    fetchMyAlbums() {
      return AlbumsService.getMyAlbums().then(
        data => {
          return Promise.resolve(data);
        },
        error => {
          return Promise.reject(error);
        }
      );
    },

    createAlbum({commit}, newAlbum) {
      return AlbumsService.createAlbum(newAlbum).then(
        data => {
          return Promise.resolve(data);
        },
        error => {
          return Promise.reject(error);
        }
      );
    },

    deleteAlbum({ commit }, albumId) {
      return AlbumsService.deleteAlbum(albumId).then(
        data => {
          return Promise.resolve(data);
        },
        error => {
          return Promise.reject(error);
        }
      );
    },

    getAlbum({ commit }, albumId) {
      return AlbumsService.getAlbum(albumId).then(
        data => {
          return Promise.resolve(data);
        },
        error => {
          return Promise.reject(error);
        }
      );
    },

    getAlbumSongs({ commit }, albumId) {
      return AlbumsService.getAlbumSongs(albumId).then(
        data => {
          return Promise.resolve(data);
        },
        error => {
          return Promise.reject(error);
        }
      );
    },

    editAlbum({ commit }, {editedAlbum, albumId}) {
      return AlbumsService.editAlbum(editedAlbum, albumId).then(
        data => {
          return Promise.resolve(data);
        },
        error => {
          return Promise.reject(error);
        }
      );
    }
  }
}