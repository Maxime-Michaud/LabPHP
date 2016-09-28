/*jslint devel:true */
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

//Ajoute des fonction onclick sur les details
function clicksDetails() {
    Array.from($(".detail-facture")).forEach(function (element) {
        element.lastElementChild.onclick = () => expand(element);
    });
}

function addDropDown() {
    $.ajax("includes/dropdown.php", {
        method: "GET",
        dataType: "html",
        success: (data) => $(".dropdown")[0].innerHTML += (data)
    });
}

clicksDetails();
addDropDown();