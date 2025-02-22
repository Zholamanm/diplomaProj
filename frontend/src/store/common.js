const common = {
    state: () => ({
        data: null,
        contacts: null,
        applicationsFilter: null,
        consStatuses: null,
        consTypes: null,
        docTypes: null,
    }),
    mutations: {
        setData(state, data) {
            state.data = data;
        },
        setContacts(state, data) {
            state.contacts = data;
        },
        setFilters(state, data) {
            state.applicationsFilter = data;
        },
        setConsStatus(state, statuses) {
            state.consStatuses = statuses;
        },
        setConsTypes(state, types) {
            state.consTypes = types;
        },
        setDocTypes(state, types) {
            state.docTypes = types;
        },
        deleteData(state) {
            state.data = null;
        }
    },
    actions: {},
    getters: {
        getData(state) {
            return state.data;
        }
    }
};

export default common;
