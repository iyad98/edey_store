
function get_countries_as_array(countries) {
    var country_ids = [];
    var exclude_country_ids = [];
    countries.forEach(function (t) {
        if(t.product_country_status == 1) {
            country_ids.push(t.country_id);
        }else {
            exclude_country_ids.push(t.country_id);
        }
    });
    return {
        country_ids : country_ids ,
        exclude_country_ids : exclude_country_ids
    };
}


$(document).ready(function () {


    vm.add = false;
    vm.set_attribute(product.attributes);
    vm.get_edit_attribute_variations(product.attributes);
    vm.get_product_variations_db();
 //   vm.get_variations();

    vm.edit_product(product);


    var myDropzone1 = Dropzone.forElement("#mDropzoneProductImages");
    if(product.images.length > 0) {
        product.images.forEach(function (t) {
            var mockFile = { name: t.image, size: 0  };
            myDropzone1.emit("addedfile", mockFile);
            myDropzone1.options.thumbnail.call(myDropzone1, mockFile, t.image);
            myDropzone1.emit("complete", mockFile);
        });
    }
    
    var product_countries = get_countries_as_array(product.countries);
    var get_countries = product_countries.country_ids;
    var get_excluded_countries = product_countries.exclude_country_ids;

    $('#select_countries').val(get_countries).trigger('change');
    $('#select_excluded_countries').val(get_excluded_countries).trigger('change');



});