import {defaultLocale, locales} from "@/localization";
import {LS_LOCALE} from "@/_types";
import client from "../api";
import i18n from '../localization/index';
import {nextTick} from "vue";
import dayjs from "dayjs";

const i18nService = {
    isLocaleValid(locale) {
        return !!locales.includes(locale);
    },
    getCurrentLocale() {
        return localStorage.getItem(LS_LOCALE) ? localStorage.getItem(LS_LOCALE) : defaultLocale;
    },
    async setCurrentLocale(locale) {
        if (!this.isLocaleValid(locale))
            return false;

        dayjs.locale(locale);
        i18n.global.locale.value = locale;
        localStorage.setItem(LS_LOCALE, locale);
        client.defaults.headers['X-Localization'] = locale;
    },

    async loadLocaleMessages(locale) {
        if (!i18n.global.availableLocales.includes(locale)) {
            const messages = await import(`../dictionaries/_${locale}.json`);
            i18n.global.setLocaleMessage(locale, messages.default);
        }
        return nextTick();
    },
};

export default i18nService;
