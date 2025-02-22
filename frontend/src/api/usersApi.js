import client from "./index";

const usersApi = {
    getList(data) {
        return client.get('/api/users', {params: data}).then(res => res.data);
    },
    getItem(id) {
        return client.get('/api/users/' + id).then(res => res.data);
    },
    saveItem(data) {
        return client.post('/api/users', data).then(res => res.data);
    },
    updateItem(id, data) {
        return client.post('/api/users/' + id, data).then(res => res.data);
    },
    updatePersonal(id, data) {
        return client.post('/api/personal/account/update/' + id, data).then(res => res.data);
    }
};

export default usersApi;
