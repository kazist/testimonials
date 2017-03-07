<?php

/*
 * This file is part of Kazist Framework.
 * (c) Dedan Irungu <irungudedan@gmail.com>
 *  For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 * 
 */

/**
 * Description of TestimonialsController
 *
 * @author sbc
 */

namespace Testimonials\Testimonials\Code\Controllers;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Controller\BaseController;
use Testimonials\Testimonials\Code\Models\TestimonialsModel;

class TestimonialsController extends BaseController {

    public function indexAction() {

        $this->model = new TestimonialsModel();

        $items = $this->model->getRecords();
        $items = $this->model->getAdditionalDetail($items);

        $data_arr['items'] = $items;

        $this->html = $this->render('Testimonials:Testimonials:Code:views:table.index.twig', $data_arr);

        $response = $this->response($this->html);



        return $response;
    }

    public function detailAction() {

        $this->twig_paths[] = JPATH_ROOT . '/applications/Testimonials/generalviews/';

        $this->model = new TestimonialsModel();

        $item = $this->model->getRecord();

        $data_arr['item'] = $item;

        $this->html = $this->render('Testimonials:Testimonials:Code:views:detail.index.twig', $data_arr);

        $response = $this->response($this->html);



        return $response;
    }

    public function editAction() {

        $factory = new KazistFactory;

        $this->model = new TestimonialsModel();

        $user = $factory->getUser();
        $item = $this->model->getRecord();

        $data_arr['user'] = $user;
        $data_arr['item'] = $item;

        $this->html = $this->render('Testimonials:Testimonials:Code:views:edit.index.twig', $data_arr);

        $response = $this->response($this->html);



        return $response;
    }

    public function saveAction() {
        $redirect = '';

        $this->model = new TestimonialsModel();

        $factory = new KazistFactory();

        $session = $factory->getSession();

        $user = $session->get('user');
        $base_url = WEB_ROOT;

        if ($user->id) {

            $form = $this->request->request->get('form');

            $return_url = $this->model->saveTestimonial($form);

            $redirect = $return_url;
        } else {
            $redirect = $this->generateUrl('login');
        }

        $this->redirect($redirect);
    }

}
