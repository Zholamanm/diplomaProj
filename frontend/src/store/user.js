const user = {
    state: () => ({
        user: null,
    }),
    mutations: {
        setUser(state, user) {
            state.user = user;
        },
        deleteUser(state) {
            state.user = null;
        }
    },
    actions: {},
    getters: {
        getUserName(state) {
            return state.user.name;
        },
        isUserModelLoaded: (state) => {

            return state.user !== null;
        }, // Проверка, загружена ли модель пользователя

    },

};

export default user;


