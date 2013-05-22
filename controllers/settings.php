<?php

/**
 * Greylisting settings controller.
 *
 * @category   apps
 * @package    greylisting
 * @subpackage controllers
 * @author     ClearFoundation <developer@clearfoundation.com>
 * @copyright  2011-2012 ClearFoundation
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/greylisting/
 */

///////////////////////////////////////////////////////////////////////////////
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// C L A S S
///////////////////////////////////////////////////////////////////////////////

/**
 * Greylisting controller.
 *
 * @category   apps
 * @package    greylisting
 * @subpackage controllers
 * @author     ClearFoundation <developer@clearfoundation.com>
 * @copyright  2011-2012 ClearFoundation
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/greylisting/
 */

class Settings extends ClearOS_Controller
{
    /**
     * Greylisting settings controller.
     *
     * @return view
     */

    function index()
    {
        $this->_common('view');
    }

    /**
     * Edit view.
     *
     * @return view
     */

    function edit()
    {
        $this->_common('edit');
    }

    /**
     * View view.
     *
     * @return view
     */

    function view()
    {
        $this->_common('view');
    }

    /**
     * Common form widget.
     *
     * @param string $form_type form type
     *
     * @return view
     */

    function _common($form_type)
    {
        // Load libraries
        //---------------

        $this->lang->load('base');
        $this->load->library('greylisting/Postgrey');

        // Set validation rules
        //---------------------
         
        $this->form_validation->set_policy('delay', 'greylisting/Postgrey', 'validate_delay');
        $this->form_validation->set_policy('retention', 'greylisting/Postgrey', 'validate_retention_time');
        $form_ok = $this->form_validation->run();

        // Handle form submit
        //-------------------

        if (($this->input->post('submit') && $form_ok)) {
            try {
                $this->postgrey->set_delay($this->input->post('delay'));
                $this->postgrey->set_retention_time($this->input->post('retention_time'));
                $this->postgrey->reset(TRUE);

                $this->page->set_status_updated();
                redirect('/greylisting/settings');
            } catch (Engine_Exception $e) {
                $this->page->view_exception($e);
                return;
            }
        }

        // Load view data
        //---------------

        try {
            $data['form_type'] = $form_type;
            $data['delay'] = $this->postgrey->get_delay();
            $data['retention_time'] = $this->postgrey->get_retention_time();
        } catch (Exception $e) {
            $this->page->view_exception($e);
            return;
        }

        // Load views
        //-----------

        $this->page->view_form('greylisting/settings', $data, lang('base_settings'));
    }
}
