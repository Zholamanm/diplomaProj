import client from "./index";


const ClientApi = {
    getList() {
        return client.get('/api/public/courses').then(res => res.data);
    },
    getResult(id) {
        return client.get('/api/client/courses/' + id + '/result').then(res => res.data);
    },
    getCourse(id) {
        return client.get('/api/public/courses/' + id).then(res => res.data);
    },
    getAttendedCourse(id) {
        return client.get('/api/client/courses/' + id).then(res => res.data);
    },
    getLesson(id) {
        return client.get('/api/client/lesson/' + id).then(res => res.data);
    },
    getLessonWithCompletionData(id) {
        return client.get('/api/client/lesson/' + id).then(res => res.data);
    },
    getTest(id) {
        return client.get('/api/public/test/' + id).then(res => res.data);
    },
    getApplicationData() {
        return client.get('/api/application-data').then(res => res.data);
    },
    getApplicationsData() {
        return client.get('/api/applications/map').then(res => res.data);
    },
    filterApplicationsData(data) {
        return client.get('/api/applications/map/filter', { params: data }).then(res => res.data);
    },
    getHistoryItem(id) {
        return client.get('/api/public/histories/' + id).then(res => res.data);
    },
    getNewsItem(id) {
        return client.get('/api/public/news/' + id).then(res => res.data);
    },
    attendCourse(id) {
        return client.post('/api/client/courses/' + id).then(res => res.data);
    },
    lessonComplete(id) {
        return client.post('/api/lessons/' + id + '/complete').then(res => res.data);
    },
    getCompletedLessons(courseId) {
        return client.get(`/api/client/courses/${courseId}/completed-lessons`).then((res) => res.data);
    },
    attendedCourses() {
        return client.get('/api/client/courses').then(res => res.data);
    },
    completeCourse(id, result) {
        return client.post('/api/client/courses/' + id + '/complete', { 'result': result }).then(res => res.data);
    },
    exportCalc(type, data, debts) {
        return client.post('/api/generate-export-calc/' + type, debts).then((res => res.data));
    },
    applyToConsultation(){
        return client.post('/api/client/consultation/apply').then(res => res.data);
    }
};
export default ClientApi;
