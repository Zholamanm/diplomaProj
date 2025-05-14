import client from "../index";

const borrowApi = {
    get(data) {
        return client.get('/api/borrows', {params: data}).then(res => res.data);
    },
    getList(data) {
        return client.get('/api/borrow', {params: data}).then(res => res.data);
    },
    checkout(data) {
        return client.post('/api/borrow/checkout', data).then(res => res.data);
    },
    returnBook(data) {
        return client.post('/api/borrow/return', data).then(res => res.data);
    },
};
export default borrowApi;
