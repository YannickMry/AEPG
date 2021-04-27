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

    $('.js-switch-article').on("click", function(e){

        let data = {
            'id': e.target.dataset.id,
        };

        $.ajax({
            method: "POST",
            url: urlAdminAjaxArticleSwitchIsDisplayed,
            data: data,
            dataType: "html",

          }).done(function(xhr) {
              let response = JSON.parse(xhr);
              if(response.isDisplayed) {
                  $('#status-article-' + response.id).children('span')
                    .removeClass(['bg-hidden','text-muted'])
                    .addClass('bg-visible')
                    .text('Visible');
              } else {
                  $('#status-article-' + response.id).children('span')
                    .removeClass('bg-visible')
                    .addClass(['bg-hidden','text-muted'])
                    .text('Invisible');
              }
          }).fail(function(xhr) {
              alert("Une erreur est survenue...");
          });
    })
})