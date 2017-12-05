var base_url = window.location.origin;

var GROUPS = {    
    list_groups_page: base_url + '/ci/admin/groups',
    initial: function () {

    },
    
    cancel_create_or_edit_group: function(){
        window.location.replace(GROUPS.list_groups_page);
    }
}