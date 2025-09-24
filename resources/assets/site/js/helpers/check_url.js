var check_url = {

    auxiliaries: {
        defaultHttpStatusCode: 200,
        defaulInterval: 5000
    },

    elements: {},

    start: function() {},

    events: function() {},

    check: function(url, httpStatusCode) {
        return check_url.checkHttpStatusCode(url, httpStatusCode === undefined ? check_url.auxiliaries.defaultHttpStatusCode : httpStatusCode);
    },

    checkAndRedirect: function(url, httpStatusCode) {
        if(check_url.check(url, httpStatusCode)) check_url.redirect(url);
    },

    checkByIntervalThenRedirect: function(url, httpStatusCode, interval) {
        check_url.checkAndRedirect(url, httpStatusCode);

        setInterval(function() {
            check_url.checkAndRedirect(url, httpStatusCode);
        }, interval === undefined ? check_url.auxiliaries.defaulInterval : interval);
    },

    checkHttpStatusCode: function(url, httpStatusCode) {
        var http = new XMLHttpRequest();
        http.open('HEAD', url, false);
        http.send();
        return http.status == httpStatusCode;
    },

    redirect: function(url) {
        window.location.href = url;
    }

};
