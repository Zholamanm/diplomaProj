import client from "./index";


const HistoryApi = {
    getHistory(id) {
        return client.get('/api/public/histories/' + id).then(res => res.data);
    },
    getList(data) {
        return client.get('/api/public/histories_list', {params: data}).then(res => res.data);
    },
    getSliderHistories() {
        return client.get('/api/public/slider_histories').then(res => res.data);
    }

};
export default HistoryApi;
