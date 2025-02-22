import client from "../index";

const categoryApi = {
    get(data) {
        return client.get('/api/category', {params: data}).then(res => res.data);
    },
    store(data) {
        return client.post('/api/category', data).then(res => res.data);
    },
    view(id) {
        return client.get('/api/category/' + id).then(res => res.data);
    },
    edit(id, data) {
        return client.post('/api/category/' + id, data).then(res => res.data);
    },
    delete(id) {
        return client.delete('/api/category/' + id).then(res => res.data);
    },
};
export default categoryApi;
