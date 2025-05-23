import client from "./index";

const ClientApi = {
    getList(data) {
        return client.get('/api/client/books', {params: data}).then(res => res.data);
    },
    getFriends(id) {
        return client.get('/api/client/friends/' + id).then(res => res.data);
    },
    getProfile() {
        return client.get('/api/client/profile').then(res => res.data);
    },
    getUserProfile(id) {
        return client.get('/api/client/profile/' + id).then(res => res.data);
    },
    getRecentReviews() {
        return client.get('/api/client/reviews/recent').then(res => res.data);
    },
    updateProfilePicture(data) {
        return client.post(`/api/client/profile/picture`, data, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }).then(res => res.data);
    },
    updateProfile(data) {
        return client.post(`/api/client/profile`, data, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }).then(res => res.data);
    },
    getUserReviews() {
        return client.get('/api/client/reviews').then(res => res.data);
    },
    getUserPublicReviews(id) {
        return client.get('/api/client/reviews/' + id).then(res => res.data);
    },
    getGuestList(data) {
        return client.get('/api/guest/books', {params: data}).then(res => res.data);
    },
    submitReview(data) {
        return client.post('/api/client/review', {params: data}).then(res => res.data);
    },
    getRecommendList(data) {
        return client.get('/api/client/books/recommend', {params: data}).then(res => res.data);
    },
    getSimilarList(data) {
        return client.get('/api/client/books/similar', {params: data}).then(res => res.data);
    },
    getTopsLists(data) {
        return client.get('/api/client/books/top-list', {params: data}).then(res => res.data);
    },
    getTopBooksByGenre(id) {
        return client.get(`/api/client/genres/${id}/books`).then(res => res.data);
    },
    getFeaturedList(data) {
        return client.get('/api/client/books/recent', {params: data}).then(res => res.data);
    },
    getRecentList(data) {
        return client.get('/api/client/books/featured', {params: data}).then(res => res.data);
    },
    getCategoriesWithMostBorrowed(data) {
        return client.get('/api/client/books/categories', {params: data}).then(res => res.data);
    },
    getCategoryWithBooks(id) {
        return client.get(`/api/client/categories/${id}/books`).then(res => res.data);
    },
    getCheckoutList(data) {
        return client.get('/api/client/checkout', {params: data}).then(res => res.data);
    },
    getLocations(id) {
        return client.get('/api/client/book/locations/' + id).then(res => res.data);
    },
    getLocationList(data) {
        return client.get('/api/client/locations', {params: data}).then(res => res.data);
    },
    getClientBookById(id) {
        return client.get('/api/client/books/' + id).then(res => res.data);
    },
    getGuestBookById(id) {
        return client.get('/api/guest/books/' + id).then(res => res.data);
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
    },
    getUserFavorites(id) {
        return client.get('/api/client/book/favourite/' + id).then(res => res.data);
    },
    sendRequest(id) {
        return client.post(`/api/client/friends/${id}/send`).then(res => res.data);
    },
    acceptRequest(id) {
        return client.post(`/api/client/friends/${id}/accept`).then(res => res.data);
    },
    declineRequest(id) {
        return client.post(`/api/client/friends/${id}/reject`).then(res => res.data);
    },
    removeFriend(id) {
        return client.delete(`/api/client/friends/${id}//remove`).then(res => res.data);
    }
};
export default ClientApi;
