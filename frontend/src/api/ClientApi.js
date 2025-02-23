import client from "./index";


const ClientApi = {
    getList(data) {
        return client.get('/api/books', {params: data}).then(res => res.data);
    },
    getLocations(id) {
        return client.get('/api/book/locations/' + id).then(res => res.data);
    },
    getBookById(id) {
        return client.get('/api/books/' + id).then(res => res.data);
    },
    getLocationById(id) {
        return client.get('/api/locations/' + id).then(res => res.data);
    },
    borrowBook(id, data) {
        return client.post('/api/books/' + id + '/borrow',  data).then(res => res.data);
    },
    addToFavourite(id) {
        return client.post('/api/book/' + id + '/favourite').then(res => res.data);
    },
    getFavourites(data) {
        return client.post('/api/books/favourite', {params: data}).then(res => res.data);
    }
};
export default ClientApi;
