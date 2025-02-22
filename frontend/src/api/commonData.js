import client from "./index";
import i18nService from "../services/i18n.service";


const commonData = {
    getCommonData() {
        return client.get('/api/common_data', {headers: {'X-Localization': i18nService.getCurrentLocale()}}).then(res => res.data);
    },
    fileUpload(data) {
        return client.post('/api/file-upload', data, {headers: {'content-type': 'multipart/form-data'}}).then(res => res.data);
    },
    contacts() {
        return client.get('/api/public/contacts').then(res => res.data);
    },
    catoFlows() {
        return client.get('/api/cato_flows').then(res => res.data);
    }
};
export default commonData;
