"use strict";

window.onload=function()   {
    $( ".form_col0" ).click(function () {
        if ( $( "#form_type" ).first().is( ":hidden" ) ) {
            $(".forms").fadeOut();
            $( "#form_type" ).fadeIn();
        } else {
            $( "#form_type" ).fadeOut("fast");
        }
    });

    $( ".form_col1" ).click(function () {
        if ( $( "#form_loca" ).first().is( ":hidden" ) ) {
            $(".forms").fadeOut();
            $( "#form_loca" ).fadeIn();
        } else {
            $( "#form_loca" ).fadeOut("fast");
        }
    });

    $( ".form_col2" ).click(function () {
        if ( $( "#form_prix" ).first().is( ":hidden" ) ) {
            $(".forms").fadeOut();
            $( "#form_prix" ).fadeIn();
        } else {
            $( "#form_prix" ).fadeOut("fast");
        }
    });

    $( ".form_col3" ).click(function () {
        if ( $( "#form_taille" ).first().is( ":hidden" ) ) {
            $(".forms").fadeOut();
            $( "#form_taille" ).fadeIn();
        } else {
            $( "#form_taille" ).fadeOut("fast");
        }
    });

}