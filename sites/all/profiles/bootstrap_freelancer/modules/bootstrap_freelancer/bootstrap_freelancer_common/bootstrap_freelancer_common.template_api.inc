<?php
/**
 * @file
 * bootstrap_freelancer_common.template_api.inc
 */

/**
 * Implements hook_default_template().
 */
function bootstrap_freelancer_common_default_template() {
  $export = array();

  $template_type = new Template();
  $template_type->disabled = FALSE; /* Edit this to true to make a default template_type disabled initially */
  $template_type->api_version = 1;
  $template_type->name = 'about_section';
  $template_type->label = 'About Section';
  $template_type->description = '';
  $template_type->tags = array(
    0 => 'block-template',
    1 => 'page-template',
  );
  $template_type->renderer = 'mustache';
  $template_type->owner_type = 'role';
  $template_type->owner = '3';
  $template_type->inputs = array(
    'about' => array(
      'label' => 'About Title',
      'type' => 'string',
      'description' => '',
      'required' => 0,
      'remove' => 0,
      'weight' => '10',
      'depth' => '0',
      'parent' => '',
      'field_id' => 'about',
    ),
    'column_first' => array(
      'label' => 'Column first text',
      'type' => 'text',
      'description' => '',
      'required' => 0,
      'remove' => 0,
      'weight' => '20',
      'depth' => '0',
      'parent' => '',
      'field_id' => 'column_first',
    ),
    'column_second' => array(
      'label' => 'Column second text',
      'type' => 'text',
      'description' => '',
      'required' => 0,
      'remove' => 0,
      'weight' => '30',
      'depth' => '0',
      'parent' => '',
      'field_id' => 'column_second',
    ),
    'download_theme' => array(
      'label' => 'Download Theme text',
      'type' => 'text',
      'description' => '',
      'required' => 0,
      'remove' => 0,
      'weight' => '40',
      'depth' => '0',
      'parent' => '',
      'field_id' => 'download_theme',
    ),
    'download_theme_url' => array(
      'key' => 'download_theme_url',
      'label' => 'Download Theme URL',
      'type' => 'url',
      'description' => '',
      'required' => 0,
      'weight' => '50',
      'depth' => '0',
      'parent' => '',
    ),
  );
  $template_type->content = '    <!-- About Section -->
    <section class="success" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>{{about}}</h2>
                    <hr class="star-light">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-lg-offset-2">
                    <p>{{column_first}}</p>
                </div>
                <div class="col-lg-4">
                    <p>{{column_second}}</p>
                </div>
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <a href="{{download_theme_url}}" class="btn btn-lg btn-outline">
                        <i class="fa fa-download"></i> {{download_theme}}
                    </a>
                </div>
            </div>
        </div>
    </section>';
  $template_type->attached = array(
    'js' => '',
    'css' => '',
    'libraries' => array(),
  );
  $export['about_section'] = $template_type;

  $template_type = new Template();
  $template_type->disabled = FALSE; /* Edit this to true to make a default template_type disabled initially */
  $template_type->api_version = 1;
  $template_type->name = 'footer';
  $template_type->label = 'Footer';
  $template_type->description = '';
  $template_type->tags = array(
    0 => 'block-template',
  );
  $template_type->renderer = 'mustache';
  $template_type->owner_type = 'role';
  $template_type->owner = '3';
  $template_type->inputs = array(
    'copyright' => array(
      'label' => 'Copyright Text',
      'type' => 'string',
      'description' => '',
      'required' => 0,
      'remove' => 0,
      'weight' => '1',
      'depth' => '0',
      'parent' => '',
      'field_id' => 'copyright',
    ),
    'copyright_label' => array(
      'label' => 'Copyright Label',
      'type' => 'string',
      'description' => '',
      'required' => 0,
      'remove' => 0,
      'weight' => '3',
      'depth' => '0',
      'parent' => '',
      'field_id' => 'copyright_label',
    ),
    'about_heading' => array(
      'label' => 'About block heading',
      'type' => 'string',
      'description' => '',
      'required' => 0,
      'remove' => 0,
      'weight' => '5',
      'depth' => '0',
      'parent' => '',
      'field_id' => 'about_heading',
    ),
    'about_text' => array(
      'label' => 'About block text',
      'type' => 'text_format',
      'description' => '',
      'required' => 0,
      'remove' => 0,
      'weight' => '7',
      'depth' => '0',
      'parent' => '',
      'field_id' => 'about_text',
    ),
    'location_heading' => array(
      'label' => 'Location block heading',
      'type' => 'string',
      'description' => '',
      'required' => 0,
      'remove' => 0,
      'weight' => '9',
      'depth' => '0',
      'parent' => '',
      'field_id' => 'location_heading',
    ),
    'location_text' => array(
      'label' => 'Location block text',
      'type' => 'text_format',
      'description' => '',
      'required' => 0,
      'remove' => 0,
      'weight' => '11',
      'depth' => '0',
      'parent' => '',
      'field_id' => 'location_text',
    ),
    'linkedin_link' => array(
      'label' => 'Linkedin link',
      'type' => 'url',
      'description' => '',
      'required' => 0,
      'remove' => 0,
      'weight' => '13',
      'depth' => '0',
      'parent' => '',
      'field_id' => 'linkedin_link',
    ),
    'twitter_link' => array(
      'label' => 'Twitter link',
      'type' => 'url',
      'description' => '',
      'required' => 0,
      'remove' => 0,
      'weight' => '15',
      'depth' => '0',
      'parent' => '',
      'field_id' => 'twitter_link',
    ),
    'facebook_link' => array(
      'label' => 'Facebook link',
      'type' => 'url',
      'description' => '',
      'required' => 0,
      'remove' => 0,
      'weight' => '17',
      'depth' => '0',
      'parent' => '',
      'field_id' => 'facebook_link',
    ),
    'google_plus_link' => array(
      'label' => 'Google plus link',
      'type' => 'url',
      'description' => '',
      'required' => 0,
      'remove' => 0,
      'weight' => '19',
      'depth' => '0',
      'parent' => '',
      'field_id' => 'google_plus_link',
    ),
    'dribbble_link' => array(
      'label' => 'Dribbble link',
      'type' => 'url',
      'description' => '',
      'required' => 0,
      'remove' => 0,
      'weight' => '21',
      'depth' => '0',
      'parent' => '',
      'field_id' => 'dribbble_link',
    ),
    'share_heading' => array(
      'label' => 'Share heading',
      'type' => 'string',
      'description' => '',
      'required' => 0,
      'remove' => 0,
      'weight' => '31',
      'depth' => '0',
      'parent' => '',
      'field_id' => 'share_heading',
    ),
  );
  $template_type->content = '    <!-- Footer -->
    <footer class="text-center">
        <div class="footer-above">
            <div class="container">
                <div class="row">
                    <div class="footer-col col-md-4">
                        <h3>{{location_heading}}</h3>
                        <p>{{{location_text}}}</p>
                    </div>
                    <div class="footer-col col-md-4">
                        <h3>{{share_heading}}</h3>
                        <ul class="list-inline">
														{{#facebook_link}}
                            <li>
                                <a href="{{facebook_link}}" class="btn-social btn-outline"><i class="fa fa-fw fa-facebook"></i></a>
                            </li>
														{{/facebook_link}}
														{{#google_plus_link}}
                            <li>
                                <a href="{{google_plus_link}}" class="btn-social btn-outline"><i class="fa fa-fw fa-google-plus"></i></a>
                            </li>
														{{/google_plus_link}}
														{{#twitter_link}}
                            <li>
                                <a href="{{twitter_link}}" class="btn-social btn-outline"><i class="fa fa-fw fa-twitter"></i></a>
                            </li>
													 {{/twitter_link}}
                           {{#linkedin_link}}
                            <li>
                                <a href="{{linkedin_link}}" class="btn-social btn-outline"><i class="fa fa-fw fa-linkedin"></i></a>
                            </li>
                           {{/linkedin_link}}
													 {{#dribbble_link}}
                            <li>
                                <a href="{{dribbble_link}}" class="btn-social btn-outline"><i class="fa fa-fw fa-dribbble"></i></a>
                            </li>
														{{/dribbble_link}}
                        </ul>
                    </div>
                    <div class="footer-col col-md-4">
                        <h3>{{about_heading}}</h3>
                        <p>{{{about_text}}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-below">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        {{copyright_label}} &copy; {{copyright}}
                    </div>
                </div>
            </div>
        </div>
    </footer>';
  $template_type->attached = array(
    'js' => '',
    'css' => '',
    'libraries' => array(),
  );
  $export['footer'] = $template_type;

  $template_type = new Template();
  $template_type->disabled = FALSE; /* Edit this to true to make a default template_type disabled initially */
  $template_type->api_version = 1;
  $template_type->name = 'header';
  $template_type->label = 'Header';
  $template_type->description = '';
  $template_type->tags = array(
    0 => 'block-template',
  );
  $template_type->renderer = 'mustache';
  $template_type->owner_type = 'role';
  $template_type->owner = '3';
  $template_type->inputs = array(
    'name' => array(
      'label' => 'Name',
      'type' => 'string',
      'description' => '',
      'required' => 0,
      'remove' => 0,
      'weight' => '10',
      'depth' => '0',
      'parent' => '',
      'field_id' => 'name',
    ),
    'intro_skills' => array(
      'label' => 'Skills',
      'type' => 'string',
      'description' => '',
      'required' => 0,
      'remove' => 0,
      'weight' => '20',
      'depth' => '0',
      'parent' => '',
      'field_id' => 'intro_skills',
    ),
    'profile_image' => array(
      'label' => 'Profile image',
      'type' => 'file',
      'description' => '',
      'required' => 0,
      'remove' => 0,
      'weight' => '30',
      'depth' => '0',
      'parent' => '',
      'field_id' => 'profile_image',
    ),
  );
  $template_type->content = '    <!-- Header -->
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <img class="img-responsive" src="{{profile_image}}" alt="">
                    <div class="intro-text">
                        <span class="name">{{name}}</span>
                        <hr class="star-light">
                        <span class="skills">{{intro_skills}}</span>
                    </div>
                </div>
            </div>
        </div>
    </header>';
  $template_type->attached = array(
    'js' => '',
    'css' => '',
    'libraries' => array(),
  );
  $export['header'] = $template_type;

  $template_type = new Template();
  $template_type->disabled = FALSE; /* Edit this to true to make a default template_type disabled initially */
  $template_type->api_version = 1;
  $template_type->name = 'navigation';
  $template_type->label = 'Navigation';
  $template_type->description = '';
  $template_type->tags = array(
    0 => 'block-template',
  );
  $template_type->renderer = 'mustache';
  $template_type->owner_type = 'role';
  $template_type->owner = '3';
  $template_type->inputs = array(
    'site_name' => array(
      'label' => 'Site Name',
      'type' => 'string',
      'description' => '',
      'required' => 0,
      'remove' => 0,
      'weight' => '10',
      'depth' => '0',
      'parent' => '',
      'field_id' => 'site_name',
    ),
  );
  $template_type->content = '<!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#page-top">{{site_name}}</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>';
  $template_type->attached = array(
    'js' => '',
    'css' => '',
    'libraries' => array(),
  );
  $export['navigation'] = $template_type;

  $template_type = new Template();
  $template_type->disabled = FALSE; /* Edit this to true to make a default template_type disabled initially */
  $template_type->api_version = 1;
  $template_type->name = 'navigation_home';
  $template_type->label = 'Navigation Home';
  $template_type->description = '';
  $template_type->tags = array(
    0 => 'block-template',
  );
  $template_type->renderer = 'mustache';
  $template_type->owner_type = 'role';
  $template_type->owner = '3';
  $template_type->inputs = array(
    'site_name' => array(
      'label' => 'Site Name',
      'type' => 'string',
      'description' => '',
      'required' => 0,
      'remove' => 0,
      'weight' => '10',
      'depth' => '0',
      'parent' => '',
      'field_id' => 'site_name',
    ),
    'portfolio' => array(
      'label' => 'Portfolio menu text',
      'type' => 'string',
      'description' => '',
      'required' => 0,
      'remove' => 0,
      'weight' => '20',
      'depth' => '0',
      'parent' => '',
      'field_id' => 'portfolio',
    ),
    'about' => array(
      'label' => 'About menu text',
      'type' => 'string',
      'description' => '',
      'required' => 0,
      'remove' => 0,
      'weight' => '30',
      'depth' => '0',
      'parent' => '',
      'field_id' => 'about',
    ),
    'contact' => array(
      'label' => 'Contact menu text',
      'type' => 'string',
      'description' => '',
      'required' => 0,
      'remove' => 0,
      'weight' => '40',
      'depth' => '0',
      'parent' => '',
      'field_id' => 'contact',
    ),
  );
  $template_type->content = '<!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#page-top">{{site_name}}</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li class="page-scroll">
                        <a href="#portfolio">{{portfolio}}</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#about">{{about}}</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#contact">{{contact}}</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>';
  $template_type->attached = array(
    'js' => '',
    'css' => '',
    'libraries' => array(),
  );
  $export['navigation_home'] = $template_type;

  $template_type = new Template();
  $template_type->disabled = FALSE; /* Edit this to true to make a default template_type disabled initially */
  $template_type->api_version = 1;
  $template_type->name = 'portfolio_grid_section';
  $template_type->label = 'Portfolio Grid Section';
  $template_type->description = '';
  $template_type->tags = array(
    0 => 'block-template',
    1 => 'page-template',
  );
  $template_type->renderer = 'mustache';
  $template_type->owner_type = 'role';
  $template_type->owner = '3';
  $template_type->inputs = array(
    'title' => array(
      'label' => 'Title',
      'type' => 'string',
      'description' => '',
      'required' => 0,
      'remove' => 0,
      'weight' => '1',
      'depth' => '0',
      'parent' => '',
      'field_id' => 'title',
    ),
    'portfolio_image1' => array(
      'label' => 'Portfolio Image 1',
      'type' => 'file',
      'description' => '',
      'required' => 0,
      'remove' => 0,
      'weight' => '3',
      'depth' => '0',
      'parent' => '',
      'field_id' => 'portfolio_image1',
    ),
    'portfolio_image2' => array(
      'label' => 'Portfolio Image 2',
      'type' => 'file',
      'description' => '',
      'required' => 0,
      'remove' => 0,
      'weight' => '5',
      'depth' => '0',
      'parent' => '',
      'field_id' => 'portfolio_image2',
    ),
    'portfolio_image3' => array(
      'label' => 'Portfolio Image 3',
      'type' => 'file',
      'description' => '',
      'required' => 0,
      'remove' => 0,
      'weight' => '7',
      'depth' => '0',
      'parent' => '',
      'field_id' => 'portfolio_image3',
    ),
    'portfolio_image4' => array(
      'label' => 'Portfolio Image 4',
      'type' => 'file',
      'description' => '',
      'required' => 0,
      'remove' => 0,
      'weight' => '9',
      'depth' => '0',
      'parent' => '',
      'field_id' => 'portfolio_image4',
    ),
    'portfolio_image5' => array(
      'label' => 'Portfolio Image 5',
      'type' => 'file',
      'description' => '',
      'required' => 0,
      'remove' => 0,
      'weight' => '11',
      'depth' => '0',
      'parent' => '',
      'field_id' => 'portfolio_image5',
    ),
    'portfolio_image6' => array(
      'key' => 'portfolio_image6',
      'label' => 'Portfolio Image 6',
      'type' => 'file',
      'description' => '',
      'required' => 0,
      'weight' => '13',
      'depth' => '0',
      'parent' => '',
    ),
  );
  $template_type->content = ' <!-- Portfolio Grid Section -->
    <section id="portfolio">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>{{title}}</h2>
                    <hr class="star-primary">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 portfolio-item">
                    <a href="#portfolioModal1" class="portfolio-link" data-toggle="modal">
                        <div class="caption">
                            <div class="caption-content">
                                <i class="fa fa-search-plus fa-3x"></i>
                            </div>
                        </div>
                        <img src="{{portfolio_image1}}" class="img-responsive" alt="">
                    </a>
                </div>
                <div class="col-sm-4 portfolio-item">
                    <a href="#portfolioModal2" class="portfolio-link" data-toggle="modal">
                        <div class="caption">
                            <div class="caption-content">
                                <i class="fa fa-search-plus fa-3x"></i>
                            </div>
                        </div>
                        <img src="{{portfolio_image2}}" class="img-responsive" alt="">
                    </a>
                </div>
                <div class="col-sm-4 portfolio-item">
                    <a href="#portfolioModal3" class="portfolio-link" data-toggle="modal">
                        <div class="caption">
                            <div class="caption-content">
                                <i class="fa fa-search-plus fa-3x"></i>
                            </div>
                        </div>
                        <img src="{{portfolio_image3}}" class="img-responsive" alt="">
                    </a>
                </div>
                <div class="col-sm-4 portfolio-item">
                    <a href="#portfolioModal4" class="portfolio-link" data-toggle="modal">
                        <div class="caption">
                            <div class="caption-content">
                                <i class="fa fa-search-plus fa-3x"></i>
                            </div>
                        </div>
                        <img src="{{portfolio_image4}}" class="img-responsive" alt="">
                    </a>
                </div>
                <div class="col-sm-4 portfolio-item">
                    <a href="#portfolioModal5" class="portfolio-link" data-toggle="modal">
                        <div class="caption">
                            <div class="caption-content">
                                <i class="fa fa-search-plus fa-3x"></i>
                            </div>
                        </div>
                        <img src="{{portfolio_image5}}" class="img-responsive" alt="">
                    </a>
                </div>
                <div class="col-sm-4 portfolio-item">
                    <a href="#portfolioModal6" class="portfolio-link" data-toggle="modal">
                        <div class="caption">
                            <div class="caption-content">
                                <i class="fa fa-search-plus fa-3x"></i>
                            </div>
                        </div>
                        <img src="{{portfolio_image6}}" class="img-responsive" alt="">
                    </a>
                </div>
            </div>
        </div>
    </section>

<!-- Portfolio Modals -->
    <div class="portfolio-modal modal fade" id="portfolioModal1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="modal-body">
                            <h2>Project Title</h2>
                            <hr class="star-primary">
                            <img src="{{portfolio_image1}}" class="img-responsive img-centered" alt="">
                            <p>Use this area of the page to describe your project. The icon above is part of a free icon set by <a href="https://sellfy.com/p/8Q9P/jV3VZ/">Flat Icons</a>. On their website, you can download their free set with 16 icons, or you can purchase the entire set with 146 icons for only $12!</p>
                            <ul class="list-inline item-details">
                                <li>Client:
                                    <strong><a href="http://startbootstrap.com">Start Bootstrap</a>
                                    </strong>
                                </li>
                                <li>Date:
                                    <strong><a href="http://startbootstrap.com">April 2014</a>
                                    </strong>
                                </li>
                                <li>Service:
                                    <strong><a href="http://startbootstrap.com">Web Development</a>
                                    </strong>
                                </li>
                            </ul>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="portfolio-modal modal fade" id="portfolioModal2" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="modal-body">
                            <h2>Project Title</h2>
                            <hr class="star-primary">
                            <img src="{{portfolio_image2}}" class="img-responsive img-centered" alt="">
                            <p>Use this area of the page to describe your project. The icon above is part of a free icon set by <a href="https://sellfy.com/p/8Q9P/jV3VZ/">Flat Icons</a>. On their website, you can download their free set with 16 icons, or you can purchase the entire set with 146 icons for only $12!</p>
                            <ul class="list-inline item-details">
                                <li>Client:
                                    <strong><a href="http://startbootstrap.com">Start Bootstrap</a>
                                    </strong>
                                </li>
                                <li>Date:
                                    <strong><a href="http://startbootstrap.com">April 2014</a>
                                    </strong>
                                </li>
                                <li>Service:
                                    <strong><a href="http://startbootstrap.com">Web Development</a>
                                    </strong>
                                </li>
                            </ul>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="portfolio-modal modal fade" id="portfolioModal3" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="modal-body">
                            <h2>Project Title</h2>
                            <hr class="star-primary">
                            <img src="{{portfolio_image3}}" class="img-responsive img-centered" alt="">
                            <p>Use this area of the page to describe your project. The icon above is part of a free icon set by <a href="https://sellfy.com/p/8Q9P/jV3VZ/">Flat Icons</a>. On their website, you can download their free set with 16 icons, or you can purchase the entire set with 146 icons for only $12!</p>
                            <ul class="list-inline item-details">
                                <li>Client:
                                    <strong><a href="http://startbootstrap.com">Start Bootstrap</a>
                                    </strong>
                                </li>
                                <li>Date:
                                    <strong><a href="http://startbootstrap.com">April 2014</a>
                                    </strong>
                                </li>
                                <li>Service:
                                    <strong><a href="http://startbootstrap.com">Web Development</a>
                                    </strong>
                                </li>
                            </ul>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="portfolio-modal modal fade" id="portfolioModal4" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="modal-body">
                            <h2>Project Title</h2>
                            <hr class="star-primary">
                            <img src="{{portfolio_image4}}" class="img-responsive img-centered" alt="">
                            <p>Use this area of the page to describe your project. The icon above is part of a free icon set by <a href="https://sellfy.com/p/8Q9P/jV3VZ/">Flat Icons</a>. On their website, you can download their free set with 16 icons, or you can purchase the entire set with 146 icons for only $12!</p>
                            <ul class="list-inline item-details">
                                <li>Client:
                                    <strong><a href="http://startbootstrap.com">Start Bootstrap</a>
                                    </strong>
                                </li>
                                <li>Date:
                                    <strong><a href="http://startbootstrap.com">April 2014</a>
                                    </strong>
                                </li>
                                <li>Service:
                                    <strong><a href="http://startbootstrap.com">Web Development</a>
                                    </strong>
                                </li>
                            </ul>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="portfolio-modal modal fade" id="portfolioModal5" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="modal-body">
                            <h2>Project Title</h2>
                            <hr class="star-primary">
                            <img src="{{portfolio_image5}}" class="img-responsive img-centered" alt="">
                            <p>Use this area of the page to describe your project. The icon above is part of a free icon set by <a href="https://sellfy.com/p/8Q9P/jV3VZ/">Flat Icons</a>. On their website, you can download their free set with 16 icons, or you can purchase the entire set with 146 icons for only $12!</p>
                            <ul class="list-inline item-details">
                                <li>Client:
                                    <strong><a href="http://startbootstrap.com">Start Bootstrap</a>
                                    </strong>
                                </li>
                                <li>Date:
                                    <strong><a href="http://startbootstrap.com">April 2014</a>
                                    </strong>
                                </li>
                                <li>Service:
                                    <strong><a href="http://startbootstrap.com">Web Development</a>
                                    </strong>
                                </li>
                            </ul>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="portfolio-modal modal fade" id="portfolioModal6" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="modal-body">
                            <h2>Project Title</h2>
                            <hr class="star-primary">
                            <img src="{{portfolio_image6}}" class="img-responsive img-centered" alt="">
                            <p>Use this area of the page to describe your project. The icon above is part of a free icon set by <a href="https://sellfy.com/p/8Q9P/jV3VZ/">Flat Icons</a>. On their website, you can download their free set with 16 icons, or you can purchase the entire set with 146 icons for only $12!</p>
                            <ul class="list-inline item-details">
                                <li>Client:
                                    <strong><a href="http://startbootstrap.com">Start Bootstrap</a>
                                    </strong>
                                </li>
                                <li>Date:
                                    <strong><a href="http://startbootstrap.com">April 2014</a>
                                    </strong>
                                </li>
                                <li>Service:
                                    <strong><a href="http://startbootstrap.com">Web Development</a>
                                    </strong>
                                </li>
                            </ul>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>';
  $template_type->attached = array(
    'js' => '',
    'css' => '',
    'libraries' => array(),
  );
  $export['portfolio_grid_section'] = $template_type;

  return $export;
}
