import client from "./index";


const ClientApi = {
    getList(data) {
        return client.get('/api/books', {params: data}).then(res => res.data);
    },
    borrowBook(id) {
        return client.post('/api/book/' + id + '/borrow').then(res => res.data);
    },
    addToFavourite(id) {
        return client.post('/api/book/' + id + '/favourite').then(res => res.data);
    },
    getFavourites(data) {
        return client.post('/api/books/favourite', {params: data}).then(res => res.data);
    }
};
export default ClientApi;
