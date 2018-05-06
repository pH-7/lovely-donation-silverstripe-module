<?php

namespace PH7\Donation\Controllers;

use Exception;
use SilverStripe\Control\Controller as BaseController;
use SilverStripe\Control\Director;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\HTTPResponse;
use SilverStripe\Core\Config\Config;
use SilverStripe\GraphQL\Auth\Handler;
use SilverStripe\Security\Member;
use SilverStripe\Security\Permission;
use SilverStripe\Versioned\Versioned;

class DonationController extends BaseController
{
    const PAGE_TITLE = 'Donation';

    public function init()
    {
        parent::init();

        if (Director::fileExists(project() . '/css/style.css')) {
            Requirements::css(project() . '/css/style.css');
        } else {
            Requirements::css('donation/css/style.css');
        }
    }

    public function index(HTTPRequest $request)
    {
        return [
            'Title' => self::PAGE_TITLE
        ];
    }

    public function handleComment($data, $form)
    {
        $existing = $this->Comments()->filter([
            'Comment' => $data['Comment']
        ]);
        if ($existing->exists() && strlen($data['Comment']) > 20) {
            $form->sessionMessage('That comment already exists! Spammer!', 'bad');

            return $this->redirectBack();
        }
    }
}
