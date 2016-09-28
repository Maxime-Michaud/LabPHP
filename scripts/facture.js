/*jslint devel:true */
//Ajoute des fonction onclick sur les details

function clicksDetails() {
    "use strict";

    Array.from($(".detail-facture")).forEach(function (element) {
        element.onclick = function () {
            $.ajax("partial/detailsFacture.php", {
                method: "POST",
                dataType: "html",
                data: {confirmation: element.id},
                success: function (data) {
                    element.innerHTML = data;
                }
            });
        };
    });
}

clicksDetails();