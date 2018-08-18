export const wxConfig = async (url = '') => {
    if (typeof wx === 'undefined') return null;

    url = url || location.href.replace(location.hash, '');
    if (!url.includes('http')) {
        url = location.protocol + '//' + location.host + '/employee' + url;
    }

    const config = await API.post('supplier/wechat-signature', {url});

    wx.error((res) => {
        if (res.errMsg.includes('signature')) {
            // window.location.reload();
        }
    });
    return wx.config(config);
};

export const onMenuShare = (title = '', desc = '', imgUrl = null, link = null, type = null, dataUrl = null) => {
    return new Promise((resolve, reject) => {
        if (typeof wx === 'undefined') return null;

        let origin = window.location.origin;
        link = link || location.href;

        if (!imgUrl.includes('http')) imgUrl = origin + imgUrl;
        if (!link.includes('http')) link = origin + link;

        let data = {
            title,
            desc,
            type,
            dataUrl,
            link,
            imgUrl,
            success: resolve,
            cancel: reject,
        };

        wx.ready(() => {
            wx.onMenuShareTimeline(data);
            wx.onMenuShareAppMessage(data);
            wx.onMenuShareQQ(data);
            wx.onMenuShareQZone(data);
        });
    });
};
