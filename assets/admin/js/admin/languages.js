var base_url = window.location.origin;

var LANGUAGES = {    
    list_languages_page: base_url + '/ci/admin/languages',
    initial: function () {
        $('#check-all').click(function(){
            if(this.checked){
                $('.checkbox').each(function(){
                    this.checked = true;
                });
            }else{
                $('.checkbox').each(function(){
                    this.checked = false;
                });
            }
        });
        $('.checkbox').click(function(){
            if($('.checkbox:checked').length === $('.checkbox').length){
                $('#check-all').prop('checked', true);
            }else{
                $('#check-all').prop('checked', false);
            }
        });      
    },
    
    show_confirm_modal: function(){
        if($('.checkbox:checked').length === 0){
            $('#no-item-selected').modal('show');
            return false;
        }
        $('#confirm-delete').modal('show');
    },
    
    cancel_create_or_edit_languages: function(){
        window.location.replace(LANGUAGES.list_languages_page);
    }
};