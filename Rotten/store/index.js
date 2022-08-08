import axios from "axios"
export const state = () => ({
    URL: 'https://api.themoviedb.org/3',
    APIKEY: 'de54d62bf9e00c29e63f7cb274ff0282',
    curPage: 1,
    movies: [],
    search: '',
    searchedMovies: [],
    maxPages: 0,
    isMoviesLoading: true,
    selectFilter: 'popular',
})
export const getters = {
}
export const actions = {
    async getMovies({ state, commit }) {
        try {
            commit('setPage', state.curPage)
            commit('setSelectFilter', state.selectFilter)
            commit('moviesClear')
            commit('setLoading', true)

            if (!state.search) {
                const response = await axios({
                    url: `/discover/movie?${state.selectFilter}`,
                    baseURL: state.URL,
                    params: {
                        api_key: state.APIKEY,
                        language: 'en-US',
                        page: state.curPage
                    }
                })
                commit('setMovies', response.data.results)
                commit('setMaxPages', response.data.total_pages >= 500 ? 500 : response.data.total_pages)
            }
            else if (state.selectFilter) {
                const response = await axios({
                    url: `/movie?${state.selectFilter}`,
                    baseURL: state.URL,
                    params: {
                        api_key: state.APIKEY,
                        language: 'en-US',
                        page: state.curPage
                    }
                })
            }

             else {
                const response = await axios({
                    url: `/search/movie/`,
                    baseURL: state.URL,
                    params: {
                        api_key: state.APIKEY,
                        language: 'en-US',
                        page: state.curPage,
                        query: state.search,
                    }
                })
                commit('setSearchedMovies', response.data.results)
            }
        } catch (e) {
            console.log(e)
        } finally {
            commit('setLoading', false);
        }
    },

    async searchMovies({ state, commit }) {
        try {
            commit('getSearch', state.search)
            commit('searchClear')
            commit('setLoading', true);
            const response = await axios({
                url: `/search/movie/`,
                baseURL: state.URL,
                params: {
                    api_key: state.APIKEY,
                    language: 'en-US',
                    page: state.curPage,
                    query: state.search,
                }
            })
            commit('setSearchedMovies', response.data.results)
            commit('setMaxPages', response.data.total_pages >= 500 ? 500 : response.data.total_pages)
        }
        catch (e) {
            console.log(e)
        } finally {
            commit('setLoading', false);
        }
    },

}
export const mutations = {
    setLoading(state, bool) {
        state.isMoviesLoading = bool
    },
    moviesClear(state) {
        state.movies = []
        state.searchedMovies = []
    },
    setMaxPages(state, maxPages) {
        state.maxPages = maxPages >= 500 ? 500 : maxPages;
    },
    setMovies(state, movies) {
        state.movies = movies;
    },
    setSearchedMovies(state, movies) {
        state.searchedMovies = movies;
    },
    setPage(state, curPage) {
        state.curPage = curPage
    },
    setSelectFilter(state, selectFilter) {
        state.selectFilter = selectFilter
    },
    getSearch(state, search) {
        state.search = search
    },
    updateFilter(state, selectFilter) {
        state.selectFilter = selectFilter
        state.curPage = 1
    },

    filter(state) {
        state.movies = []
        state.curPage = 1
    },
    searchClear(state) {
        state.searchedMovies = []
        state.curPage = 1
    },
    clear(state) {
        state.search = ''
        state.searchedMovies = []
        state.curPage = 1
    },
}