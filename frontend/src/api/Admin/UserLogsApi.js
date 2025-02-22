import client from "../index";

const UserlogsApi = {
    getList(data) {
        return client.get('/api/user-logs/', { params: data }).then(res => res.data);
    }
};

export default UserlogsApi;
