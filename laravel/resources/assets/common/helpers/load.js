import loadjs from 'loadjs';

const loadFiles = {
    tinymce: 'https://cdn.jsdelivr.net/npm/tinymce@4/tinymce.min.js',
};

export default (key, options = {}) => {
    return new Promise((resolve, reject) => {
        loadjs(loadFiles[key], {
            success: resolve,
            error: reject,
            ...options,
        });
    });
};
