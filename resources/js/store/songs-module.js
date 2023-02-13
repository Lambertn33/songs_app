import SongsService from "../services/songs";

let initialState = {
  allSongs: []
}

export const songsStore = {
  state: initialState,
  
  actions: {
    fetchAllSongs({ commit }) {
      return SongsService.getAllSongs().then(
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