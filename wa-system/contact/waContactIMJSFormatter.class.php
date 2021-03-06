<?php

/**
 * This file is part of Webasyst framework.
 *
 * Licensed under the terms of the GNU Lesser General Public License (LGPL).
 * http://www.webasyst.com/framework/license/
 *
 * @link http://www.webasyst.com/
 * @author Webasyst LLC
 * @copyright 2011 Webasyst LLC
 * @package wa-system/Contact
 * @license http://www.webasyst.com/framework/license/ LGPL
 */
class waContactIMJSFormatter extends waContactFieldFormatter
{
    public function format($data)
    {
        if (is_array($data)) {
            $data['data'] = $data['value'];
            $data['value'] = htmlspecialchars($data['value']);
        } else {
            $data = array(
                'data' => $data,
                'value' => htmlspecialchars($data),
            );
        }
        if (!$data['data']) {
            $data['value'] = '';
            return $data;
        }
        
        $icon = '';
        if (isset($data['ext']) && $data['ext'] && ( $f = waContactFields::get('im'))) {
            $exts = $f->getParameter('ext');
            if (isset($exts[$data['ext']])) {
                $icon = '<i class="icon16 '.$data['ext'].'"></i>';
            }
        }
        
        if (!$icon) {
            $icon = '<i class="icon16 im"></i>';
        }
        
        $data['value'] = $icon.$data['value'];
        return $data;
    }
}
