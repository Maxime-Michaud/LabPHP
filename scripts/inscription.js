/*jslint devel:true */
/*global $ */

/**
 * Ce fichier contient les fonctions de validation pour le formulaire 
 * d'inscription et de modification du profil
 */

//Utilise jQuery pour obtenir les inputs a valider
var inputCodePostal = $('input[name="codepostal"]')[0];
var inputTelephone = $('input[name="telephone"]')[0];
var inputCourriel = $('input[name="courriel"]')[0];
var inputConfirmationCourriel = $('input[name="confirmationcourriel"]')[0];
var inputMotDePasse = $('input[name="password"]')[0];
var inputConfirmationMotDePasse = $('input[name="confirmationpassword"]')[0];
//Teste si le code postal est un code postal canadien valide
function validationCodePostal() {
    return /^[a-zA-Z]\d[a-zA-Z][\s-]?\d[a-zA-Z]\d$/.test(inputCodePostal.value);
}

//Teste si le téléphone est un numéro nord-américain valide
function validationTelephone(){
/*
    /^(\+?1|1?)         Code de pays
    [-.\s]?             Séparateur de pays
    (\d{3}|\(\d{3}\))   code régional, avec ou sans parenthèses
    [-.\s]?             Séparateur du code régional
    \d{3}               code de la ville
    [-.\s]?             Séparateur
    \d{4}               4 derniers chiffres
    (\s(x|ext)\d+)?$/ //extension (optionelle)
*/
    return /^(\+?1|1?)[-.\s]?(\d{3}|\(\d{3}\))[-.\s]?\d{3}[-.\s]?\d{4}(\s(x|ext)\d+)?$/.test(inputTelephone.value);
}

//Teste si l'adresse email est a peu près valide
function validationCourriel(){
    return /^.+?@([^.]+\.)+?[^.]{2,}$/.test(inputCourriel.value);
}

//Teste que les deux adresses sont pareilles. Ne vérifie pas la validité de l'adresse
function validationConfirmationCourriel(){
    return inputCourriel.value == inputConfirmationCourriel.value;
}

/*Teste que le mot de passe répond au critères suivant:
*   8   charactères minimum
*   100 charactères maximum
*   1   chiffre minimum
*   1   lettre minimum 
*/
function validationMotDePasse(){
    var pass = inputMotDePasse.value;

    return  pass.length > 8 &&
            /\d/.test(pass) &&
            /[a-zA-Z]/.test(pass) &&
            pass.length < 100;
}

function validationConfirmationMotDePasse(){
    return inputMotDePasse.value == inputConfirmationMotDePasse.value;
}

//Valide le formulaire entier
function validationFormulaire(){
    if(!validationCodePostal())
        alert("Votre code postal est invalide. Assurez vous qu'il est au format H0H 0H0");
    else if (!validationTelephone())
        alert("Votre numéro de téléphone est invalide. Assurez vous qu'il est au format (888) 823-9674"); 
    else if (!validationCourriel())
        alert("Votre adresse courriel est invalide. Assurez vous qu'elle est au format spam@spam.com");
    else if (!validationConfirmationCourriel())
        alert("L'adresse courriel et sa confirmation doivent êtres identique");
    else if (!validationMotDePasse())
        alert("Votre mot de passe ne respecte pas les critères suivant: \n\tAu moins 8 charactères\n\tAu moins 1 lettre\n\tAu moins 1 chiffre"); 
    else if (!validationConfirmationMotDePasse())
        alert("Le mot de passe et sa confirmation doivent êtres identique");
    else 
        return true;

    return false;
}


/*La section suivante utilise les fonctions de validation définies plus haut et ajoute des validations
    aux éléments lorsque l'élément perd le focus*/

//Les même couleurs que dans le CSS
var erreur = '#FF4A07';
var normal = '#FF9F07';

//Fonction utilisée pour styler l'élément selon sa validité
function validationOnBlur(element, validation)
{
    if (!validation())
    {
        element.style.color = erreur;
        element.style.border = erreur + " solid 2px";
    } else {
        element.style.color = normal;
        element.style.border = "";
    }
}

//Pour le code postal
inputCodePostal.onblur = () => validationOnBlur(inputCodePostal, validationCodePostal);
inputTelephone.onblur = () => validationOnBlur(inputTelephone, validationTelephone);
inputCourriel.onblur = () => validationOnBlur(inputCourriel, validationCourriel);
inputConfirmationCourriel.onblur = () => validationOnBlur(inputConfirmationCourriel, validationConfirmationCourriel);
inputMotDePasse.onblur = () => validationOnBlur(inputMotDePasse, validationMotDePasse);
inputConfirmationMotDePasse.onblur = () => validationOnBlur(inputConfirmationMotDePasse, validationConfirmationMotDePasse);