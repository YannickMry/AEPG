import $, { event } from 'jquery';
import './styles/app_admin.scss';

import { Tooltip, Toast, Popover } from 'bootstrap';

// execute when dom is loaded
promotionActive();

// Event Listener
$('.js-members-list').on("click", ajaxShowMemberList)
$('.js-switch-article').on("click", ajaxSwitchDisplayArticle)
$('.js-switch-member').on("click", ajaxSwitchDisplayMember);
$('#promotion-search').on("keyup", searchMember);

// AJAX Function
/**
 * Affiche le template de la liste des membres en fonction de l'année d'une promotion et d'une vue
 */
function ajaxShowMemberList(event){    
    event.preventDefault();
    event.stopPropagation();

    let data = {
        'year': $(this).attr('data-year'),
        'view': $(this).attr('data-view')
    };

    $.ajax({
        method: "POST",
        url: urlAdminAjaxMemberRenderList,
        data: data,
        dataType: "html",

    }).done(function(xhr) {
        $('#members').children("div").replaceWith(xhr);
        $('.js-switch-member').on("click", ajaxSwitchDisplayMember);
        promotionActive();
    });
}

/**
 * Rend un article visible/invisible par le public
 */
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

/**
 * Rend un membre visible/invisible par le public
 */
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
          let card = $('div[data-fullname="' + xhr.fullName + '"]');
          if(xhr.isDisplayed) {
            card.addClass('active');
          } else {
              card.removeClass('active');
          }
      }).fail(function(xhr) {
          alert(xhr.responseJSON.status + " : " + xhr.responseJSON.message);
      });
}

// Permet de rendre un lien actif pour lors du choix d'une promotion
function promotionActive(){

    $('.promotion-active').removeClass('promotion-active');

    let year = $('#members').children('div').attr('data-promotion-year');
    $('#promotion-' + year).addClass('promotion-active');
}

// Affiche/Enlève les cards qui correspondent au filtre dans le search input
function searchMember(){
    let filter, cards, fullname;
    filter = $('#promotion-search').val().toUpperCase();
    cards = $('.card');

    if(filter) {
        $.each(cards, function(index, element){
            fullname = element.dataset.fullname.toUpperCase();

            if(fullname.indexOf(filter) > -1){
                element.parentElement.classList.remove('d-none');
            } else {
                element.parentElement.classList.add('d-none');
            }
        });
    } else {
        // Réaffiche toutes les cards si le filtre est vide
        $.each(cards, function(index, element){
            element.parentElement.classList.remove('d-none');
        })
    }
}