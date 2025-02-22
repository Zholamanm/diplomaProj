/**
 * vue-cal v4.10.0
 * (c) 2024 Antoni Andre <antoniandre.web@gmail.com>
 * @license MIT
 */
const weekDays = [
    "Дүйсенбі",
    "Сейсенбі",
    "Сәрсенбі",
    "Бейсенбі",
    "Жұма",
    "Сенбі",
    "Жексенбі"
];
const weekDaysShort = [
    "Дс",
    "Сс",
    "Ср",
    "Бс",
    "Жм",
    "Сб",
    "Жк"
];
const months = [
    "Қаңтар",
    "Ақпан",
    "Наурыз",
    "Сәуір",
    "Мамыр",
    "Маусым",
    "Шілде",
    "Тамыз",
    "Қыркүйек",
    "Қазан",
    "Қараша",
    "Желтоқсан"
];
const years = "Жылдар";
const year = "Жыл";
const month = "Ай";
const week = "Апта";
const day = "Күн";
const today = "Бүгін";
const noEvent = "Оқиғалар жоқ";
const allDay = "Барлық күн";
const deleteEvent = "Жою";
const createEvent = "Оқиға жасау";
const dateFormat = "dddd D MMMM YYYY";
const kk = {
    weekDays,
    weekDaysShort,
    months,
    years,
    year,
    month,
    week,
    day,
    today,
    noEvent,
    allDay,
    deleteEvent,
    createEvent,
    dateFormat
};
export {
    allDay,
    createEvent,
    dateFormat,
    day,
    kk as default,
    deleteEvent,
    month,
    months,
    noEvent,
    today,
    week,
    weekDays,
    weekDaysShort,
    year,
    years
};
