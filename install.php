<?php
/**
 * CleanTalk SMF mod installation PHP code
 *
 * @package Cleantalk
 * @subpackage SMF
 * @author CleanTalk (welcome@cleantalk.ru)
 * @copyright (C) 2014 Сleantalk team (http://cleantalk.org)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 */

$hooks = array(
    'integrate_pre_include' => '$sourcedir/cleantalk/CleantalkMod.php',
    'integrate_register' => 'cleantalk_check_register',
    'integrate_general_mod_settings' => 'cleantalk_general_mod_settings',
    'integrate_load_theme' => 'cleantalk_load',
    'integrate_exit' => 'cleantalk_exit',
    'integrate_buffer' => 'cleantalk_buffer',
);

$isInstalling = empty($context['uninstalling']);

// set integration hooks
foreach ($hooks as $hook => $function) {
    if ($isInstalling) {
        add_integration_function($hook, $function);
    } else {
        remove_integration_function($hook, $function);
    }
}

if ($isInstalling) {
    // Anti-Spam Verification captcha disable
    updateSettings(array('reg_verification' => '0'), true);
    updateSettings(array('posts_require_captcha' => '0'), true);

    $oldKey = isset($modSettings['cleantalk_api_key']) ? $modSettings['cleantalk_api_key'] : '';

    updateSettings(array('cleantalk_api_key' => $oldKey), false);
    updateSettings(array('cleantalk_first_post_checking' => '1'), false);
    updateSettings(array('cleantalk_logging' => '0'), false);
} else {
    // Anti-Spam Verification captcha
    updateSettings(array('reg_verification' => '1'), true);
}
