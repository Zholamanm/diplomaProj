import client from "../index";

const sliderApi = {
    getList() {
        return client.get('/api/slider').then(res => res.data);
    },
    store(data) {
        return client.post(`/api/slider`, data, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }).then(res => res.data);
    },
    view(id) {
        return client.get('/api/slider/' + id).then(res => res.data);
    },
    edit(id, data) {
        return client.post(`/api/slider/${id}`, data, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }).then(res => res.data);
    },
    delete(id) {
        return client.delete('/api/slider/' + id).then(res => res.data);
    },
    enableSlider(id) {
        return client.post('/api/slider/enable' + id).then(res => res.data);
    },
};
export default sliderApi;
