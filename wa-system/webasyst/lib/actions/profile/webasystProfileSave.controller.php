<?php

/**
 * Save contact data that came from profile form.
 * 
 * @package wa-system/webasyst/profile
 */
class webasystProfileSaveController extends waJsonController
{
    /** @var waContact */
    protected $contact;

    public function execute()
    {
        $this->contact = wa()->getUser();

        $data = json_decode(waRequest::post('data'), true);
        if (!$data || !is_array($data)) {
            $this->response = array(
               'errors' => array(),
               'data' => array(),
            );
            return;
        }

        // Make sure only allowed fields are saved
        $allowed = array();
        foreach(waContactFields::getAll('person') as $f) {
            if ($f->getParameter('allow_self_edit')) {
                $allowed[$f->getId()] = true;
            }
        }
        $data = array_intersect_key($data, $allowed);

        $oldLocale = $this->getUser()->getLocale();

        // Validate and save contact if no errors found
        $errors = $this->contact->save($data, true);

        if ($errors) {
            $response = array();
        } else {
            // New data formatted for JS
            $response['name'] = $this->contact->get('name', 'js');
            foreach ($data as $field_id => $field_value) {
                if (!isset($errors[$field_id])) {
                    $response[$field_id] = $this->contact->get($field_id, 'js');
                }
            }

            // Top fields
            $response['top'] = array();
            foreach (array('email', 'phone', 'im') as $f) {
                if ( ( $v = $this->contact->get($f, 'top,html'))) {
                    $response['top'][] = array(
                        'id' => $f,
                        'name' => waContactFields::get($f)->getName(),
                        'value' => is_array($v) ? implode(', ', $v) : $v,
                    );
                }
            }
        }

        // Reload page with new language if user just changed it in own profile
        if ($oldLocale != $this->contact->getLocale()) {
            $response['reload'] = TRUE;
        }

        $this->response = array(
           'errors' => $errors,
           'data' => $response,
        );
    }
}
