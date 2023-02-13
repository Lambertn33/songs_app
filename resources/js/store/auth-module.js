import AuthService from "../services/auth";

import VueJwtDecode from 'vue-jwt-decode';

const user = JSON.parse(localStorage.getItem('user'));

const initialState = user
  ? { status: { loggedIn: true }, user, token }
  : { status: { loggedIn: false }, user: null, token: null };

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
      },

      login({ commit }, loginData) {
        return AuthService.userLogin(loginData).then(
          data => {
            commit('loginSuccess', data);
            return Promise.resolve(data);
          },
          error => {
            commit('loginFailure');
            return Promise.reject(error);
          }
        )
      },

      logout({ commit }) {
        return AuthService.userLogout().then(
          data => {
            commit('logoutSuccess');
          },
          error => {
            return Promise.reject(error);
          }
        )
      }
    },

    mutations: {
      loginSuccess(state, response) {
        const authToken = response.data.authorisation.token;
        const decodedToken = VueJwtDecode.decode(authToken);
        const user = decodedToken.user;
        state.status.loggedIn = true;
        state.user = user;
        state.token = decodedToken;
        localStorage.setItem('token', authToken);
      },
      loginFailure(state) {
        state.status.loggedIn = false;
        state.user = null;
      },
      logoutSuccess(state) {
        state.status.loggedIn = false;
        state.user = null;
        localStorage.removeItem('token');
      },
      registerSuccess(state) {
        state.status.loggedIn = false;
      },
      registerFailure(state) {
        state.status.loggedIn = false;
      },
      logoutSuccess(state) {
        state.status.loggedIn = false;
        state.user = null;
      }
    }
  }

