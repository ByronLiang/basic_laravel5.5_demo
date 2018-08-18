import md5 from 'crypto-js/md5';

export const handle = async (apiUrl, minutes = 1, params = null, isCache = true) => {
    const cacheTime = new Date().getTime() + minutes * 60 * 1000;
    const cacheKey = params ? md5(apiUrl + JSON.stringify(params)) : apiUrl;
    let store = null;
    if (isCache) {
        store = SessionStore.get(cacheKey);
    }
    if (!store) {
        store = await API.get(apiUrl, {params});
        SessionStore.set(cacheKey, store, cacheTime);
    }
    return store;
};

/**
 * import {uploadToken} from 'api/Cache'
 * @returns {Promise<*>}
 * @constructor
 */
export const uploadToken = (drive) => handle('supplier/upload', 2, {drive});

/**
 * import {My} from 'api/Cache'
 * @returns {Promise.<void>}
 * @constructor
 */
export const my = async (commit = null, isCache = true) => {
    const store = await handle('my/profile', 1, null, isCache);
    commit ? commit('setMy', store) : vm.$store.commit('setMy', store);
    return store;
};
