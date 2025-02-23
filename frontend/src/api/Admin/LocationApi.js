import client from "../index";

const locationApi = {
    async get() {
        return await client.get('/api/location').then(res => res.data);
    },
    async getById(id) {
        return await client.get('/api/location/' + id).then(res => res.data);
    },
    async store(data) {
        return await client.post(`/api/location`, data).then(res => res.data);
    },
    async update(id, data) {
        return await client.post(`/api/location/` + id, data).then(res => res.data);
    },
    getBooks(id) {
        return client.get(`/api/location/${id}/books`).then(res => res.data);
    },
    addBooks(id, books) {
        return client.post(`/api/location/${id}/books`, { books }).then(res => res.data);
    },
    async delete(id) {
        return await client.delete('/api/location/' + id).then(res => res.data);
    },
    removeBook(locId, id) {
        return client.delete(`/api/location/${id}/books/` + id).then(res => res.data);
    }
};
export default locationApi;
