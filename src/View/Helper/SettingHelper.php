<?php 
namespace App\View\Helper;

use Cake\View\Helper;

class SettingHelper extends Helper
{
    public function formatCurrency($value)
    {
        return '&euro; ' . $value/100;
    }
}

?>
