import client from "../index";

const tagApi = {
    get(data) {
        return client.get('/api/tag', {params: data}).then(res => res.data);
    },
    store(data) {
        return client.post('/api/tag', data).then(res => res.data);
    },
    view(id) {
        return client.get('/api/tag/' + id).then(res => res.data);
    },
    edit(id, data) {
        return client.post('/api/tag/' + id, data).then(res => res.data);
    },
};
export default tagApi;
