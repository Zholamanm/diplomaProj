import {createI18n} from "vue-i18n";
import _kk from "../dictionaries/_kk.json";
import _ru from "../dictionaries/_ru.json";
import _en from "../dictionaries/_en.json";
import _ch from "../dictionaries/_ch.json";
import {LS_LOCALE} from "@/_types";

export const locales = ['ru', 'kk', 'en', 'ch'];

export const defaultLocale = 'kk';
export const defaultMessages = _kk;
export default createI18n({
    // locale: defaultLocale,
    // locale: i18nService.getCurrentLocale(),
    locale: localStorage.getItem(LS_LOCALE) ? localStorage.getItem(LS_LOCALE) : defaultLocale,
    fallbackLocale: 'ru',
    globalInjection: true,
    localeExtension: 'json',
    availableLocales: ['ru', 'kk', 'en', 'ch'],
    legacy: false,
    messages: {
        // [defaultLocale]: defaultMessages
        'ru': _ru,
        'kk': _kk,
        'en': _en,
        'ch': _ch,
    }
});

