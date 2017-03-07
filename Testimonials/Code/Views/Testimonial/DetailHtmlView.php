<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Testimonials\Testimonials\Views\Testimonial;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazicode\View\Detail\DetailHtmlView as GeneralDetailHtmlView;

/**
 * News HTML view class for the application
 *
 * @since  1.0
 */
class DetailHtmlView extends GeneralDetailHtmlView {

    public function prepare() {

        $extend_edit_dirs[] = JPATH_ROOT . '/applications/Testimonial/Components/Templates/';
        $this->renderer->addPath($extend_edit_dirs, true);

        parent::prepare();

        $item = $this->renderer->get('item');

        $this->renderer->set('item', $item);
    }

}
