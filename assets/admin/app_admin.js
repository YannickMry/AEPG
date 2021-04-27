import $, { event } from 'jquery';
import './styles/app_admin.scss';

import { Tooltip, Toast, Popover } from 'bootstrap';

console.log('Made with ❤️️ by Yannick MAURY');

// Event Listener
$('.js-members-list').on("click", ajaxShowMemberList)
$('.js-switch-article').on("click", ajaxSwitchDisplayArticle)
$('.js-switch-member').on("click", ajaxSwitchDisplayMember);

// AJAX Function
function ajaxShowMemberList(event){    
    event.preventDefault();
    event.stopPropagation();

    let data = {
        'year': $(this).attr('data-year'),
    };

    $.ajax({
        method: "POST",
        url: urlAdminAjaxMemberRenderList,
        data: data,
        dataType: "html",

    }).done(function(xhr) {
        $('#members').children("div").replaceWith(xhr);
        $('.js-switch-member').on("click", ajaxSwitchDisplayMember);
    });
}

function ajaxSwitchDisplayArticle(){

    let data = {
        'id': $(this).attr('data-id'),
    };

    $.ajax({
        method: "POST",
        url: urlAdminAjaxArticleSwitchIsDisplayed,
        data: data,
        dataType: "json",

      }).done(function(xhr) {
          if(xhr.isDisplayed) {
              $('#status-article-' + xhr.id).children('span')
                .removeClass(['bg-hidden','text-muted'])
                .addClass('bg-visible')
                .text('Visible');
          } else {
              $('#status-article-' + xhr.id).children('span')
                .removeClass('bg-visible')
                .addClass(['bg-hidden','text-muted'])
                .text('Invisible');
          }
      }).fail(function(xhr) {
            alert(xhr.responseJSON.status + " : " + xhr.responseJSON.message);
      });
}

function ajaxSwitchDisplayMember(){

    let data = {
        'id': $(this).attr('data-id'),
    };

    $.ajax({
        method: "POST",
        url: urlAdminAjaxMemberSwitchIsDisplayed,
        data: data,
        dataType: "json",

      }).done(function(xhr) {
        //   if(xhr.isDisplayed) {
        //       $('#status-article-' + xhr.id).children('span')
        //         .removeClass(['bg-hidden','text-muted'])
        //         .addClass('bg-visible')
        //         .text('Visible');
        //   } else {
        //       $('#status-article-' + xhr.id).children('span')
        //         .removeClass('bg-visible')
        //         .addClass(['bg-hidden','text-muted'])
        //         .text('Invisible');
        //   }
      }).fail(function(xhr) {
          alert(xhr.responseJSON.status + " : " + xhr.responseJSON.message);
      });
}