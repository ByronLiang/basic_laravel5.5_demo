/**
 * https://github.com/blueimp/JavaScript-Load-Image
 * toData_url: (window.URL || window.webkitURL).createObjectURL(blob)
 */
const loadImage = require('blueimp-load-image/js/load-image');
require('blueimp-load-image/js/load-image-scale');
require('blueimp-canvas-to-blob/js/canvas-to-blob.min');

export default (file, options) => {
    return new Promise((resolve, reject) => {
        if (!file.type.includes('image') || file.type.includes('gif')) return resolve(file);
        options.canvas = true;
        loadImage(file, (img) => img.toBlob((blob) => {
            blob.name = file.name;
            blob.lastModified = file.lastModified;
            blob.lastModifiedDate = file.lastModifiedDate;
            resolve(blob);
        }, file.type || 'image/png', 1), options);
    });
};
