<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Testimonials\Testimonials\Code\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Model\BaseModel;
use Kazist\KazistFactory;
use Kazist\Service\Database\Query;

/**
 * Description of MarketplaceModel
 *
 * @author sbc
 */
class TestimonialsModel extends BaseModel {

    public function saveTestimonial($form) {

        $factory = new KazistFactory();

        $form['image'] = ($form['image_default'] <> '') ? $form['image_default'] : $form['image'];

        $id = $factory->saveRecord('#__testimonials_testimonials', $form);

        if ($id) {
            $msg = 'Business Save Successfully.';

            $factory->enqueueMessage($msg, 'info');
            $redirect = $this->generateUrl('testimonials.testimonials.detail', array('id', $id));

            $this->saveTestimonialPhotos($id);
        } else {

            $msg = 'Saving Business Failed.';
            $factory->enqueueMessage($msg, 'info');
            $redirect = $this->generateUrl('businesses.businesses.edit');
        }

        return $redirect;
    }

    public function saveTestimonialPhotos($testimonial_id) {

        $factory = new KazistFactory();

        $media_ids = $factory->uploadMedia('photo');

        if (!empty($media_ids)) {
            foreach ($media_ids as $media_id) {
                $std_class = new \stdClass();

                $std_class->id = $testimonial_id;
                $std_class->image = $media_id;

                $factory->saveRecord('#__testimonials_testimonials', $std_class);
            }
        }
    }

    public function getTestimonials($offset = 0, $limit = 3) {

        $factory = new KazistFactory();

        $session = $factory->getSession();

        //$email->debug_exit = true;
        $uri = $session->get('uri');

        $query = new Query();
        $query->select('tt.*');
        $query->from('#__testimonials_testimonials', 'tt');

        $query->orderBy('id ', 'DESC');

        $query->setFirstResult($offset);
        $query->setMaxResults($limit);

        $record = $query->loadObjectList();

        return $record;
    }

    public function getTotalTestimonials() {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('COUNT(*) AS total');
        $query->from('#__testimonials_testimonials', 'tt');



        $record = $query->loadObject();

        return $record->total;
    }

    //put your code here
    public function getAdditionalDetail($items) {

        $tmp_array = array();

        if (!empty($items)) {
            foreach ($items as $item) {
                $tmp_array[] = $this->getItemAdditionDetails($item);
            }
        }

        return $tmp_array;
    }

    public function getItemAdditionDetails($item) {
        $factory = new KazistFactory();

        $item_obj = (is_object($item)) ? $item : new \stdClass();

        $item_obj->title = ucwords($item->title);
        $item_obj->media = $factory->getMedia($item->image);

        return $item_obj;
    }

    public function loadTestimonials() {
        $paths = array();

        $object_arr = new \stdClass();
        $factory = new KazistFactory();


        $offset = $this->request->request->get('offset');
        $action = $this->request->request->get('action');

        $object_arr->offset = ($action == 'previous') ? $offset - 2 : $offset + 2;

        $template = 'testimonial.list.twig';
        $this->twig_paths[] = realpath(JPATH_ROOT . '/applications/Testimonials/generalviews');
        $html = $factory->renderData($object_arr, $template, $paths);


        return $html;
    }

}
