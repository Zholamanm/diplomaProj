import client from "../index";

const bookApi = {
    get(data) {
        return client.get('/api/book', {params: data}).then(res => res.data);
    },
    store(data) {
        return client.post(`/api/book`, data, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }).then(res => res.data);
    },
    view(id) {
        return client.get('/api/book/' + id).then(res => res.data);
    },
    edit(id, data) {
        return client.post(`/api/book/${id}`, data, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }).then(res => res.data);
    },
    delete(id) {
        return client.delete('/api/category/' + id).then(res => res.data);
    },
};
export default bookApi;
