var base_url = window.location.origin;

var DASHBOARD = {    
    dashboard_page: base_url + '/ci/admin/dashboard',
    initial: function () {
        
    }
//    ajax_get_languages: function () {
//        $.ajax({
//            type: "POST",
//            url: base_url + "/ci/admin/dashboard/ajax_get_languages",
//            cache: false,
//            success: function (json) {                
//                try {
//                    var obj = jQuery.parseJSON(json);
//                    main = json.count_main;
//                    sub = json.count_sub;
//                    return true;
//                } catch (e) {
//                    return false;
//                }
//            },
//            error: function () {
//                return false;
//            }
//        });
//    }
};