export const handle = async (apiUrl, minutes = 1, params = {}, isCache = true) => {
    const cacheTime = new Date().getTime() + minutes * 60 * 1000;
    const cacheKey = apiUrl + JSON.stringify(params);
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

export const uploadToken = (drive) => handle('supplier/upload', 2, {drive});
