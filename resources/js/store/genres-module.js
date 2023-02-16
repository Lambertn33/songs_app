import GenresService from "../services/genres";

let initialState = {
  allGenres: []
}

export const genresStore = {
  state: initialState,
  
  actions: {
    fetchAllGenres({ commit }) {
      return GenresService.getAllGenres().then(
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