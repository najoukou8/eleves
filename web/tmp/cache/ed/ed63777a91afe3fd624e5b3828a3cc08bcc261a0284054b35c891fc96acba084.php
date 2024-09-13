<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* /base/base.html.twig */
class __TwigTemplate_32421f2fc6bf3ffea6aeb321eabb7a0808d810861ac802f2d1b58dd3ebafdc30 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"iso-8859-1\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <title>BE-V2 | Dashboard</title>

    <link rel=\"stylesheet\" href=\"https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback\">

    <link rel=\"stylesheet\" href=\"../../../public/plugins/fontawesome-free/css/all.min.css\">

    <link rel=\"stylesheet\" href=\"https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css\">

    <link rel=\"stylesheet\" href=\"../../../public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css\">

    <link rel=\"stylesheet\" href=\"../../../public/plugins/icheck-bootstrap/icheck-bootstrap.min.css\">

    <link rel=\"stylesheet\" href=\"../../../public/plugins/jqvmap/jqvmap.min.css\">

    <link rel=\"stylesheet\" href=\"../../../public/dist/css/adminlte.min.css?v=3.2.0\">

    <link rel=\"stylesheet\" href=\"../../../public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css\">

    <link rel=\"stylesheet\" href=\"../../../public/plugins/daterangepicker/daterangepicker.css\">

    <link rel=\"stylesheet\" href=\"../../../public/plugins/summernote/summernote-bs4.min.css\">

    <link rel=\"stylesheet\" type=\"text/css\" href=\"//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css\"/>
    <link rel=\"icon\" type=\"image/png\" href=\"https://web.gi.grenoble-inp.fr/eleves/icons/favicon.ico\" />
    <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css\">

    <style>
        @font-face {
            font-family: 'Vertexio';
            font-style: normal;
            font-weight: 700;
            src: local('Vertexio'), url('https://fonts.cdnfonts.com/s/78809/Soria-Bold.woff') format('woff');
        }
    </style>

</head>
<body class=\"hold-transition sidebar-mini layout-fixed\">
<div class=\"wrapper\">

    <div class=\"preloader flex-column justify-content-center align-items-center\">
        <img class=\"animation__shake\" src=\"https://web.gi.grenoble-inp.fr/eleves/icons/favicon.ico\" alt=\"AdminLTELogo\" height=\"60\" width=\"60\">
    </div>

    <nav class=\"main-header navbar navbar-expand navbar-white navbar-light\">

        <ul class=\"navbar-nav\">
            <li class=\"nav-item\">
                <a class=\"nav-link\" data-widget=\"pushmenu\" href=\"#\" role=\"button\"><i class=\"fas fa-bars\"></i></a>
            </li>
            <li class=\"nav-item d-none d-sm-inline-block\">
                <a href=\"index3.html\" class=\"nav-link\">Home</a>
            </li>
            <li class=\"nav-item d-none d-sm-inline-block\">
                <a href=\"#\" class=\"nav-link\">Contact</a>
            </li>
        </ul>

        <ul class=\"navbar-nav ml-auto\">

            <li class=\"nav-item\">
                <a class=\"nav-link\" data-widget=\"navbar-search\" href=\"#\" role=\"button\">
                    <i class=\"fas fa-search\"></i>
                </a>
                <div class=\"navbar-search-block\">
                    <form class=\"form-inline\">
                        <div class=\"input-group input-group-sm\">
                            <input class=\"form-control form-control-navbar\" type=\"search\" placeholder=\"Search\" aria-label=\"Search\">
                            <div class=\"input-group-append\">
                                <button class=\"btn btn-navbar\" type=\"submit\">
                                    <i class=\"fas fa-search\"></i>
                                </button>
                                <button class=\"btn btn-navbar\" type=\"button\" data-widget=\"navbar-search\">
                                    <i class=\"fas fa-times\"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>

            <li class=\"nav-item dropdown\">
                <a class=\"nav-link\" data-toggle=\"dropdown\" href=\"#\">
                    <i class=\"far fa-comments\"></i>
                    <span class=\"badge badge-danger navbar-badge\">3</span>
                </a>
                <div class=\"dropdown-menu dropdown-menu-lg dropdown-menu-right\">
                    <a href=\"#\" class=\"dropdown-item\">

                        <div class=\"media\">
                            <img src=\"https://adminlte.io/themes/v3/dist/img/user1-128x128.jpg\" alt=\"User Avatar\" class=\"img-size-50 mr-3 img-circle\">
                            <div class=\"media-body\">
                                <h3 class=\"dropdown-item-title\">
                                    Brad Diesel
                                    <span class=\"float-right text-sm text-danger\"><i class=\"fas fa-star\"></i></span>
                                </h3>
                                <p class=\"text-sm\">Call me whenever you can...</p>
                                <p class=\"text-sm text-muted\"><i class=\"far fa-clock mr-1\"></i> 4 Hours Ago</p>
                            </div>
                        </div>

                    </a>
                    <div class=\"dropdown-divider\"></div>
                    <a href=\"#\" class=\"dropdown-item\">

                        <div class=\"media\">
                            <img src=\"https://adminlte.io/themes/v3/dist/img/user8-128x128.jpg\" alt=\"User Avatar\" class=\"img-size-50 img-circle mr-3\">
                            <div class=\"media-body\">
                                <h3 class=\"dropdown-item-title\">
                                    John Pierce
                                    <span class=\"float-right text-sm text-muted\"><i class=\"fas fa-star\"></i></span>
                                </h3>
                                <p class=\"text-sm\">I got your message bro</p>
                                <p class=\"text-sm text-muted\"><i class=\"far fa-clock mr-1\"></i> 4 Hours Ago</p>
                            </div>
                        </div>

                    </a>
                    <div class=\"dropdown-divider\"></div>
                    <a href=\"#\" class=\"dropdown-item\">

                        <div class=\"media\">
                            <img src=\"https://adminlte.io/themes/v3/dist/img/user3-128x128.jpg\" alt=\"User Avatar\" class=\"img-size-50 img-circle mr-3\">
                            <div class=\"media-body\">
                                <h3 class=\"dropdown-item-title\">
                                    Nora Silvester
                                    <span class=\"float-right text-sm text-warning\"><i class=\"fas fa-star\"></i></span>
                                </h3>
                                <p class=\"text-sm\">The subject goes here</p>
                                <p class=\"text-sm text-muted\"><i class=\"far fa-clock mr-1\"></i> 4 Hours Ago</p>
                            </div>
                        </div>

                    </a>
                    <div class=\"dropdown-divider\"></div>
                    <a href=\"#\" class=\"dropdown-item dropdown-footer\">See All Messages</a>
                </div>
            </li>

            <li class=\"nav-item dropdown\">
                <a class=\"nav-link\" data-toggle=\"dropdown\" href=\"#\">
                    <i class=\"far fa-bell\"></i>
                    <span class=\"badge badge-warning navbar-badge\">15</span>
                </a>
                <div class=\"dropdown-menu dropdown-menu-lg dropdown-menu-right\">
                    <span class=\"dropdown-item dropdown-header\">15 Notifications</span>
                    <div class=\"dropdown-divider\"></div>
                    <a href=\"#\" class=\"dropdown-item\">
                        <i class=\"fas fa-envelope mr-2\"></i> 4 new messages
                        <span class=\"float-right text-muted text-sm\">3 mins</span>
                    </a>
                    <div class=\"dropdown-divider\"></div>
                    <a href=\"#\" class=\"dropdown-item\">
                        <i class=\"fas fa-users mr-2\"></i> 8 friend requests
                        <span class=\"float-right text-muted text-sm\">12 hours</span>
                    </a>
                    <div class=\"dropdown-divider\"></div>
                    <a href=\"#\" class=\"dropdown-item\">
                        <i class=\"fas fa-file mr-2\"></i> 3 new reports
                        <span class=\"float-right text-muted text-sm\">2 days</span>
                    </a>
                    <div class=\"dropdown-divider\"></div>
                    <a href=\"#\" class=\"dropdown-item dropdown-footer\">See All Notifications</a>
                </div>
            </li>
            <li class=\"nav-item\">
                <a class=\"nav-link\" data-widget=\"fullscreen\" href=\"#\" role=\"button\">
                    <i class=\"fas fa-expand-arrows-alt\"></i>
                </a>
            </li>
            <li class=\"nav-item\">
                <a class=\"nav-link\" data-widget=\"control-sidebar\" data-controlsidebar-slide=\"true\" href=\"#\" role=\"button\">
                    <i class=\"fas fa-th-large\"></i>
                </a>
            </li>
        </ul>
    </nav>


    <aside class=\"main-sidebar sidebar-dark-primary elevation-4\">



        <div class=\"sidebar\">

            <div class=\"user-panel mt-3 pb-3 mb-3 d-flex\">

                <div class=\"info\">
                    <p style=\"color: #dc051e ; font-size: 30px ; text-align: center ; font-weight: bold ; font-family: Vertexio ; background-color: #055181 ; border-radius: 8px ; color: #ffc107\">BASE ELEVES </p>
                    <a href=\"#\" class=\"d-block\" style=\"color: #8f8888\">";
        // line 194
        echo twig_escape_filter($this->env, ($context["emailConnecte"] ?? null), "html", null, true);
        echo "</a>
                </div>
            </div>

            <div class=\"form-inline\">
                <div class=\"input-group\" data-widget=\"sidebar-search\">
                    <input class=\"form-control form-control-sidebar\" type=\"search\" placeholder=\"Search\" aria-label=\"Search\">
                    <div class=\"input-group-append\">
                        <button class=\"btn btn-sidebar\">
                            <i class=\"fas fa-search fa-fw\"></i>
                        </button>
                    </div>
                </div>
            </div>

            <nav class=\"mt-2\">
                <ul class=\"nav nav-pills nav-sidebar flex-column\" data-widget=\"treeview\" role=\"menu\" data-accordion=\"false\">

                    <li class=\"nav-item menu-open\">
                        <a href=\"#\" class=\"nav-link active\">
                            <i class=\"nav-icon fas fa-tachometer-alt\"></i>
                            <p>
                                Dashboard
                                <i class=\"right fas fa-angle-left\"></i>
                            </p>
                        </a>
                        <ul class=\"nav nav-treeview\">
                            <li class=\"nav-item\">
                                <a href=\"./index.html\" class=\"nav-link active\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Dashboard v1</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"./index2.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Dashboard v2</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"./index3.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Dashboard v3</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"pages/widgets.html\" class=\"nav-link\">
                            <i class=\"nav-icon fas fa-th\"></i>
                            <p>
                                Widgets
                                <span class=\"right badge badge-danger\">New</span>
                            </p>
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"#\" class=\"nav-link\">
                            <i class=\"nav-icon fas fa-copy\"></i>
                            <p>
                                Layout Options
                                <i class=\"fas fa-angle-left right\"></i>
                                <span class=\"badge badge-info right\">6</span>
                            </p>
                        </a>
                        <ul class=\"nav nav-treeview\">
                            <li class=\"nav-item\">
                                <a href=\"pages/layout/top-nav.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Top Navigation</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/layout/top-nav-sidebar.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Top Navigation + Sidebar</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/layout/boxed.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Boxed</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/layout/fixed-sidebar.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Fixed Sidebar</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/layout/fixed-sidebar-custom.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Fixed Sidebar <small>+ Custom Area</small></p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/layout/fixed-topnav.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Fixed Navbar</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/layout/fixed-footer.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Fixed Footer</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/layout/collapsed-sidebar.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Collapsed Sidebar</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"#\" class=\"nav-link\">
                            <i class=\"nav-icon fas fa-chart-pie\"></i>
                            <p>
                                Charts
                                <i class=\"right fas fa-angle-left\"></i>
                            </p>
                        </a>
                        <ul class=\"nav nav-treeview\">
                            <li class=\"nav-item\">
                                <a href=\"pages/charts/chartjs.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>ChartJS</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/charts/flot.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Flot</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/charts/inline.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Inline</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/charts/uplot.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>uPlot</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"#\" class=\"nav-link\">
                            <i class=\"nav-icon fas fa-tree\"></i>
                            <p>
                                UI Elements
                                <i class=\"fas fa-angle-left right\"></i>
                            </p>
                        </a>
                        <ul class=\"nav nav-treeview\">
                            <li class=\"nav-item\">
                                <a href=\"pages/UI/general.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>General</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/UI/icons.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Icons</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/UI/buttons.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Buttons</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/UI/sliders.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Sliders</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/UI/modals.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Modals & Alerts</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/UI/navbar.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Navbar & Tabs</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/UI/timeline.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Timeline</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/UI/ribbons.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Ribbons</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"#\" class=\"nav-link\">
                            <i class=\"nav-icon fas fa-edit\"></i>
                            <p>
                                Forms
                                <i class=\"fas fa-angle-left right\"></i>
                            </p>
                        </a>
                        <ul class=\"nav nav-treeview\">
                            <li class=\"nav-item\">
                                <a href=\"pages/forms/general.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>General Elements</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/forms/advanced.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Advanced Elements</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/forms/editors.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Editors</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/forms/validation.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Validation</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"#\" class=\"nav-link\">
                            <i class=\"nav-icon fas fa-table\"></i>
                            <p>
                                Tables
                                <i class=\"fas fa-angle-left right\"></i>
                            </p>
                        </a>
                        <ul class=\"nav nav-treeview\">
                            <li class=\"nav-item\">
                                <a href=\"pages/tables/simple.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Simple Tables</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/tables/data.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>DataTables</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/tables/jsgrid.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>jsGrid</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class=\"nav-header\">EXAMPLES</li>
                    <li class=\"nav-item\">
                        <a href=\"pages/calendar.html\" class=\"nav-link\">
                            <i class=\"nav-icon far fa-calendar-alt\"></i>
                            <p>
                                Calendar
                                <span class=\"badge badge-info right\">2</span>
                            </p>
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"pages/gallery.html\" class=\"nav-link\">
                            <i class=\"nav-icon far fa-image\"></i>
                            <p>
                                Gallery
                            </p>
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"pages/kanban.html\" class=\"nav-link\">
                            <i class=\"nav-icon fas fa-columns\"></i>
                            <p>
                                Kanban Board
                            </p>
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"#\" class=\"nav-link\">
                            <i class=\"nav-icon far fa-envelope\"></i>
                            <p>
                                Mailbox
                                <i class=\"fas fa-angle-left right\"></i>
                            </p>
                        </a>
                        <ul class=\"nav nav-treeview\">
                            <li class=\"nav-item\">
                                <a href=\"pages/mailbox/mailbox.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Inbox</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/mailbox/compose.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Compose</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/mailbox/read-mail.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Read</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"#\" class=\"nav-link\">
                            <i class=\"nav-icon fas fa-book\"></i>
                            <p>
                                Pages
                                <i class=\"fas fa-angle-left right\"></i>
                            </p>
                        </a>
                        <ul class=\"nav nav-treeview\">
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/invoice.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Invoice</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/profile.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Profile</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/e-commerce.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>E-commerce</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/projects.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Projects</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/project-add.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Project Add</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/project-edit.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Project Edit</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/project-detail.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Project Detail</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/contacts.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Contacts</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/faq.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>FAQ</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/contact-us.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Contact us</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"#\" class=\"nav-link\">
                            <i class=\"nav-icon far fa-plus-square\"></i>
                            <p>
                                Extras
                                <i class=\"fas fa-angle-left right\"></i>
                            </p>
                        </a>
                        <ul class=\"nav nav-treeview\">
                            <li class=\"nav-item\">
                                <a href=\"#\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>
                                        Login & Register v1
                                        <i class=\"fas fa-angle-left right\"></i>
                                    </p>
                                </a>
                                <ul class=\"nav nav-treeview\">
                                    <li class=\"nav-item\">
                                        <a href=\"pages/examples/login.html\" class=\"nav-link\">
                                            <i class=\"far fa-circle nav-icon\"></i>
                                            <p>Login v1</p>
                                        </a>
                                    </li>
                                    <li class=\"nav-item\">
                                        <a href=\"pages/examples/register.html\" class=\"nav-link\">
                                            <i class=\"far fa-circle nav-icon\"></i>
                                            <p>Register v1</p>
                                        </a>
                                    </li>
                                    <li class=\"nav-item\">
                                        <a href=\"pages/examples/forgot-password.html\" class=\"nav-link\">
                                            <i class=\"far fa-circle nav-icon\"></i>
                                            <p>Forgot Password v1</p>
                                        </a>
                                    </li>
                                    <li class=\"nav-item\">
                                        <a href=\"pages/examples/recover-password.html\" class=\"nav-link\">
                                            <i class=\"far fa-circle nav-icon\"></i>
                                            <p>Recover Password v1</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"#\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>
                                        Login & Register v2
                                        <i class=\"fas fa-angle-left right\"></i>
                                    </p>
                                </a>
                                <ul class=\"nav nav-treeview\">
                                    <li class=\"nav-item\">
                                        <a href=\"pages/examples/login-v2.html\" class=\"nav-link\">
                                            <i class=\"far fa-circle nav-icon\"></i>
                                            <p>Login v2</p>
                                        </a>
                                    </li>
                                    <li class=\"nav-item\">
                                        <a href=\"pages/examples/register-v2.html\" class=\"nav-link\">
                                            <i class=\"far fa-circle nav-icon\"></i>
                                            <p>Register v2</p>
                                        </a>
                                    </li>
                                    <li class=\"nav-item\">
                                        <a href=\"pages/examples/forgot-password-v2.html\" class=\"nav-link\">
                                            <i class=\"far fa-circle nav-icon\"></i>
                                            <p>Forgot Password v2</p>
                                        </a>
                                    </li>
                                    <li class=\"nav-item\">
                                        <a href=\"pages/examples/recover-password-v2.html\" class=\"nav-link\">
                                            <i class=\"far fa-circle nav-icon\"></i>
                                            <p>Recover Password v2</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/lockscreen.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Lockscreen</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/legacy-user-menu.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Legacy User Menu</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/language-menu.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Language Menu</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/404.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Error 404</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/500.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Error 500</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/pace.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Pace</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/blank.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Blank Page</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"starter.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Starter Page</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"#\" class=\"nav-link\">
                            <i class=\"nav-icon fas fa-search\"></i>
                            <p>
                                Search
                                <i class=\"fas fa-angle-left right\"></i>
                            </p>
                        </a>
                        <ul class=\"nav nav-treeview\">
                            <li class=\"nav-item\">
                                <a href=\"pages/search/simple.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Simple Search</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/search/enhanced.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Enhanced</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class=\"nav-header\">MISCELLANEOUS</li>
                    <li class=\"nav-item\">
                        <a href=\"iframe.html\" class=\"nav-link\">
                            <i class=\"nav-icon fas fa-ellipsis-h\"></i>
                            <p>Tabbed IFrame Plugin</p>
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"https://adminlte.io/docs/3.1/\" class=\"nav-link\">
                            <i class=\"nav-icon fas fa-file\"></i>
                            <p>Documentation</p>
                        </a>
                    </li>
                    <li class=\"nav-header\">MULTI LEVEL EXAMPLE</li>
                    <li class=\"nav-item\">
                        <a href=\"#\" class=\"nav-link\">
                            <i class=\"fas fa-circle nav-icon\"></i>
                            <p>Level 1</p>
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"#\" class=\"nav-link\">
                            <i class=\"nav-icon fas fa-circle\"></i>
                            <p>
                                Level 1
                                <i class=\"right fas fa-angle-left\"></i>
                            </p>
                        </a>
                        <ul class=\"nav nav-treeview\">
                            <li class=\"nav-item\">
                                <a href=\"#\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Level 2</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"#\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>
                                        Level 2
                                        <i class=\"right fas fa-angle-left\"></i>
                                    </p>
                                </a>
                                <ul class=\"nav nav-treeview\">
                                    <li class=\"nav-item\">
                                        <a href=\"#\" class=\"nav-link\">
                                            <i class=\"far fa-dot-circle nav-icon\"></i>
                                            <p>Level 3</p>
                                        </a>
                                    </li>
                                    <li class=\"nav-item\">
                                        <a href=\"#\" class=\"nav-link\">
                                            <i class=\"far fa-dot-circle nav-icon\"></i>
                                            <p>Level 3</p>
                                        </a>
                                    </li>
                                    <li class=\"nav-item\">
                                        <a href=\"#\" class=\"nav-link\">
                                            <i class=\"far fa-dot-circle nav-icon\"></i>
                                            <p>Level 3</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"#\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Level 2</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"#\" class=\"nav-link\">
                            <i class=\"fas fa-circle nav-icon\"></i>
                            <p>Level 1</p>
                        </a>
                    </li>
                    <li class=\"nav-header\">LABELS</li>
                    <li class=\"nav-item\">
                        <a href=\"#\" class=\"nav-link\">
                            <i class=\"nav-icon far fa-circle text-danger\"></i>
                            <p class=\"text\">Important</p>
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"#\" class=\"nav-link\">
                            <i class=\"nav-icon far fa-circle text-warning\"></i>
                            <p>Warning</p>
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"#\" class=\"nav-link\">
                            <i class=\"nav-icon far fa-circle text-info\"></i>
                            <p>Informational</p>
                        </a>
                    </li>
                </ul>
            </nav>

        </div>

    </aside>

    <div class=\"content-wrapper\">




        <section class=\"content\">
            <div class=\"container-fluid\">

                <div class=\"row\">
                    <div class=\"col-lg-3 col-6\">

                        <div class=\"small-box bg-info\">
                            <div class=\"inner\">
                                <h3>150</h3>
                                <p>New Orders</p>
                            </div>
                            <div class=\"icon\">
                                <i class=\"ion ion-bag\"></i>
                            </div>
                            <a href=\"#\" class=\"small-box-footer\">More info <i class=\"fas fa-arrow-circle-right\"></i></a>
                        </div>
                    </div>

                    <div class=\"col-lg-3 col-6\">

                        <div class=\"small-box bg-success\">
                            <div class=\"inner\">
                                <h3>53<sup style=\"font-size: 20px\">%</sup></h3>
                                <p>Bounce Rate</p>
                            </div>
                            <div class=\"icon\">
                                <i class=\"ion ion-stats-bars\"></i>
                            </div>
                            <a href=\"#\" class=\"small-box-footer\">More info <i class=\"fas fa-arrow-circle-right\"></i></a>
                        </div>
                    </div>

                    <div class=\"col-lg-3 col-6\">

                        <div class=\"small-box bg-warning\">
                            <div class=\"inner\">
                                <h3>44</h3>
                                <p>User Registrations</p>
                            </div>
                            <div class=\"icon\">
                                <i class=\"ion ion-person-add\"></i>
                            </div>
                            <a href=\"#\" class=\"small-box-footer\">More info <i class=\"fas fa-arrow-circle-right\"></i></a>
                        </div>
                    </div>

                    <div class=\"col-lg-3 col-6\">

                        <div class=\"small-box bg-danger\">
                            <div class=\"inner\">
                                <h3>65</h3>
                                <p>Unique Visitors</p>
                            </div>
                            <div class=\"icon\">
                                <i class=\"ion ion-pie-graph\"></i>
                            </div>
                            <a href=\"#\" class=\"small-box-footer\">More info <i class=\"fas fa-arrow-circle-right\"></i></a>
                        </div>
                    </div>

                </div>


            </div>


            ";
        // line 921
        $this->displayBlock('content', $context, $blocks);
        // line 924
        echo "

        </section>

    </div>

    <footer class=\"main-footer\" style=\"background-color: #dedede\">
        <strong>Copyright &copy; 2022-2023 <a href=#\">BASE ELEVES V2 </a>.</strong>
        - LC ";
        // line 932
        echo twig_escape_filter($this->env, twig_upper_filter($this->env, ($context["lastCommitHash2"] ?? null)), "html", null, true);
        echo "
        <div class=\"float-right d-none d-sm-inline-block\">
            <b>Version</b> 2.0.0 Build N° ";
        // line 934
        echo twig_escape_filter($this->env, twig_upper_filter($this->env, ($context["lastCommitHash"] ?? null)), "html", null, true);
        echo "
        </div>


    </footer>

    <aside class=\"control-sidebar control-sidebar-dark\">

    </aside>

</div>



<script src=\"../../../public/plugins/jquery-ui/jquery-ui.min.js\"></script>

<script>
    \$.widget.bridge('uibutton', \$.ui.button)
</script>

<script src=\"../../../public/plugins/bootstrap/js/bootstrap.bundle.min.js\"></script>

<script src=\"../../../public/plugins/chart.js/Chart.min.js\"></script>

<script src=\"../../../public/plugins/sparklines/sparkline.js\"></script>

<script src=\"../../../public/plugins/jqvmap/jquery.vmap.min.js\"></script>
<script src=\"../../../public/plugins/jqvmap/maps/jquery.vmap.usa.js\"></script>

<script src=\"../../../public/plugins/jquery-knob/jquery.knob.min.js\"></script>

<script src=\"../../../public/plugins/moment/moment.min.js\"></script>
<script src=\"../../../public/plugins/daterangepicker/daterangepicker.js\"></script>

<script src=\"../../../public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js\"></script>

<script src=\"../../../public/plugins/summernote/summernote-bs4.min.js\"></script>

<script src=\"../../../public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js\"></script>

<script src=\"../../../public/dist/js/adminlte.js?v=3.2.0\"></script>


<script src=\"../../../public/dist/js/pages/dashboard.js\"></script>

<script src=\"../../../public/dist/js/pages/scripts.js\"></script>

</body>
</html>




";
    }

    // line 921
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 922
        echo "
            ";
    }

    public function getTemplateName()
    {
        return "/base/base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1042 => 922,  1038 => 921,  980 => 934,  975 => 932,  965 => 924,  963 => 921,  233 => 194,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"iso-8859-1\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <title>BE-V2 | Dashboard</title>

    <link rel=\"stylesheet\" href=\"https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback\">

    <link rel=\"stylesheet\" href=\"../../../public/plugins/fontawesome-free/css/all.min.css\">

    <link rel=\"stylesheet\" href=\"https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css\">

    <link rel=\"stylesheet\" href=\"../../../public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css\">

    <link rel=\"stylesheet\" href=\"../../../public/plugins/icheck-bootstrap/icheck-bootstrap.min.css\">

    <link rel=\"stylesheet\" href=\"../../../public/plugins/jqvmap/jqvmap.min.css\">

    <link rel=\"stylesheet\" href=\"../../../public/dist/css/adminlte.min.css?v=3.2.0\">

    <link rel=\"stylesheet\" href=\"../../../public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css\">

    <link rel=\"stylesheet\" href=\"../../../public/plugins/daterangepicker/daterangepicker.css\">

    <link rel=\"stylesheet\" href=\"../../../public/plugins/summernote/summernote-bs4.min.css\">

    <link rel=\"stylesheet\" type=\"text/css\" href=\"//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css\"/>
    <link rel=\"icon\" type=\"image/png\" href=\"https://web.gi.grenoble-inp.fr/eleves/icons/favicon.ico\" />
    <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css\">

    <style>
        @font-face {
            font-family: 'Vertexio';
            font-style: normal;
            font-weight: 700;
            src: local('Vertexio'), url('https://fonts.cdnfonts.com/s/78809/Soria-Bold.woff') format('woff');
        }
    </style>

</head>
<body class=\"hold-transition sidebar-mini layout-fixed\">
<div class=\"wrapper\">

    <div class=\"preloader flex-column justify-content-center align-items-center\">
        <img class=\"animation__shake\" src=\"https://web.gi.grenoble-inp.fr/eleves/icons/favicon.ico\" alt=\"AdminLTELogo\" height=\"60\" width=\"60\">
    </div>

    <nav class=\"main-header navbar navbar-expand navbar-white navbar-light\">

        <ul class=\"navbar-nav\">
            <li class=\"nav-item\">
                <a class=\"nav-link\" data-widget=\"pushmenu\" href=\"#\" role=\"button\"><i class=\"fas fa-bars\"></i></a>
            </li>
            <li class=\"nav-item d-none d-sm-inline-block\">
                <a href=\"index3.html\" class=\"nav-link\">Home</a>
            </li>
            <li class=\"nav-item d-none d-sm-inline-block\">
                <a href=\"#\" class=\"nav-link\">Contact</a>
            </li>
        </ul>

        <ul class=\"navbar-nav ml-auto\">

            <li class=\"nav-item\">
                <a class=\"nav-link\" data-widget=\"navbar-search\" href=\"#\" role=\"button\">
                    <i class=\"fas fa-search\"></i>
                </a>
                <div class=\"navbar-search-block\">
                    <form class=\"form-inline\">
                        <div class=\"input-group input-group-sm\">
                            <input class=\"form-control form-control-navbar\" type=\"search\" placeholder=\"Search\" aria-label=\"Search\">
                            <div class=\"input-group-append\">
                                <button class=\"btn btn-navbar\" type=\"submit\">
                                    <i class=\"fas fa-search\"></i>
                                </button>
                                <button class=\"btn btn-navbar\" type=\"button\" data-widget=\"navbar-search\">
                                    <i class=\"fas fa-times\"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>

            <li class=\"nav-item dropdown\">
                <a class=\"nav-link\" data-toggle=\"dropdown\" href=\"#\">
                    <i class=\"far fa-comments\"></i>
                    <span class=\"badge badge-danger navbar-badge\">3</span>
                </a>
                <div class=\"dropdown-menu dropdown-menu-lg dropdown-menu-right\">
                    <a href=\"#\" class=\"dropdown-item\">

                        <div class=\"media\">
                            <img src=\"https://adminlte.io/themes/v3/dist/img/user1-128x128.jpg\" alt=\"User Avatar\" class=\"img-size-50 mr-3 img-circle\">
                            <div class=\"media-body\">
                                <h3 class=\"dropdown-item-title\">
                                    Brad Diesel
                                    <span class=\"float-right text-sm text-danger\"><i class=\"fas fa-star\"></i></span>
                                </h3>
                                <p class=\"text-sm\">Call me whenever you can...</p>
                                <p class=\"text-sm text-muted\"><i class=\"far fa-clock mr-1\"></i> 4 Hours Ago</p>
                            </div>
                        </div>

                    </a>
                    <div class=\"dropdown-divider\"></div>
                    <a href=\"#\" class=\"dropdown-item\">

                        <div class=\"media\">
                            <img src=\"https://adminlte.io/themes/v3/dist/img/user8-128x128.jpg\" alt=\"User Avatar\" class=\"img-size-50 img-circle mr-3\">
                            <div class=\"media-body\">
                                <h3 class=\"dropdown-item-title\">
                                    John Pierce
                                    <span class=\"float-right text-sm text-muted\"><i class=\"fas fa-star\"></i></span>
                                </h3>
                                <p class=\"text-sm\">I got your message bro</p>
                                <p class=\"text-sm text-muted\"><i class=\"far fa-clock mr-1\"></i> 4 Hours Ago</p>
                            </div>
                        </div>

                    </a>
                    <div class=\"dropdown-divider\"></div>
                    <a href=\"#\" class=\"dropdown-item\">

                        <div class=\"media\">
                            <img src=\"https://adminlte.io/themes/v3/dist/img/user3-128x128.jpg\" alt=\"User Avatar\" class=\"img-size-50 img-circle mr-3\">
                            <div class=\"media-body\">
                                <h3 class=\"dropdown-item-title\">
                                    Nora Silvester
                                    <span class=\"float-right text-sm text-warning\"><i class=\"fas fa-star\"></i></span>
                                </h3>
                                <p class=\"text-sm\">The subject goes here</p>
                                <p class=\"text-sm text-muted\"><i class=\"far fa-clock mr-1\"></i> 4 Hours Ago</p>
                            </div>
                        </div>

                    </a>
                    <div class=\"dropdown-divider\"></div>
                    <a href=\"#\" class=\"dropdown-item dropdown-footer\">See All Messages</a>
                </div>
            </li>

            <li class=\"nav-item dropdown\">
                <a class=\"nav-link\" data-toggle=\"dropdown\" href=\"#\">
                    <i class=\"far fa-bell\"></i>
                    <span class=\"badge badge-warning navbar-badge\">15</span>
                </a>
                <div class=\"dropdown-menu dropdown-menu-lg dropdown-menu-right\">
                    <span class=\"dropdown-item dropdown-header\">15 Notifications</span>
                    <div class=\"dropdown-divider\"></div>
                    <a href=\"#\" class=\"dropdown-item\">
                        <i class=\"fas fa-envelope mr-2\"></i> 4 new messages
                        <span class=\"float-right text-muted text-sm\">3 mins</span>
                    </a>
                    <div class=\"dropdown-divider\"></div>
                    <a href=\"#\" class=\"dropdown-item\">
                        <i class=\"fas fa-users mr-2\"></i> 8 friend requests
                        <span class=\"float-right text-muted text-sm\">12 hours</span>
                    </a>
                    <div class=\"dropdown-divider\"></div>
                    <a href=\"#\" class=\"dropdown-item\">
                        <i class=\"fas fa-file mr-2\"></i> 3 new reports
                        <span class=\"float-right text-muted text-sm\">2 days</span>
                    </a>
                    <div class=\"dropdown-divider\"></div>
                    <a href=\"#\" class=\"dropdown-item dropdown-footer\">See All Notifications</a>
                </div>
            </li>
            <li class=\"nav-item\">
                <a class=\"nav-link\" data-widget=\"fullscreen\" href=\"#\" role=\"button\">
                    <i class=\"fas fa-expand-arrows-alt\"></i>
                </a>
            </li>
            <li class=\"nav-item\">
                <a class=\"nav-link\" data-widget=\"control-sidebar\" data-controlsidebar-slide=\"true\" href=\"#\" role=\"button\">
                    <i class=\"fas fa-th-large\"></i>
                </a>
            </li>
        </ul>
    </nav>


    <aside class=\"main-sidebar sidebar-dark-primary elevation-4\">



        <div class=\"sidebar\">

            <div class=\"user-panel mt-3 pb-3 mb-3 d-flex\">

                <div class=\"info\">
                    <p style=\"color: #dc051e ; font-size: 30px ; text-align: center ; font-weight: bold ; font-family: Vertexio ; background-color: #055181 ; border-radius: 8px ; color: #ffc107\">BASE ELEVES </p>
                    <a href=\"#\" class=\"d-block\" style=\"color: #8f8888\">{{ emailConnecte }}</a>
                </div>
            </div>

            <div class=\"form-inline\">
                <div class=\"input-group\" data-widget=\"sidebar-search\">
                    <input class=\"form-control form-control-sidebar\" type=\"search\" placeholder=\"Search\" aria-label=\"Search\">
                    <div class=\"input-group-append\">
                        <button class=\"btn btn-sidebar\">
                            <i class=\"fas fa-search fa-fw\"></i>
                        </button>
                    </div>
                </div>
            </div>

            <nav class=\"mt-2\">
                <ul class=\"nav nav-pills nav-sidebar flex-column\" data-widget=\"treeview\" role=\"menu\" data-accordion=\"false\">

                    <li class=\"nav-item menu-open\">
                        <a href=\"#\" class=\"nav-link active\">
                            <i class=\"nav-icon fas fa-tachometer-alt\"></i>
                            <p>
                                Dashboard
                                <i class=\"right fas fa-angle-left\"></i>
                            </p>
                        </a>
                        <ul class=\"nav nav-treeview\">
                            <li class=\"nav-item\">
                                <a href=\"./index.html\" class=\"nav-link active\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Dashboard v1</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"./index2.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Dashboard v2</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"./index3.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Dashboard v3</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"pages/widgets.html\" class=\"nav-link\">
                            <i class=\"nav-icon fas fa-th\"></i>
                            <p>
                                Widgets
                                <span class=\"right badge badge-danger\">New</span>
                            </p>
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"#\" class=\"nav-link\">
                            <i class=\"nav-icon fas fa-copy\"></i>
                            <p>
                                Layout Options
                                <i class=\"fas fa-angle-left right\"></i>
                                <span class=\"badge badge-info right\">6</span>
                            </p>
                        </a>
                        <ul class=\"nav nav-treeview\">
                            <li class=\"nav-item\">
                                <a href=\"pages/layout/top-nav.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Top Navigation</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/layout/top-nav-sidebar.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Top Navigation + Sidebar</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/layout/boxed.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Boxed</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/layout/fixed-sidebar.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Fixed Sidebar</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/layout/fixed-sidebar-custom.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Fixed Sidebar <small>+ Custom Area</small></p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/layout/fixed-topnav.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Fixed Navbar</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/layout/fixed-footer.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Fixed Footer</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/layout/collapsed-sidebar.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Collapsed Sidebar</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"#\" class=\"nav-link\">
                            <i class=\"nav-icon fas fa-chart-pie\"></i>
                            <p>
                                Charts
                                <i class=\"right fas fa-angle-left\"></i>
                            </p>
                        </a>
                        <ul class=\"nav nav-treeview\">
                            <li class=\"nav-item\">
                                <a href=\"pages/charts/chartjs.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>ChartJS</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/charts/flot.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Flot</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/charts/inline.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Inline</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/charts/uplot.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>uPlot</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"#\" class=\"nav-link\">
                            <i class=\"nav-icon fas fa-tree\"></i>
                            <p>
                                UI Elements
                                <i class=\"fas fa-angle-left right\"></i>
                            </p>
                        </a>
                        <ul class=\"nav nav-treeview\">
                            <li class=\"nav-item\">
                                <a href=\"pages/UI/general.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>General</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/UI/icons.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Icons</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/UI/buttons.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Buttons</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/UI/sliders.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Sliders</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/UI/modals.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Modals & Alerts</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/UI/navbar.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Navbar & Tabs</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/UI/timeline.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Timeline</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/UI/ribbons.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Ribbons</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"#\" class=\"nav-link\">
                            <i class=\"nav-icon fas fa-edit\"></i>
                            <p>
                                Forms
                                <i class=\"fas fa-angle-left right\"></i>
                            </p>
                        </a>
                        <ul class=\"nav nav-treeview\">
                            <li class=\"nav-item\">
                                <a href=\"pages/forms/general.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>General Elements</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/forms/advanced.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Advanced Elements</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/forms/editors.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Editors</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/forms/validation.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Validation</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"#\" class=\"nav-link\">
                            <i class=\"nav-icon fas fa-table\"></i>
                            <p>
                                Tables
                                <i class=\"fas fa-angle-left right\"></i>
                            </p>
                        </a>
                        <ul class=\"nav nav-treeview\">
                            <li class=\"nav-item\">
                                <a href=\"pages/tables/simple.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Simple Tables</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/tables/data.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>DataTables</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/tables/jsgrid.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>jsGrid</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class=\"nav-header\">EXAMPLES</li>
                    <li class=\"nav-item\">
                        <a href=\"pages/calendar.html\" class=\"nav-link\">
                            <i class=\"nav-icon far fa-calendar-alt\"></i>
                            <p>
                                Calendar
                                <span class=\"badge badge-info right\">2</span>
                            </p>
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"pages/gallery.html\" class=\"nav-link\">
                            <i class=\"nav-icon far fa-image\"></i>
                            <p>
                                Gallery
                            </p>
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"pages/kanban.html\" class=\"nav-link\">
                            <i class=\"nav-icon fas fa-columns\"></i>
                            <p>
                                Kanban Board
                            </p>
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"#\" class=\"nav-link\">
                            <i class=\"nav-icon far fa-envelope\"></i>
                            <p>
                                Mailbox
                                <i class=\"fas fa-angle-left right\"></i>
                            </p>
                        </a>
                        <ul class=\"nav nav-treeview\">
                            <li class=\"nav-item\">
                                <a href=\"pages/mailbox/mailbox.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Inbox</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/mailbox/compose.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Compose</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/mailbox/read-mail.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Read</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"#\" class=\"nav-link\">
                            <i class=\"nav-icon fas fa-book\"></i>
                            <p>
                                Pages
                                <i class=\"fas fa-angle-left right\"></i>
                            </p>
                        </a>
                        <ul class=\"nav nav-treeview\">
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/invoice.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Invoice</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/profile.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Profile</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/e-commerce.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>E-commerce</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/projects.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Projects</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/project-add.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Project Add</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/project-edit.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Project Edit</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/project-detail.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Project Detail</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/contacts.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Contacts</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/faq.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>FAQ</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/contact-us.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Contact us</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"#\" class=\"nav-link\">
                            <i class=\"nav-icon far fa-plus-square\"></i>
                            <p>
                                Extras
                                <i class=\"fas fa-angle-left right\"></i>
                            </p>
                        </a>
                        <ul class=\"nav nav-treeview\">
                            <li class=\"nav-item\">
                                <a href=\"#\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>
                                        Login & Register v1
                                        <i class=\"fas fa-angle-left right\"></i>
                                    </p>
                                </a>
                                <ul class=\"nav nav-treeview\">
                                    <li class=\"nav-item\">
                                        <a href=\"pages/examples/login.html\" class=\"nav-link\">
                                            <i class=\"far fa-circle nav-icon\"></i>
                                            <p>Login v1</p>
                                        </a>
                                    </li>
                                    <li class=\"nav-item\">
                                        <a href=\"pages/examples/register.html\" class=\"nav-link\">
                                            <i class=\"far fa-circle nav-icon\"></i>
                                            <p>Register v1</p>
                                        </a>
                                    </li>
                                    <li class=\"nav-item\">
                                        <a href=\"pages/examples/forgot-password.html\" class=\"nav-link\">
                                            <i class=\"far fa-circle nav-icon\"></i>
                                            <p>Forgot Password v1</p>
                                        </a>
                                    </li>
                                    <li class=\"nav-item\">
                                        <a href=\"pages/examples/recover-password.html\" class=\"nav-link\">
                                            <i class=\"far fa-circle nav-icon\"></i>
                                            <p>Recover Password v1</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"#\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>
                                        Login & Register v2
                                        <i class=\"fas fa-angle-left right\"></i>
                                    </p>
                                </a>
                                <ul class=\"nav nav-treeview\">
                                    <li class=\"nav-item\">
                                        <a href=\"pages/examples/login-v2.html\" class=\"nav-link\">
                                            <i class=\"far fa-circle nav-icon\"></i>
                                            <p>Login v2</p>
                                        </a>
                                    </li>
                                    <li class=\"nav-item\">
                                        <a href=\"pages/examples/register-v2.html\" class=\"nav-link\">
                                            <i class=\"far fa-circle nav-icon\"></i>
                                            <p>Register v2</p>
                                        </a>
                                    </li>
                                    <li class=\"nav-item\">
                                        <a href=\"pages/examples/forgot-password-v2.html\" class=\"nav-link\">
                                            <i class=\"far fa-circle nav-icon\"></i>
                                            <p>Forgot Password v2</p>
                                        </a>
                                    </li>
                                    <li class=\"nav-item\">
                                        <a href=\"pages/examples/recover-password-v2.html\" class=\"nav-link\">
                                            <i class=\"far fa-circle nav-icon\"></i>
                                            <p>Recover Password v2</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/lockscreen.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Lockscreen</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/legacy-user-menu.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Legacy User Menu</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/language-menu.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Language Menu</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/404.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Error 404</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/500.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Error 500</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/pace.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Pace</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/examples/blank.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Blank Page</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"starter.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Starter Page</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"#\" class=\"nav-link\">
                            <i class=\"nav-icon fas fa-search\"></i>
                            <p>
                                Search
                                <i class=\"fas fa-angle-left right\"></i>
                            </p>
                        </a>
                        <ul class=\"nav nav-treeview\">
                            <li class=\"nav-item\">
                                <a href=\"pages/search/simple.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Simple Search</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"pages/search/enhanced.html\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Enhanced</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class=\"nav-header\">MISCELLANEOUS</li>
                    <li class=\"nav-item\">
                        <a href=\"iframe.html\" class=\"nav-link\">
                            <i class=\"nav-icon fas fa-ellipsis-h\"></i>
                            <p>Tabbed IFrame Plugin</p>
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"https://adminlte.io/docs/3.1/\" class=\"nav-link\">
                            <i class=\"nav-icon fas fa-file\"></i>
                            <p>Documentation</p>
                        </a>
                    </li>
                    <li class=\"nav-header\">MULTI LEVEL EXAMPLE</li>
                    <li class=\"nav-item\">
                        <a href=\"#\" class=\"nav-link\">
                            <i class=\"fas fa-circle nav-icon\"></i>
                            <p>Level 1</p>
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"#\" class=\"nav-link\">
                            <i class=\"nav-icon fas fa-circle\"></i>
                            <p>
                                Level 1
                                <i class=\"right fas fa-angle-left\"></i>
                            </p>
                        </a>
                        <ul class=\"nav nav-treeview\">
                            <li class=\"nav-item\">
                                <a href=\"#\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Level 2</p>
                                </a>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"#\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>
                                        Level 2
                                        <i class=\"right fas fa-angle-left\"></i>
                                    </p>
                                </a>
                                <ul class=\"nav nav-treeview\">
                                    <li class=\"nav-item\">
                                        <a href=\"#\" class=\"nav-link\">
                                            <i class=\"far fa-dot-circle nav-icon\"></i>
                                            <p>Level 3</p>
                                        </a>
                                    </li>
                                    <li class=\"nav-item\">
                                        <a href=\"#\" class=\"nav-link\">
                                            <i class=\"far fa-dot-circle nav-icon\"></i>
                                            <p>Level 3</p>
                                        </a>
                                    </li>
                                    <li class=\"nav-item\">
                                        <a href=\"#\" class=\"nav-link\">
                                            <i class=\"far fa-dot-circle nav-icon\"></i>
                                            <p>Level 3</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class=\"nav-item\">
                                <a href=\"#\" class=\"nav-link\">
                                    <i class=\"far fa-circle nav-icon\"></i>
                                    <p>Level 2</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"#\" class=\"nav-link\">
                            <i class=\"fas fa-circle nav-icon\"></i>
                            <p>Level 1</p>
                        </a>
                    </li>
                    <li class=\"nav-header\">LABELS</li>
                    <li class=\"nav-item\">
                        <a href=\"#\" class=\"nav-link\">
                            <i class=\"nav-icon far fa-circle text-danger\"></i>
                            <p class=\"text\">Important</p>
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"#\" class=\"nav-link\">
                            <i class=\"nav-icon far fa-circle text-warning\"></i>
                            <p>Warning</p>
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a href=\"#\" class=\"nav-link\">
                            <i class=\"nav-icon far fa-circle text-info\"></i>
                            <p>Informational</p>
                        </a>
                    </li>
                </ul>
            </nav>

        </div>

    </aside>

    <div class=\"content-wrapper\">




        <section class=\"content\">
            <div class=\"container-fluid\">

                <div class=\"row\">
                    <div class=\"col-lg-3 col-6\">

                        <div class=\"small-box bg-info\">
                            <div class=\"inner\">
                                <h3>150</h3>
                                <p>New Orders</p>
                            </div>
                            <div class=\"icon\">
                                <i class=\"ion ion-bag\"></i>
                            </div>
                            <a href=\"#\" class=\"small-box-footer\">More info <i class=\"fas fa-arrow-circle-right\"></i></a>
                        </div>
                    </div>

                    <div class=\"col-lg-3 col-6\">

                        <div class=\"small-box bg-success\">
                            <div class=\"inner\">
                                <h3>53<sup style=\"font-size: 20px\">%</sup></h3>
                                <p>Bounce Rate</p>
                            </div>
                            <div class=\"icon\">
                                <i class=\"ion ion-stats-bars\"></i>
                            </div>
                            <a href=\"#\" class=\"small-box-footer\">More info <i class=\"fas fa-arrow-circle-right\"></i></a>
                        </div>
                    </div>

                    <div class=\"col-lg-3 col-6\">

                        <div class=\"small-box bg-warning\">
                            <div class=\"inner\">
                                <h3>44</h3>
                                <p>User Registrations</p>
                            </div>
                            <div class=\"icon\">
                                <i class=\"ion ion-person-add\"></i>
                            </div>
                            <a href=\"#\" class=\"small-box-footer\">More info <i class=\"fas fa-arrow-circle-right\"></i></a>
                        </div>
                    </div>

                    <div class=\"col-lg-3 col-6\">

                        <div class=\"small-box bg-danger\">
                            <div class=\"inner\">
                                <h3>65</h3>
                                <p>Unique Visitors</p>
                            </div>
                            <div class=\"icon\">
                                <i class=\"ion ion-pie-graph\"></i>
                            </div>
                            <a href=\"#\" class=\"small-box-footer\">More info <i class=\"fas fa-arrow-circle-right\"></i></a>
                        </div>
                    </div>

                </div>


            </div>


            {% block content %}

            {% endblock %}


        </section>

    </div>

    <footer class=\"main-footer\" style=\"background-color: #dedede\">
        <strong>Copyright &copy; 2022-2023 <a href=#\">BASE ELEVES V2 </a>.</strong>
        - LC {{ lastCommitHash2 | upper  }}
        <div class=\"float-right d-none d-sm-inline-block\">
            <b>Version</b> 2.0.0 Build N° {{ lastCommitHash | upper  }}
        </div>


    </footer>

    <aside class=\"control-sidebar control-sidebar-dark\">

    </aside>

</div>



<script src=\"../../../public/plugins/jquery-ui/jquery-ui.min.js\"></script>

<script>
    \$.widget.bridge('uibutton', \$.ui.button)
</script>

<script src=\"../../../public/plugins/bootstrap/js/bootstrap.bundle.min.js\"></script>

<script src=\"../../../public/plugins/chart.js/Chart.min.js\"></script>

<script src=\"../../../public/plugins/sparklines/sparkline.js\"></script>

<script src=\"../../../public/plugins/jqvmap/jquery.vmap.min.js\"></script>
<script src=\"../../../public/plugins/jqvmap/maps/jquery.vmap.usa.js\"></script>

<script src=\"../../../public/plugins/jquery-knob/jquery.knob.min.js\"></script>

<script src=\"../../../public/plugins/moment/moment.min.js\"></script>
<script src=\"../../../public/plugins/daterangepicker/daterangepicker.js\"></script>

<script src=\"../../../public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js\"></script>

<script src=\"../../../public/plugins/summernote/summernote-bs4.min.js\"></script>

<script src=\"../../../public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js\"></script>

<script src=\"../../../public/dist/js/adminlte.js?v=3.2.0\"></script>


<script src=\"../../../public/dist/js/pages/dashboard.js\"></script>

<script src=\"../../../public/dist/js/pages/scripts.js\"></script>

</body>
</html>




", "/base/base.html.twig", "/var/www/html/eleves/public/base/base.html.twig");
    }
}
