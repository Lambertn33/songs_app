import AuthService from "../services/auth";

const user = JSON.parse(localStorage.getItem('user'));

const initialState = user
  ? { status: { loggedIn: true }, user }
  : { status: { loggedIn: false }, user: null };

  export const authStore = {
    namespaced: true,
    state: initialState,
    actions: {
      register({ commit }, user) {
        return AuthService.userRegistration(user).then(
          response => {
            commit('registerSuccess');
            return Promise.resolve(response.data);
          },
          error => {
            commit('registerFailure');
            return Promise.reject(error);
          }
        )
      }
    },

    mutations: {
      registerSuccess(state) {
        state.status.loggedIn = false;
      },
      registerFailure(state) {
        state.status.loggedIn = false;
      }
    }
  }

