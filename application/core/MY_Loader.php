<?php
class MY_Loader extends CI_Loader {

    public function template($template_name, $view, $vars = array(), $subViews = array(), $return = FALSE) {
        if ($return):
            $content = $this->view($template_name . '/header', $vars, $return);
            $content .= $this->view($view, $vars, $return);
            if (count($subViews) > 0) {
                foreach ($subViews as $item) {
                    $content .= $this->view($item, $vars, $return);
                }
            }
            $content .= $this->view($template_name . '/footer', $vars, $return);

            return $content;
        else:
            $this->view($template_name . '/header', $vars);
            $this->view($view, $vars);
            if (count($subViews) > 0) {
                foreach ($subViews as $item) {
                    $this->view($item, $vars, $return);
                }
            }
            $this->view($template_name . '/footer', $vars);
        endif;
    }

}
