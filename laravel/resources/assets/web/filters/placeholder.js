/**
 * 固定值
 * Vue.filter('placeholder', require('placeholder').default);
 * variable | placeholder('type')
 */
export default (value, type) => {
    if (value) return value;
    switch (type) {
        case 'avatar':
            return '/assets/images/picture.jpg';
    }
    return value;
};
