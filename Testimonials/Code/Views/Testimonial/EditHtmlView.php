<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Testimonials\Testimonials\Views\Testimonial;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazicode\View\Edit\EditHtmlView as GeneralEditHtmlView;
use Kazicode\Service\KazistFactory;

/**
 * News HTML view class for the application
 *
 * @since  1.0
 */
class EditHtmlView extends GeneralEditHtmlView {

    public function prepare() {

        $factory = new KazistFactory;

        parent::prepare();


        $user = $factory ->getUser();

        $this->renderer->set('user', $user);
    }

}
