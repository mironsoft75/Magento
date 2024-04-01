require([
    'jquery'
], function ($) {
    'use strict';
    jQuery(document).ready(function(){
        jQuery(document).ajaxStop(function () {
          function checkAndClickDropdown(element) {
             element.find('ul li.admin__action-multiselect-menu-inner-item').each(function(){
                var ChildElement = $(this);
                var ChildDivaction = ChildElement.find('div.action-menu-item');
               
                if(ChildElement.hasClass('_parent')){
                    var ChildDropedown = ChildDivaction.find('.admin__action-multiselect-dropdown');
                     ChildDropedown.trigger('click');
                    checkAndClickDropdown(ChildElement);
                
                }
            });
        }
        
            var totalElements = $('.admin__action-multiselect-tree .admin__action-multiselect-menu-inner-item._parent').length;
            var processedElements = 0;
            $('.admin__action-multiselect-tree .admin__action-multiselect-menu-inner-item._parent').each(function() {
                if (!$(this).hasClass('_root')) {
                    var parentLi = $(this);
                    var divElement = parentLi.find('div.action-menu-item');
                    var Dropedown = divElement.find('.admin__action-multiselect-dropdown');

                    Dropedown.trigger('click');
                    checkAndClickDropdown(parentLi);
                     parentLi.find('div.action-menu-item').each(function() {
                        if ($(this).hasClass('_selected')) {
                            $(this).parents('li.admin__action-multiselect-menu-inner-item').find('> div.action-menu-item > div.admin__action-multiselect-dropdown').each(function() {
                                $(this).addClass('custom-open');
                            });
                        }
                    });
 
                }
                processedElements++;
                  if (processedElements === totalElements) {
                       triggerButtonCustom(true);
                  }
            });
        function triggerButtonCustom(value){
              if(value){
                $('.admin__action-multiselect-tree .admin__action-multiselect-menu-inner-item._parent').each(function() {
                    if (!$(this).hasClass('_root')) {
                         var parentLi = $(this);
                          var divElement = parentLi.find('div.action-menu-item');
                           var Dropedown = divElement.find('.admin__action-multiselect-dropdown');
                          Dropedown.trigger('click');
                          checkAndClickDropdown(parentLi); 

                    }
                 });

                   $('.admin__action-multiselect-tree .admin__action-multiselect-menu-inner-item._parent:not(._root) .admin__action-multiselect-dropdown.custom-open').each(function() {
                        $(this).trigger("click");
                    });

              }
        }
      });
    });
});