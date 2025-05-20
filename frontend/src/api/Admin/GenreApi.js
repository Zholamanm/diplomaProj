import client from "../index";

const genreApi = {
    get(data) {
        return client.get('/api/genre', {params: data}).then(res => res.data);
    },
    store(data) {
        return client.post('/api/genre', data).then(res => res.data);
    },
    view(id) {
        return client.get('/api/genre/' + id).then(res => res.data);
    },
    edit(id, data) {
        return client.post('/api/genre/' + id, data).then(res => res.data);
    },
    delete(id) {
        return client.delete('/api/genre/' + id).then(res => res.data);
    },
};
export default genreApi;
