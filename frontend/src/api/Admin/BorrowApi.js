import client from "../index";

const borrowApi = {
    get(data) {
        return client.get('/api/borrows', {params: data}).then(res => res.data);
    },
};
export default borrowApi;
