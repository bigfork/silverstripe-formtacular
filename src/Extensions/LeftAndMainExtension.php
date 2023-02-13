<?php

namespace Bigfork\SilverstripeFormtacular\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\View\Requirements;

class LeftAndMainExtension extends Extension
{
    public function onAfterInit()
    {
        // Block front-end bundle
        Requirements::block('bigfork/silverstripe-formtacular: client/dist/js/bundle.js');

        // Include CMS bundle
        Requirements::javascript('bigfork/silverstripe-formtacular: client/dist/js/bundle-cms.js');
        Requirements::css('bigfork/silverstripe-formtacular: client/dist/styles/cms.css');
    }
}
