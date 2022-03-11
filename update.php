<?php

namespace Saturn;

use ZipArchive;

class Updater
{
    public function Download()
    {
        $remoteVersion = file_get_contents('https://link.saturncms.net/?latest_version');

        $downloadUrl = 'https://saturncms.net/download/update/'.$remoteVersion.'.zip';
        $downloadTo = 'update.zip';

        if (strpos($downloadUrl, 'saturncms.net') !== false) {
            $installFile = $downloadTo;
            file_put_contents($installFile, fopen($downloadUrl, 'r'));
            $path = pathinfo(realpath($installFile), PATHINFO_DIRNAME);
            $archive = new ZipArchive();
            $res = $archive->open($installFile);
            if ($res) {
                $archive->extractTo($path);
                $archive->close();
                if (!unlink($installFile)) {
                    $errorMsg = 'Saturn update error: Unable to delete the system update.';
                    header('Location: /update.php?ErrorMsg='.$errorMsg);
                } else {
                    header('Location: /update.php?Status=Reset_Config');
                }
            } else {
                $errorMsg = 'Saturn update error: Unable to unzip the archive.';
                header('Location: /update.php?ErrorMsg='.$errorMsg);
            }
        } else {
            $errorMsg = 'Saturn update error: Halted download from untrusted URL. Attempted to download from: '.$downloadUrl;
            header('Location: /update.php?ErrorMsg='.$errorMsg);
        }
        exit;
    }

    public function Delete_Item($directory)
    {
        if (is_dir($directory)) {
            $objects = scandir($directory);
            foreach ($objects as $object) {
                if ($object != '.' && $object != '..') {
                    if (is_dir($directory.DIRECTORY_SEPARATOR.$object) && !is_link($directory.'/'.$object)) {
                        $this->Delete_Item($directory.DIRECTORY_SEPARATOR.$object);
                    } else {
                        unlink($directory.DIRECTORY_SEPARATOR.$object);
                    }
                }
            }
            rmdir($directory);
        }
    }

    public function Reset_Installation()
    {
        $items = scandir(__DIR__);

        foreach ($items as $item) {
            if ($item != '.' && $item != '..' && $item != 'config.php' && $item != 'theme.php' && $item != 'storage' && $item != 'themes' && $item != 'update.php') {
                $this->Delete_Item($item);
            }
        }
    }

    public function Reset_Config($send_data)
    {
        include 'config.php';
        $file = __DIR__.'/config.php';
        $message = "<?php
    /*
     * Saturn Configuration File
     * Copyright (c) 2022 - Saturn Authors
     * saturncms.net
     *
     * You should not edit this file directly as it can cause errors to occur.
     * Please visit the Admin Panel's Website Settings page to change this file from there.
     *
     * For help visit docs.saturncms.net
     */

    /* General */
    const CONFIG_INSTALL_URL = '".CONFIG_INSTALL_URL."';
    const CONFIG_ACTIVATION_KEY = '".CONFIG_ACTIVATION_KEY."';
    const CONFIG_SITE_NAME = '".CONFIG_SITE_NAME."';
    const CONFIG_SITE_DESCRIPTION = '".CONFIG_SITE_DESCRIPTION."';
    const CONFIG_SITE_KEYWORDS = '".CONFIG_SITE_KEYWORDS."';
    const CONFIG_SITE_CHARSET = '".CONFIG_SITE_CHARSET."';
    const CONFIG_SITE_TIMEZONE = '".CONFIG_SITE_TIMEZONE."';
    const CONFIG_SEND_DATA = ".(bool) $send_data.';
    /* Users and Accounts */
    const CONFIG_REGISTRATION_ENABLED = '.(bool) CONFIG_REGISTRATION_ENABLED.";
    /* Database */
    const DATABASE_HOST = '".DATABASE_HOST."';
    const DATABASE_NAME = '".DATABASE_NAME."';
    const DATABASE_USERNAME = '".DATABASE_USERNAME."';
    const DATABASE_PASSWORD = '".DATABASE_PASSWORD."';
    const DATABASE_PORT = '".DATABASE_PORT."';
    const DATABASE_PREFIX = '".DATABASE_PREFIX."';
    /* Email */
    const CONFIG_EMAIL_ADMIN = '".CONFIG_EMAIL_ADMIN."';
    const CONFIG_EMAIL_FUNCTION = '".CONFIG_EMAIL_FUNCTION."';
    const CONFIG_EMAIL_SENDFROM = '".CONFIG_EMAIL_SENDFROM."';
    /* Editing */
    const CONFIG_PAGE_APPROVALS = '".CONFIG_PAGE_APPROVALS."';
    const CONFIG_ARTICLE_APPROVALS = ".(bool) CONFIG_ARTICLE_APPROVALS.";
    const CONFIG_MAX_TITLE_CHARS = '".CONFIG_MAX_TITLE_CHARS."';
    const CONFIG_MAX_PAGE_CHARS = '".CONFIG_MAX_PAGE_CHARS."';
    const CONFIG_MAX_ARTICLE_CHARS = '".CONFIG_MAX_ARTICLE_CHARS."';
    const CONFIG_MAX_REFERENCES_CHARS = '".CONFIG_MAX_REFERENCES_CHARS."';
    /* Notifications */
    const CONFIG_NOTIFICATIONS_LIMIT = '".CONFIG_NOTIFICATIONS_LIMIT."';
    const CONFIG_ALLOW_SATURN_NOTIFICATIONS = ".(bool) CONFIG_ALLOW_SATURN_NOTIFICATIONS.';
    const CONFIG_ALLOW_EMAIL_NOTIFICATIONS = '.(bool) CONFIG_ALLOW_EMAIL_NOTIFICATIONS.';
    /* Welcome Screen */
    const CONFIG_WELCOME_SCREEN = '.(bool) CONFIG_WELCOME_SCREEN.';
    const CONFIG_WELCOME_SCREEN_SHOW_TERMS = '.(bool) CONFIG_WELCOME_SCREEN_SHOW_TERMS.';
    /* Security */
    const SECURITY_ACTIVE = '.(bool) SECURITY_ACTIVE.";
    const SECURITY_MODE = '".SECURITY_MODE."';
    const SECURITY_USE_HTTPS = ".SECURITY_USE_HTTPS.';
    const SECURITY_USE_GSS = '.(bool) SECURITY_USE_GSS.";
    const SECURITY_DEFAULT_HASH = '".SECURITY_DEFAULT_HASH."';
    const SECURITY_CHECKSUM_HASH = '".SECURITY_CHECKSUM_HASH."';
    const LOGGING_ACTIVE = ".(bool) LOGGING_ACTIVE.';
    const LOGGING_AUTOLOG = '.(bool) LOGGING_AUTOLOG.';
    /* Developer Tools */
    const CONFIG_DEBUG = '.(bool) CONFIG_DEBUG.";
    /* Updating */
    const CONFIG_UPDATE_CHECK = true;
    const CONFIG_UPDATE_AUTO = true;
    /* Permissions */
    const PERMISSION_CREATE_CATEGORY = '".PERMISSION_CREATE_CATEGORY."';
    const PERMISSION_CREATE_PAGE = '".PERMISSION_CREATE_PAGE."';
    const PERMISSION_EDIT_PAGE_SETTINGS = '".PERMISSION_EDIT_PAGE_SETTINGS."';";

        if (file_put_contents($file, $message, LOCK_EX)) {
            header('Location: /update.php?Status=Done');
        } else {
            $errorMsg = 'Unable to save website settings, an error occurred.';
            header('Location: /update.php?ErrorMsg='.$errorMsg);
        }
        exit;
    }

    public function UpdateSaturn()
    {
        ob_start();

        if (isset($_GET['Status'])) {
            if ($_GET['Status'] == 'Reset_Config') {
                ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Saturn Updater</title>
        <script src="https://cdn.tailwindcss.com"></script>
		<script src="https://kit.fontawesome.com/f7a3170e6f.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="text-center w-full">
			<br><br>
			<i class="fa-solid fa-chart-line fa-5x" aria-hidden="true"></i>
			<br><br>
            <h1 class="font-bold text-2xl">
                Saturn Diagnostics and Usage Data
            </h1>
			<br>
            <p>
                Help LMWN improve Saturn's products and services by allowing telemetry of usage and diagnostics data from your installation.<br>
                All data is collected with privacy in mind, and user specific data is never sent.<br>
                <br>
                <a href="update.php?Status=Data_Consent&Yes" class="px-4 py-2 bg-blue-500 shadow hover:shadow-xl rounded-lg text-white transition duration-200">Share Data with Saturn</a><br><br>
				<a href="update.php?Status=Data_Consent&No" class="text-blue-500">Don't share</a>
            </p>
        </div>
    </body>
</html>
<?php
                exit;
            } elseif ($_GET['Status'] == 'Data_Consent') {
                if (isset($_GET['Yes'])) {
                    $this->Reset_Config('true');
                } elseif (isset($_GET['No'])) {
                    $this->Reset_Config('false');
                }
            } elseif ($_GET['Status'] == 'Update') {
                $this->Reset_Installation();
                $this->Download();
            } elseif ($_GET['Status'] == 'Done') {
                unlink('update.php'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Saturn Updater</title>
        <script src="https://cdn.tailwindcss.com"></script>
		<script src="https://kit.fontawesome.com/f7a3170e6f.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="text-center w-full">
			<br><br>
			<i class="fa-solid fa-circle-check fa-5x" aria-hidden="true"></i>
			<br><br>
            <h1 class="font-bold text-2xl">
                Saturn has been updated
            </h1>
			<br>
            <p>
                Welcome to Saturn version <?php echo file_get_contents('https://link.saturncms.net/?latest_version'); ?><br>
                <br>
                <a href="/panel/admin" class="px-4 py-2 bg-blue-500 shadow hover:shadow-xl rounded-lg text-white transition duration-200">Back to the Admin Panel</a>
            </p>
        </div>
    </body>
</html>
<?php
            } else {
                ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Saturn Updater</title>
        <script src="https://cdn.tailwindcss.com"></script>
		<script src="https://kit.fontawesome.com/f7a3170e6f.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="text-center w-full">
			<br><br>
			<i class="fa-solid fa-circle-xmark fa-5x" aria-hidden="true"></i>
			<br><br>
            <h1 class="font-bold text-2xl">
                There was a problem whilst updating Saturn.
            </h1>
			<br>
            <p>
                <a href="/panel/admin" class="px-4 py-2 bg-blue-500 shadow hover:shadow-xl rounded-lg text-white transition duration-200">Back to the Admin Panel</a>
            </p>
        </div>
    </body>
</html>
<?php
            }
        } elseif (isset($_GET['ErrorMsg'])) {
            ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Saturn Updater</title>
        <script src="https://cdn.tailwindcss.com"></script>
		<script src="https://kit.fontawesome.com/f7a3170e6f.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="text-center w-full">
			<br><br>
			<i class="fa-solid fa-circle-xmark fa-5x" aria-hidden="true"></i>
			<br><br>
            <h1 class="font-bold text-2xl">
                There was a problem whilst updating Saturn.
            </h1>
			<br>
            <p>
                <?php echo htmlspecialchars($_GET['ErrorMsg']); ?><br>
                <br>
                <a href="/panel/admin" class="px-4 py-2 bg-blue-500 shadow hover:shadow-xl rounded-lg text-white transition duration-200">Back to the Admin Panel</a>
            </p>
        </div>
    </body>
</html>
<?php
        } else {
            header('Location: /update.php?Status=Update');
        }

        ob_end_flush();
    }
}

$Updater = new Updater();
$Updater->UpdateSaturn();
