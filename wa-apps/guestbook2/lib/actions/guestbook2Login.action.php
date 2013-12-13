<?php

/**
 * Login form action /login
 * Экшен формы логина /login
 * @see https://www.webasyst.com/framework/docs/dev/auth-frontend/
 * 
 * @package wa-apps/guestbook2
 */
class guestbook2LoginAction extends waLoginAction
{

    public function execute()
    {
        $this->setLayout(new guestbook2FrontendLayout());
        $this->setThemeTemplate('login.html');
        parent::execute();
    }

}