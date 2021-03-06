<?php

/**
 * Delete a contacts category
 * 
 * @package wa-apps/contacts
 */
class contactsCategoriesDeleteController extends waJsonController
{
    public function execute()
    {
        // only allowed to global admin
        if (!wa()->getUser()->getRights('webasyst', 'backend')) {
            throw new waRightsException('Access denied.');
        }

        if (! ( $id = waRequest::post('id'))) {
            throw new waException('no id');
        }

        $cm = new waContactCategoryModel();
        $cm->delete($id);
        $this->response['message'] = _w('Category has been deleted');
    }
}

// EOF