import client from "../index";

const blackListApi = {
    getList(data) {
        return client.get('/api/black-list', {params: data}).then(res => res.data);
    },
};
export default blackListApi;
