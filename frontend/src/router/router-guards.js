import store from "../store";
import i18nService from "../services/i18n.service";
import {LS_LOCALE} from "@/_types";

// export const requireAuth = async (to, from, next) => {
//     if (store.state.auth.authorized) {
//         next();
//     } else if (to.name !== 'login') {
//         next({name: 'login', query: {from: to.name}, params: {locale: i18nService.getCurrentLocale()}});
//     }
//     next();
// };

export const requireAuth = async (to, from, next) => {
    if (store.state.auth.authorized) {
        const user = await checkUserLoaded();
        if (user.role_id === 3) {
            window.location.href = `/${i18nService.getCurrentLocale()}`;
        } else {
            next();
        }
    } else if (to.name !== 'login') {
        next({name: 'login', query: {from: to.name}, params: {locale: i18nService.getCurrentLocale()}});
    }
    next();
};

function checkUserLoaded() {
    return new Promise((resolve) => {
        const checkLoad = () => {
            if (store.state.user.user) {
                resolve(store.state.user.user);
            } else {
                setTimeout(checkLoad, 50);
            }
        };
        checkLoad();
    });
}


export const requireClientAuth = (to, from, next) => {
    if (store.state.auth.authorized) {
        next();
    } else if (to.name !== 'main_v3') {
        next({name: 'main_v3', params: {locale: i18nService.getCurrentLocale()}});
    }
    next();
};


export const checkLocale = (to, from, next) => {
    if (localStorage.getItem(LS_LOCALE) == null) {
        i18nService.setCurrentLocale('kk');
        next({...to, params: {...to.params, locale: 'kk'}});
    } else if (i18nService.isLocaleValid(to.params.locale)) {
        i18nService.setCurrentLocale(to.params.locale);
        next();
    } else {
        next({...to, params: {...to.params, locale: i18nService.getCurrentLocale()}});
    }
    next();
};


