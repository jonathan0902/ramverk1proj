<?php

namespace Anax\View;

use Anax\StyleChooser\StyleChooserController;

/**
 * A layout rendering views in defined regions.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

$htmlClass = $htmlClass ?? [];
$lang = $lang ?? "sv";
$charset = $charset ?? "utf-8";
$title = ($title ?? "No title") . ($baseTitle ?? " | No base title defined");
$bodyClass = $bodyClass ?? null;

// Set active stylesheet
$request = $di->get("request");
$session = $di->get("session");
if ($request->getGet("style")) {
    $session->set("redirect", currentUrl());
    redirect("style/update/" . rawurlencode($_GET["style"]));
}

// Get the active stylesheet, if any.
$activeStyle = $session->get(StyleChooserController::getSessionKey(), null);
if ($activeStyle) {
    $stylesheets = [];
    $stylesheets[] = $activeStyle;
}

// Get hgrid & vgrid
if ($request->hasGet("hgrid")) {
    $htmlClass[] = "hgrid";
}
if ($request->hasGet("vgrid")) {
    $htmlClass[] = "vgrid";
}

// Show regions
if ($request->hasGet("regions")) {
    $htmlClass[] = "regions";
}

// Get flash message if any and add to region flash-message
$flashMessage = $session->getOnce("flashmessage");
if ($flashMessage) {
    $di->get("view")->add(__DIR__ . "/../flashmessage/default", ["message" => $flashMessage], "flash-message");
}

// Get current route to make as body class
$route = "route-" . str_replace("/", "-", $di->get("request")->getRoute());
$url = explode('/', $_SERVER['REQUEST_URI']);

if (!$this->di->get("session")->get("access") && $url[count($url) - 1] != "login" && $url[count($url) - 1] != "create") {
    header('Refresh: 0, url = /dbwebb/ramverk1/me/kmom10/htdocs/user/login');
}

if (isset($_GET["logout"])) {
    $this->di->get("session")->destroy();
    header('Refresh: 0, url = /dbwebb/ramverk1/me/kmom10/htdocs/user/login');
}

if ($this->di->get("session")->get("access") || (!$this->di->get("session")->get("access") && $url[count($url) - 1] == "login") || (!$this->di->get("session")->get("access") && $url[count($url) - 1] == "create")) : ?>
<!doctype html>
<html <?= classList($htmlClass) ?> lang="<?= $lang ?>">
<head>

    <meta charset="<?= $charset ?>">
    <title><?= $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <?php if (isset($favicon)) : ?>
    <link rel="icon" href="<?= asset($favicon) ?>">
    <?php endif; ?>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <?php if (isset($stylesheets) && $url[count($url) - 1] != "login") : ?>
        <?php foreach ($stylesheets as $stylesheet) : ?>
            <link rel="stylesheet" type="text/css" href="<?= asset($stylesheet) ?>">
        <?php endforeach; ?>
    <?php else : ?>
        <link rel="stylesheet" type="text/css" href="../css/login.css">
    <?php endif; ?>


    <?php if (isset($style)) : ?>
    <style><?= $style ?></style>
    <?php endif; ?>

</head>

<body <?= classList($bodyClass, $route) ?>>

<!-- wrapper around all items on page -->
<div class="wrap-all">
    <?php if ($url[count($url) - 1] != "login") : ?>
        <!-- siteheader with optional columns -->
        <?php if (regionHasContent("header") || regionHasContent("header-col-1")) : ?>
                <nav class="navbar navbar-expand-lg navbar-dark bg-light">
                    <a class="navbar-brand" href="#">Fibergram</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                        </ul>
                        <!-- header-col-2 -->
                        <?php if (regionHasContent("header-col-2")) : ?>
                            <?php renderRegion("header-col-2")?>
                        <?php endif; ?>
                        <!-- header-col-3 -->
                        <?php if (regionHasContent("header-col-3")) : ?>
                            <?php renderRegion("header-col-3") ?>
                        <?php endif; ?>

                        <?php if ($this->di->get("session")->get("access")) : ?>
                        <div class="devider">
                            <span>|</span>
                        </div>
                        <a class="nav-link" href="/dbwebb/ramverk1/me/kmom10/htdocs/show/user/<?= $this->di->get("session")->get("user"); ?>"><span>@<?= $this->di->get("session")->get("user") ?></span></a>
                        <form class="form-inline my-2 my-lg-0" method="GET">
                            <input class="btn" type="submit" name="logout" value="Log out">
                        </form>
                    </div>
                        <?php endif; ?>
                    </div>
                </nav>
        <?php endif; ?>
        <!-- navbar -->
        <?php if (regionHasContent("navbar")) : ?>
        <div class="outer-wrap outer-wrap-navbar">
            <div class="inner-wrap inner-wrap-navbar">
                    <nav class="region-navbar" role="navigation">
                        <?php renderRegion("navbar") ?>
                    </nav>
            </div>
        </div>
        <?php endif; ?>
        <!-- flash -->
        <?php if (regionHasContent("flash")) : ?>
            <div class="outer-wrap outer-wrap-flash">
            <div class="inner-wrap inner-wrap-flash">
                    <div class="region-flash">
                        <?php renderRegion("flash") ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <!-- breadcrumb -->
        <?php if (regionHasContent("breadcrumb")) : ?>
        <div class="outer-wrap outer-wrap-breadcrumb">
            <div class="inner-wrap inner-wrap-breadcrumb">
                    <div class="region-breadcrumb">
                        <?php renderRegion("breadcrumb") ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <!-- flash message -->
        <?php if (regionHasContent("flash-message")) : ?>
        <div class="outer-wrap outer-wrap-flash-message">
            <div class="inner-wrap inner-wrap-flash-message">
                    <div class="region-flash-message">
                        <?php renderRegion("flash-message") ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <!-- columns-above -->
        <?php if (regionHasContent("columns-above")) : ?>
        <div class="outer-wrap outer-wrap-columns-above">
            <div class="inner-wrap inner-wrap-columns-above">
                    <div class="region-columns-above">
                        <?php renderRegion("columns-above") ?>
                    </div>
            </div>
        </div>
        <?php endif; ?>
    <?php endif; ?>
        <!-- main -->
        <div class="outer-wrap outer-wrap-main">
            <div class="inner-wrap inner-wrap-main">
        <?php
        $sidebarLeft  = regionHasContent("sidebar-left");
        $sidebarRight = regionHasContent("sidebar-right");
        $class = "";
        $class .= $sidebarLeft  ? "has-sidebar-left "  : "";
        $class .= $sidebarRight ? "has-sidebar-right " : "";
        $class .= empty($class) ? "" : "has-sidebar";
        ?>
                    <?php if ($sidebarLeft) : ?>
                    <div class="wrap-sidebar region-sidebar-left <?= $class ?>" role="complementary">
                        <?php renderRegion("sidebar-left") ?>
                    </div>
                    <?php endif; ?>

                    <?php if (regionHasContent("main")) : ?>
                    <main class="region-main <?= $class ?>" role="main">
                        <?php renderRegion("main") ?>
                    </main>
                    <?php endif; ?>

                    <?php if ($sidebarRight) : ?>
                    <div class="wrap-sidebar region-sidebar-right <?= $class ?>" role="complementary">
                        <?php renderRegion("sidebar-right") ?>
                    </div>
                    <?php endif; ?>

            </div>
        </div>



        <!-- after-main -->
        <?php if (regionHasContent("after-main")) : ?>
        <div class="outer-wrap outer-wrap-after-main">
            <div class="inner-wrap inner-wrap-after-main">
                    <div class="region-after-main">
                        <?php renderRegion("after-main") ?>
                    </div>
            </div>
        </div>
        <?php endif; ?>



        <!-- columns-below -->
        <?php if (regionHasContent("columns-below")) : ?>
        <div class="outer-wrap outer-wrap-columns-below">
            <div class="inner-wrap inner-wrap-columns-below">
                    <div class="region-columns-below">
                        <?php renderRegion("columns-below") ?>
                    </div>
            </div>
        </div>
        <?php endif; ?>



        <!-- sitefooter -->
        <?php if (regionHasContent("footer")) : ?>
        <div class="outer-wrap outer-wrap-footer" role="contentinfo">
            <div class="inner-wrap inner-wrap-footer">
                    <div class="region-footer">
                        <?php renderRegion("footer") ?>
                    </div>
            </div>
        </div>
        <?php endif; ?>



        </div> <!-- end of wrapper -->



        <!-- render javascripts -->
        <?php if (isset($javascripts)) : ?>
            <?php foreach ($javascripts as $javascript) : ?>
            <script async src="<?= asset($javascript) ?>"></script>
            <?php endforeach; ?>
        <?php endif; ?>


        <!-- useful for inline javascripts such as google analytics-->
        <?php if (regionHasContent("body-end")) : ?>
            <?php renderRegion("body-end") ?>
        <?php endif; ?>

    </body>
    </html>
<?php endif;