import store from "../store";
import i18nService from "../services/i18n.service";
import {LS_LOCALE} from "@/_types";
import authApi from './../api/AuthApi'

// export const requireAuth = async (to, from, next) => {
//     if (store.state.auth.authorized) {
//         next();
//     } else if (to.name !== 'login') {
//         next({name: 'login', query: {from: to.name}, params: {locale: i18nService.getCurrentLocale()}});
//     }
//     next();
// };

// export const requireAuth = async (to, from, next) => {
//     if (store.state.auth.authorized) {
//         const user = await checkUserLoaded();
//         if (user.role_id === 3) {
//             window.location.href = `/${i18nService.getCurrentLocale()}`;
//         } else {
//             next();
//         }
//     } else if (to.name !== 'login') {
//         next({name: 'login', query: {from: to.name}, params: {locale: i18nService.getCurrentLocale()}});
//     }
//     next();
// };

export const requireAuth = async (to, from, next) => {
    const params = to.params || {};
    const locale = params.locale || i18nService.getCurrentLocale();

    try {
        if (store.state.auth.authorized) {
            const user = await checkUserLoaded();

            if (!user?.role_id) {
                return next({ name: 'login', params: { locale } });
            }

            if (user.role_id === 3) {
                return window.location.href = `/${locale}`;
            } else {
                if (to.path.endsWith('/admin') || to.path.endsWith('/admin/')) {
                    next({name: 'applicationsList', query: {from: to.name}, params: {locale: locale}})
                }
                next();
            }
        } else if (to.name !== 'login') {
            next({name: 'login', query: {from: to.name}, params: {locale: i18nService.getCurrentLocale()}});
        }
        return next();
    } catch (error) {
        next({name: 'login', query: {from: to.name}, params: {locale: i18nService.getCurrentLocale()}});

    }
};

function checkUserLoaded() {
    return new Promise((resolve, reject) => {
        const maxAttempts = 50; // Increased from 20
        let attempts = 0;

        const checkLoad = () => {
            attempts++;
            const user = store.state.user.user;

            if (user && user.role_id) {
                return resolve(user);
            }

            if (attempts >= maxAttempts) {
                return authApi.getMyUser()
                    .then(user => resolve(user))
                    .catch(err => reject(err));
            }

            setTimeout(checkLoad, 100); // Increased delay from 50ms
        };

        checkLoad();
    });
}

export const requireClientAuth = (to, from, next) => {
    if (store.state.auth.authorized) {
        next();
    } else if (to.name !== 'HomeView') {
        next({name: 'HomeView', params: {locale: i18nService.getCurrentLocale()}});
    }
    next();
};


export const checkLocale = (to, from, next) => {
    if (localStorage.getItem(LS_LOCALE) == null) {
        i18nService.setCurrentLocale('ru');
        next({...to, params: {...to.params, locale: 'ru'}});
    } else if (i18nService.isLocaleValid(to.params.locale)) {
        i18nService.setCurrentLocale(to.params.locale);
        next();
    } else {
        next({...to, params: {...to.params, locale: i18nService.getCurrentLocale()}});
    }
    next();
};


