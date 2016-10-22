/*global $ */
"use strict";

/**
 * Va chercher les services d'une facture et ses rabais
 */
function expand(element) {
    if (/D.tail/.test(element.innerHTML)) {
        $.ajax("partial/detailsFacture.php", {
            method: "POST",
            dataType: "html",
            data: {confirmation: element.id},
            success: function (data) {
                element.innerHTML = data;
                element.lastElementChild.onclick = () => expand(element);
            }
        });
    } else {
        element.innerHTML = '<div>Détail<div>';
        element.lastElementChild.onclick = () => expand(element);
    }
}

//Affiche les infos d'un client
function showCustomerInfo(element) {
    $.ajax("partial/infoClient.php", {
        method: "GET",
        dataType: "html",
        data: { id:$(element).attr("clientid")},
        success: function(data){
            var dialog = $(data).dialog({
                autoOpen: false,
                position: { my: "left top", at: "center", of: element },
                dialogClass: "no-close",
                width:400
            });
            dialog.dialog("open");
            dialog.click(() => dialog.dialog("close"));
        }
    })
}

//Ajoute des fonction onclick sur les details
function addClickHandlers() {
    Array.from($(".detail-facture")).forEach(function (element) {
        element.lastElementChild.onclick = () => expand(element);
    });
    Array.from($(".nom")).forEach(function (element) {
        element.onclick = () => showCustomerInfo(element);
    });
}

function addDropDown() {
    $.ajax("includes/dropdown.php", {
        method: "GET",
        dataType: "html",
        success: (data) => $(".dropdown")[0].innerHTML += (data)
    });
}

addClickHandlers();
addDropDown();