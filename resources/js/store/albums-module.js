import AlbumsService from '../services/albums';

let initialState = {
  myAlbums: []
}

export const albumsStore = {
  state: initialState,

  actions: {
    fetchMyAlbums({ commit }) {
      return AlbumsService.getMyAlbums().then(
        data => {
          return Promise.resolve(data);
        },
        error => {
          return Promise.reject(error);
        }
      );
    }
  },
}