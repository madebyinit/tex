

jQuery(document).ready(function($) {
    $(document).on("change", "#model_select", function() {
        var carmodel = jQuery(this).find('option:selected').data('model-id');
        var carclass = jQuery(this).find('option:selected').data('class-id');

        console.log('carmodel   -> ' + carmodel);
        $.ajax({
            type: "POST",
            url: window.wp_data.ajax_url,
            data : {
                action : 'get_vehicles',
                carmodel_id : carmodel,
                carclass_id : carclass
            },
            success: function (data) {
                jQuery('#ajax-portfolio-container').html(data);
                $('#ajax-portfolio-container .project-block a').css('opacity', 1);
            }
        });
    });

    $(document).on("change", "#class_select", function() {
        var carclass = jQuery(this).find('option:selected').data('class-id');
        var carmodel = jQuery(this).find('option:selected').data('model-id');

        console.log('carclass   ->      '+carclass);
        $.ajax({
            type: "POST",
            url: window.wp_data.ajax_url,
            data : {
                action : 'get_vehicles',
                carclass_id : carclass,
                carmodel_id : carmodel
            },
            success: function (data) {
                jQuery('#ajax-portfolio-container').html(data);
                $('#ajax-portfolio-container .project-block a').css('opacity', 1);
            }
        });
    });


});