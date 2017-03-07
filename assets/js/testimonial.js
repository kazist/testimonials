/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


jQuery(document).ready(function () {
    testimonial.init();
});

testimonial = function () {
    return {
        init: function () {

            kazist.loadScriptByUrl(kazicode.url + '/applications/Testimonial/Components/assets/js/testimonial_photos.js');

            testimonial.addEvents(jQuery('body'));

        }, addEvents: function (html) {

            html = testimonial.addPhotosEvents(html);

            html.find(".testimonials-navigation a").on('click', function (event) {
                testimonial.loadTestimonials(jQuery(this));
            });

            return html;

        }, addPhotosEvents: function (html) {

            html.find('.photo-input').each(function () {
                testimonial_photos.photoClickEvent(jQuery(this));
            });

            return html;

        }, loadTestimonials: function (this_element) {

            var action = this_element.attr('action');
            var offset = this_element.attr('offset');
            var data_object = {action: action, offset: offset};

            var form = kazist.callAjaxByRoute('testimonials.testimonials.ajaxloadtestimonials', data_object, true);

            jQuery('.testimonial-testimonies-listing').html(form);

            testimonial.addEvents(jQuery('.testimonial-testimonies-listing'));
        }

    };
}();