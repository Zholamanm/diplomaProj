import client from "../index";


const HistoryApi = {
    getList(data) {
        return client.get('/api/history', {params: data}).then(res => res.data);
    },
    getItem(id) {
        return client.get('/api/history/' + id).then(res => res.data);
    },
    createItem(data) {
        return client.post('/api/history', data).then(res => res.data);
    },
    updateItem(id, data) {
        return client.post('/api/history/' + id, data).then(res => res.data);
    },
    deleteItem(id) {
        return client.delete('/api/history/' + id).then(res => res.data);
    },

};
export default HistoryApi;
