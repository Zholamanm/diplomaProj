import client from "./index";


const ClientApi = {
    getList(data) {
        return client.get('/api/client/books', {params: data}).then(res => res.data);
    },
    getGuestList(data) {
        return client.get('/api/guest/books', {params: data}).then(res => res.data);
    },
    getRecommendList(data) {
        return client.get('/api/client/books/recommend', {params: data}).then(res => res.data);
    },
    getCheckoutList(data) {
        return client.get('/api/client/checkout', {params: data}).then(res => res.data);
    },
    getLocations(id) {
        return client.get('/api/client/book/locations/' + id).then(res => res.data);
    },
    getBookById(id) {
        return client.get('/api/client/books/' + id).then(res => res.data);
    },
    getLocationById(id) {
        return client.get('/api/client/locations/' + id).then(res => res.data);
    },
    getLocationBookById(data) {
        return client.get('/api/client/book/locations', {params: data}).then(res => res.data);
    },
    borrowBook(id, data) {
        return client.post('/api/client/books/' + id + '/borrow',  data).then(res => res.data);
    },
    addToFavourite(id) {
        return client.post('/api/client/book/' + id + '/favourite').then(res => res.data);
    },
    removeFromFavourite(id) {
        return client.delete('/api/client/book/' + id + '/favourite').then(res => res.data);
    },
    getFavourites(data) {
        return client.get('/api/client/book/favourite', {params: data}).then(res => res.data);
    }
};
export default ClientApi;
