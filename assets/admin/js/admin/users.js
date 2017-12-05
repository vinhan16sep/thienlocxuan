var base_url = window.location.origin;

var USERS = {
    list_users_page: base_url + '/ci/admin/users',
    initial: function () {

    },
    
    cancel_create_or_edit_user: function(){        
        window.location.replace(USERS.list_users_page);
    }
}