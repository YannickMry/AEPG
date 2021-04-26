import $ from 'jquery';
import './styles/app_admin.scss';

import { Tooltip, Toast, Popover } from 'bootstrap';

console.log('Made with ❤️️ by Yannick MAURY');

$(function() {
    $('.js-members-list').on("click", function(e){
        e.preventDefault();
        e.stopPropagation();

        let data = {
            'year': e.target.dataset.year,
        };

        $.ajax({
            method: "POST",
            url: urlAdminAjaxMemberRenderList,
            data: data,
            dataType: "html",

          }).done(function(xhr) {
              $('#members').children("div").replaceWith(xhr);
          });
    })
})