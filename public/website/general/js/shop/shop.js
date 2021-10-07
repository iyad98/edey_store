

$(document).ready(function () {

    $('#sort_by_orderby').change(function () {

        let new_url = setValueInUrl('orderby' , $('#sort_by_orderby').val());
        window.location =new_url;

    });

    $('#sort_by_per_page').change(function () {

        let new_url = setValueInUrl('per_page' , $('#sort_by_per_page').val());
        window.location =new_url;

    });


    $("input[name='marka']").change(function () {


        let new_url = setValueInUrl('brand' ,$("input[name='marka']:checked").val());
        window.location =new_url;

    });



    $('#sort_by_category').change(function () {

        let new_url = setValueInUrl('category' , $('#sort_by_category').val());
        new_url = setValueInUrl('page' , 1);
        window.location =new_url;
    });
    $('#sort_by_brand').change(function () {

        let new_url = setValueInUrl('brand' , $('#sort_by_brand').val());
        new_url = setValueInUrl('page' , 1);
        window.location =new_url;
    });

});