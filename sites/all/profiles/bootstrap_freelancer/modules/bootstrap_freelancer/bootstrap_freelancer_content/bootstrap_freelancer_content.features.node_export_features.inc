<?php
/**
 * @file
 * bootstrap_freelancer_content.features.node_export_features.inc
 */

/**
 * Implements hook_node_export_features_default().
 */
function bootstrap_freelancer_content_node_export_features_default() {
  $node_export = array(
  'code_string' => 'array(
  (object) array(
      \'vid\' => \'1\',
      \'uid\' => \'1\',
      \'title\' => \'Header\',
      \'log\' => \'\',
      \'status\' => \'1\',
      \'comment\' => \'1\',
      \'promote\' => \'0\',
      \'sticky\' => \'0\',
      \'vuuid\' => \'0348515e-080f-48d0-a86c-c6f5bf84314e\',
      \'nid\' => \'1\',
      \'type\' => \'block\',
      \'language\' => \'und\',
      \'created\' => \'1425402094\',
      \'changed\' => \'1425401087\',
      \'tnid\' => \'0\',
      \'translate\' => \'0\',
      \'uuid\' => \'36f867fd-da5c-4096-89fe-87dec291be34\',
      \'revision_timestamp\' => \'1425401087\',
      \'revision_uid\' => \'1\',
      \'body\' => array(),
      \'field_field_template\' => array(
        \'und\' => array(
          array(
            \'template_name\' => \'header\',
            \'data\' => \'a:3:{s:4:"name";a:1:{s:9:"textfield";s:15:"Start Bootstrap";}s:12:"intro_skills";a:1:{s:9:"textfield";s:57:"Web Developer - Graphic Artist - User Experience Designer";}s:13:"profile_image";a:1:{s:8:"file_fid";a:4:{s:3:"fid";s:1:"1";s:13:"upload_button";s:6:"Upload";s:13:"remove_button";s:6:"Remove";s:6:"upload";s:0:"";}}}\',
          ),
        ),
      ),
      \'rdf_mapping\' => array(
        \'rdftype\' => array(
          \'sioc:Item\',
          \'foaf:Document\',
        ),
        \'title\' => array(
          \'predicates\' => array(
            \'dc:title\',
          ),
        ),
        \'created\' => array(
          \'predicates\' => array(
            \'dc:date\',
            \'dc:created\',
          ),
          \'datatype\' => \'xsd:dateTime\',
          \'callback\' => \'date_iso8601\',
        ),
        \'changed\' => array(
          \'predicates\' => array(
            \'dc:modified\',
          ),
          \'datatype\' => \'xsd:dateTime\',
          \'callback\' => \'date_iso8601\',
        ),
        \'body\' => array(
          \'predicates\' => array(
            \'content:encoded\',
          ),
        ),
        \'uid\' => array(
          \'predicates\' => array(
            \'sioc:has_creator\',
          ),
          \'type\' => \'rel\',
        ),
        \'name\' => array(
          \'predicates\' => array(
            \'foaf:name\',
          ),
        ),
        \'comment_count\' => array(
          \'predicates\' => array(
            \'sioc:num_replies\',
          ),
          \'datatype\' => \'xsd:integer\',
        ),
        \'last_activity\' => array(
          \'predicates\' => array(
            \'sioc:last_activity_date\',
          ),
          \'datatype\' => \'xsd:dateTime\',
          \'callback\' => \'date_iso8601\',
        ),
      ),
      \'cid\' => \'0\',
      \'last_comment_timestamp\' => \'1425402094\',
      \'last_comment_name\' => NULL,
      \'last_comment_uid\' => \'1\',
      \'comment_count\' => \'0\',
      \'nodeblock\' => array(
        \'nid\' => \'1\',
        \'enabled\' => \'1\',
        \'machine_name\' => \'header_block\',
        \'block_title\' => \'<none>\',
        \'view_mode\' => \'full\',
        \'node_link\' => \'0\',
        \'comment_link\' => \'0\',
        \'translation_fallback\' => \'0\',
      ),
      \'name\' => \'admin\',
      \'picture\' => \'0\',
      \'data\' => \'a:1:{s:7:"contact";i:1;}\',
      \'path\' => FALSE,
      \'menu\' => NULL,
      \'node_export_drupal_version\' => \'7\',
    ),
  (object) array(
      \'vid\' => \'2\',
      \'uid\' => \'1\',
      \'title\' => \'Home page navigation\',
      \'log\' => \'\',
      \'status\' => \'1\',
      \'comment\' => \'1\',
      \'promote\' => \'0\',
      \'sticky\' => \'0\',
      \'vuuid\' => \'b181b724-c533-49e4-b427-1ab8da1d288d\',
      \'nid\' => \'2\',
      \'type\' => \'block\',
      \'language\' => \'und\',
      \'created\' => \'1425402094\',
      \'changed\' => \'1425401150\',
      \'tnid\' => \'0\',
      \'translate\' => \'0\',
      \'uuid\' => \'4b341a96-2556-4ddf-ab84-5d9b4578532a\',
      \'revision_timestamp\' => \'1425401150\',
      \'revision_uid\' => \'1\',
      \'body\' => array(),
      \'field_field_template\' => array(
        \'und\' => array(
          array(
            \'template_name\' => \'navigation_home\',
            \'data\' => \'a:4:{s:9:"site_name";a:1:{s:9:"textfield";s:15:"Start Bootstrap";}s:9:"portfolio";a:1:{s:9:"textfield";s:9:"Portfolio";}s:5:"about";a:1:{s:9:"textfield";s:5:"About";}s:7:"contact";a:1:{s:9:"textfield";s:7:"Contact";}}\',
          ),
        ),
      ),
      \'rdf_mapping\' => array(
        \'rdftype\' => array(
          \'sioc:Item\',
          \'foaf:Document\',
        ),
        \'title\' => array(
          \'predicates\' => array(
            \'dc:title\',
          ),
        ),
        \'created\' => array(
          \'predicates\' => array(
            \'dc:date\',
            \'dc:created\',
          ),
          \'datatype\' => \'xsd:dateTime\',
          \'callback\' => \'date_iso8601\',
        ),
        \'changed\' => array(
          \'predicates\' => array(
            \'dc:modified\',
          ),
          \'datatype\' => \'xsd:dateTime\',
          \'callback\' => \'date_iso8601\',
        ),
        \'body\' => array(
          \'predicates\' => array(
            \'content:encoded\',
          ),
        ),
        \'uid\' => array(
          \'predicates\' => array(
            \'sioc:has_creator\',
          ),
          \'type\' => \'rel\',
        ),
        \'name\' => array(
          \'predicates\' => array(
            \'foaf:name\',
          ),
        ),
        \'comment_count\' => array(
          \'predicates\' => array(
            \'sioc:num_replies\',
          ),
          \'datatype\' => \'xsd:integer\',
        ),
        \'last_activity\' => array(
          \'predicates\' => array(
            \'sioc:last_activity_date\',
          ),
          \'datatype\' => \'xsd:dateTime\',
          \'callback\' => \'date_iso8601\',
        ),
      ),
      \'cid\' => \'0\',
      \'last_comment_timestamp\' => \'1425402094\',
      \'last_comment_name\' => NULL,
      \'last_comment_uid\' => \'1\',
      \'comment_count\' => \'0\',
      \'nodeblock\' => array(
        \'nid\' => \'2\',
        \'enabled\' => \'1\',
        \'machine_name\' => \'home_navigation\',
        \'block_title\' => \'<none>\',
        \'view_mode\' => \'full\',
        \'node_link\' => \'0\',
        \'comment_link\' => \'0\',
        \'translation_fallback\' => \'0\',
      ),
      \'name\' => \'admin\',
      \'picture\' => \'0\',
      \'data\' => \'a:1:{s:7:"contact";i:1;}\',
      \'path\' => FALSE,
      \'menu\' => NULL,
      \'node_export_drupal_version\' => \'7\',
    ),
  (object) array(
      \'vid\' => \'3\',
      \'uid\' => \'1\',
      \'title\' => \'About\',
      \'log\' => \'\',
      \'status\' => \'1\',
      \'comment\' => \'1\',
      \'promote\' => \'0\',
      \'sticky\' => \'0\',
      \'vuuid\' => \'48597c21-0e88-499a-994d-46d28eb644a4\',
      \'nid\' => \'3\',
      \'type\' => \'block\',
      \'language\' => \'und\',
      \'created\' => \'1425402094\',
      \'changed\' => \'1425402059\',
      \'tnid\' => \'0\',
      \'translate\' => \'0\',
      \'uuid\' => \'8039a2c0-f9c1-4111-bbb8-1c35149f201b\',
      \'revision_timestamp\' => \'1425402059\',
      \'revision_uid\' => \'1\',
      \'body\' => array(),
      \'field_field_template\' => array(
        \'und\' => array(
          array(
            \'template_name\' => \'about_section\',
            \'data\' => "a:5:{s:5:\\"about\\";a:1:{s:9:\\"textfield\\";s:5:\\"About\\";}s:12:\\"column_first\\";a:1:{s:8:\\"textarea\\";s:209:\\"Freelancer is a free bootstrap theme created by Start Bootstrap. The download includes the complete source files including HTML, CSS, and JavaScript as well as optional LESS stylesheets for easy customization.\\";}s:13:\\"column_second\\";a:1:{s:8:\\"textarea\\";s:195:\\"Whether you\'re a student looking to showcase your work, a professional looking to attract clients, or a graphic artist looking to share your projects, this template is the perfect starting point!\\";}s:14:\\"download_theme\\";a:1:{s:8:\\"textarea\\";s:14:\\"Download Theme\\";}s:18:\\"download_theme_url\\";a:2:{s:3:\\"url\\";s:51:\\"https://www.drupal.org/project/bootstrap_freelancer\\";s:7:\\"options\\";a:1:{s:8:\\"absolute\\";i:0;}}}",
          ),
        ),
      ),
      \'rdf_mapping\' => array(
        \'rdftype\' => array(
          \'sioc:Item\',
          \'foaf:Document\',
        ),
        \'title\' => array(
          \'predicates\' => array(
            \'dc:title\',
          ),
        ),
        \'created\' => array(
          \'predicates\' => array(
            \'dc:date\',
            \'dc:created\',
          ),
          \'datatype\' => \'xsd:dateTime\',
          \'callback\' => \'date_iso8601\',
        ),
        \'changed\' => array(
          \'predicates\' => array(
            \'dc:modified\',
          ),
          \'datatype\' => \'xsd:dateTime\',
          \'callback\' => \'date_iso8601\',
        ),
        \'body\' => array(
          \'predicates\' => array(
            \'content:encoded\',
          ),
        ),
        \'uid\' => array(
          \'predicates\' => array(
            \'sioc:has_creator\',
          ),
          \'type\' => \'rel\',
        ),
        \'name\' => array(
          \'predicates\' => array(
            \'foaf:name\',
          ),
        ),
        \'comment_count\' => array(
          \'predicates\' => array(
            \'sioc:num_replies\',
          ),
          \'datatype\' => \'xsd:integer\',
        ),
        \'last_activity\' => array(
          \'predicates\' => array(
            \'sioc:last_activity_date\',
          ),
          \'datatype\' => \'xsd:dateTime\',
          \'callback\' => \'date_iso8601\',
        ),
      ),
      \'cid\' => \'0\',
      \'last_comment_timestamp\' => \'1425402094\',
      \'last_comment_name\' => NULL,
      \'last_comment_uid\' => \'1\',
      \'comment_count\' => \'0\',
      \'nodeblock\' => array(
        \'nid\' => \'3\',
        \'enabled\' => \'1\',
        \'machine_name\' => \'about\',
        \'block_title\' => \'<none>\',
        \'view_mode\' => \'full\',
        \'node_link\' => \'0\',
        \'comment_link\' => \'0\',
        \'translation_fallback\' => \'0\',
      ),
      \'name\' => \'admin\',
      \'picture\' => \'0\',
      \'data\' => \'a:1:{s:7:"contact";i:1;}\',
      \'path\' => FALSE,
      \'menu\' => NULL,
      \'node_export_drupal_version\' => \'7\',
    ),
  (object) array(
      \'vid\' => \'4\',
      \'uid\' => \'1\',
      \'title\' => \'Footer\',
      \'log\' => \'\',
      \'status\' => \'1\',
      \'comment\' => \'1\',
      \'promote\' => \'0\',
      \'sticky\' => \'0\',
      \'vuuid\' => \'f1fff4d9-6df9-475c-bee3-984ca8ec989f\',
      \'nid\' => \'4\',
      \'type\' => \'block\',
      \'language\' => \'und\',
      \'created\' => \'1425402094\',
      \'changed\' => \'1425409709\',
      \'tnid\' => \'0\',
      \'translate\' => \'0\',
      \'uuid\' => \'895386a2-0013-4221-913e-07d48897f430\',
      \'revision_timestamp\' => \'1425409709\',
      \'revision_uid\' => \'1\',
      \'body\' => array(),
      \'field_field_template\' => array(
        \'und\' => array(
          array(
            \'template_name\' => \'footer\',
            \'data\' => \'a:12:{s:9:"copyright";a:1:{s:9:"textfield";s:17:"Your Website 2014";}s:15:"copyright_label";a:1:{s:9:"textfield";s:9:"Copyright";}s:13:"about_heading";a:1:{s:9:"textfield";s:16:"About Freelancer";}s:10:"about_text";a:1:{s:8:"textarea";a:2:{s:5:"value";s:125:"<p>Freelance is a free to use, open source Bootstrap theme created by <a href="http://startbootstrap.com">Start Bootstrap</a>";s:6:"format";s:9:"full_html";}}s:16:"location_heading";a:1:{s:9:"textfield";s:8:"Location";}s:13:"location_text";a:1:{s:8:"textarea";a:2:{s:5:"value";s:45:"3481 Melrose Place<br>Beverly Hills, CA 90210";s:6:"format";s:9:"full_html";}}s:13:"linkedin_link";a:2:{s:3:"url";s:24:"https://www.linkedin.com";s:7:"options";a:1:{s:8:"absolute";i:0;}}s:12:"twitter_link";a:2:{s:3:"url";s:20:"https://twitter.com/";s:7:"options";a:1:{s:8:"absolute";i:0;}}s:13:"facebook_link";a:2:{s:3:"url";s:21:"https://facebook.com/";s:7:"options";a:1:{s:8:"absolute";i:0;}}s:16:"google_plus_link";a:2:{s:3:"url";s:24:"https://plus.google.com/";s:7:"options";a:1:{s:8:"absolute";i:0;}}s:13:"dribbble_link";a:2:{s:3:"url";s:21:"https://dribbble.com/";s:7:"options";a:1:{s:8:"absolute";i:0;}}s:13:"share_heading";a:1:{s:9:"textfield";s:14:"Around the Web";}}\',
          ),
        ),
      ),
      \'rdf_mapping\' => array(
        \'rdftype\' => array(
          \'sioc:Item\',
          \'foaf:Document\',
        ),
        \'title\' => array(
          \'predicates\' => array(
            \'dc:title\',
          ),
        ),
        \'created\' => array(
          \'predicates\' => array(
            \'dc:date\',
            \'dc:created\',
          ),
          \'datatype\' => \'xsd:dateTime\',
          \'callback\' => \'date_iso8601\',
        ),
        \'changed\' => array(
          \'predicates\' => array(
            \'dc:modified\',
          ),
          \'datatype\' => \'xsd:dateTime\',
          \'callback\' => \'date_iso8601\',
        ),
        \'body\' => array(
          \'predicates\' => array(
            \'content:encoded\',
          ),
        ),
        \'uid\' => array(
          \'predicates\' => array(
            \'sioc:has_creator\',
          ),
          \'type\' => \'rel\',
        ),
        \'name\' => array(
          \'predicates\' => array(
            \'foaf:name\',
          ),
        ),
        \'comment_count\' => array(
          \'predicates\' => array(
            \'sioc:num_replies\',
          ),
          \'datatype\' => \'xsd:integer\',
        ),
        \'last_activity\' => array(
          \'predicates\' => array(
            \'sioc:last_activity_date\',
          ),
          \'datatype\' => \'xsd:dateTime\',
          \'callback\' => \'date_iso8601\',
        ),
      ),
      \'cid\' => \'0\',
      \'last_comment_timestamp\' => \'1425402094\',
      \'last_comment_name\' => NULL,
      \'last_comment_uid\' => \'1\',
      \'comment_count\' => \'0\',
      \'nodeblock\' => array(
        \'nid\' => \'4\',
        \'enabled\' => \'1\',
        \'machine_name\' => \'footer\',
        \'block_title\' => \'<none>\',
        \'view_mode\' => \'full\',
        \'node_link\' => \'0\',
        \'comment_link\' => \'0\',
        \'translation_fallback\' => \'0\',
      ),
      \'name\' => \'admin\',
      \'picture\' => \'0\',
      \'data\' => \'a:1:{s:7:"contact";i:1;}\',
      \'path\' => FALSE,
      \'menu\' => NULL,
      \'node_export_drupal_version\' => \'7\',
    ),
  (object) array(
      \'vid\' => \'5\',
      \'uid\' => \'1\',
      \'title\' => \'Navigation\',
      \'log\' => \'\',
      \'status\' => \'1\',
      \'comment\' => \'1\',
      \'promote\' => \'0\',
      \'sticky\' => \'0\',
      \'vuuid\' => \'7cd1502e-597c-4504-add8-bf1ebbef16e7\',
      \'nid\' => \'5\',
      \'type\' => \'block\',
      \'language\' => \'und\',
      \'created\' => \'1425402094\',
      \'changed\' => \'1425401320\',
      \'tnid\' => \'0\',
      \'translate\' => \'0\',
      \'uuid\' => \'b4df5c72-a69d-4b7d-8414-8959e05e3efc\',
      \'revision_timestamp\' => \'1425401320\',
      \'revision_uid\' => \'1\',
      \'body\' => array(),
      \'field_field_template\' => array(
        \'und\' => array(
          array(
            \'template_name\' => \'navigation\',
            \'data\' => \'a:1:{s:9:"site_name";a:1:{s:9:"textfield";s:15:"Start Bootstrap";}}\',
          ),
        ),
      ),
      \'rdf_mapping\' => array(
        \'rdftype\' => array(
          \'sioc:Item\',
          \'foaf:Document\',
        ),
        \'title\' => array(
          \'predicates\' => array(
            \'dc:title\',
          ),
        ),
        \'created\' => array(
          \'predicates\' => array(
            \'dc:date\',
            \'dc:created\',
          ),
          \'datatype\' => \'xsd:dateTime\',
          \'callback\' => \'date_iso8601\',
        ),
        \'changed\' => array(
          \'predicates\' => array(
            \'dc:modified\',
          ),
          \'datatype\' => \'xsd:dateTime\',
          \'callback\' => \'date_iso8601\',
        ),
        \'body\' => array(
          \'predicates\' => array(
            \'content:encoded\',
          ),
        ),
        \'uid\' => array(
          \'predicates\' => array(
            \'sioc:has_creator\',
          ),
          \'type\' => \'rel\',
        ),
        \'name\' => array(
          \'predicates\' => array(
            \'foaf:name\',
          ),
        ),
        \'comment_count\' => array(
          \'predicates\' => array(
            \'sioc:num_replies\',
          ),
          \'datatype\' => \'xsd:integer\',
        ),
        \'last_activity\' => array(
          \'predicates\' => array(
            \'sioc:last_activity_date\',
          ),
          \'datatype\' => \'xsd:dateTime\',
          \'callback\' => \'date_iso8601\',
        ),
      ),
      \'cid\' => \'0\',
      \'last_comment_timestamp\' => \'1425402094\',
      \'last_comment_name\' => NULL,
      \'last_comment_uid\' => \'1\',
      \'comment_count\' => \'0\',
      \'nodeblock\' => array(
        \'nid\' => \'5\',
        \'enabled\' => \'1\',
        \'machine_name\' => \'navigation\',
        \'block_title\' => \'<none>\',
        \'view_mode\' => \'full\',
        \'node_link\' => \'0\',
        \'comment_link\' => \'0\',
        \'translation_fallback\' => \'0\',
      ),
      \'name\' => \'admin\',
      \'picture\' => \'0\',
      \'data\' => \'a:1:{s:7:"contact";i:1;}\',
      \'path\' => FALSE,
      \'menu\' => NULL,
      \'node_export_drupal_version\' => \'7\',
    ),
  (object) array(
      \'vid\' => \'6\',
      \'uid\' => \'1\',
      \'title\' => \'Portfolio\',
      \'log\' => \'\',
      \'status\' => \'1\',
      \'comment\' => \'1\',
      \'promote\' => \'0\',
      \'sticky\' => \'0\',
      \'vuuid\' => \'2d27375e-f42a-446f-8214-0b59d392bce7\',
      \'nid\' => \'6\',
      \'type\' => \'block\',
      \'language\' => \'und\',
      \'created\' => \'1425402094\',
      \'changed\' => \'1425401375\',
      \'tnid\' => \'0\',
      \'translate\' => \'0\',
      \'uuid\' => \'e7b0911e-88b0-431c-a53d-c6a05b33a9d5\',
      \'revision_timestamp\' => \'1425401375\',
      \'revision_uid\' => \'1\',
      \'body\' => array(),
      \'field_field_template\' => array(
        \'und\' => array(
          array(
            \'template_name\' => \'portfolio_grid_section\',
            \'data\' => \'a:7:{s:5:"title";a:1:{s:9:"textfield";s:9:"Portfolio";}s:16:"portfolio_image1";a:1:{s:8:"file_fid";a:4:{s:3:"fid";s:1:"2";s:13:"upload_button";s:6:"Upload";s:13:"remove_button";s:6:"Remove";s:6:"upload";s:0:"";}}s:16:"portfolio_image2";a:1:{s:8:"file_fid";a:4:{s:3:"fid";s:1:"3";s:13:"upload_button";s:6:"Upload";s:13:"remove_button";s:6:"Remove";s:6:"upload";s:0:"";}}s:16:"portfolio_image3";a:1:{s:8:"file_fid";a:4:{s:3:"fid";s:1:"4";s:13:"upload_button";s:6:"Upload";s:13:"remove_button";s:6:"Remove";s:6:"upload";s:0:"";}}s:16:"portfolio_image4";a:1:{s:8:"file_fid";a:4:{s:3:"fid";s:1:"5";s:13:"upload_button";s:6:"Upload";s:13:"remove_button";s:6:"Remove";s:6:"upload";s:0:"";}}s:16:"portfolio_image5";a:1:{s:8:"file_fid";a:4:{s:3:"fid";s:1:"6";s:13:"upload_button";s:6:"Upload";s:13:"remove_button";s:6:"Remove";s:6:"upload";s:0:"";}}s:16:"portfolio_image6";a:1:{s:8:"file_fid";a:4:{s:3:"fid";s:1:"7";s:13:"upload_button";s:6:"Upload";s:13:"remove_button";s:6:"Remove";s:6:"upload";s:0:"";}}}\',
          ),
        ),
      ),
      \'rdf_mapping\' => array(
        \'rdftype\' => array(
          \'sioc:Item\',
          \'foaf:Document\',
        ),
        \'title\' => array(
          \'predicates\' => array(
            \'dc:title\',
          ),
        ),
        \'created\' => array(
          \'predicates\' => array(
            \'dc:date\',
            \'dc:created\',
          ),
          \'datatype\' => \'xsd:dateTime\',
          \'callback\' => \'date_iso8601\',
        ),
        \'changed\' => array(
          \'predicates\' => array(
            \'dc:modified\',
          ),
          \'datatype\' => \'xsd:dateTime\',
          \'callback\' => \'date_iso8601\',
        ),
        \'body\' => array(
          \'predicates\' => array(
            \'content:encoded\',
          ),
        ),
        \'uid\' => array(
          \'predicates\' => array(
            \'sioc:has_creator\',
          ),
          \'type\' => \'rel\',
        ),
        \'name\' => array(
          \'predicates\' => array(
            \'foaf:name\',
          ),
        ),
        \'comment_count\' => array(
          \'predicates\' => array(
            \'sioc:num_replies\',
          ),
          \'datatype\' => \'xsd:integer\',
        ),
        \'last_activity\' => array(
          \'predicates\' => array(
            \'sioc:last_activity_date\',
          ),
          \'datatype\' => \'xsd:dateTime\',
          \'callback\' => \'date_iso8601\',
        ),
      ),
      \'cid\' => \'0\',
      \'last_comment_timestamp\' => \'1425402094\',
      \'last_comment_name\' => NULL,
      \'last_comment_uid\' => \'1\',
      \'comment_count\' => \'0\',
      \'nodeblock\' => array(
        \'nid\' => \'6\',
        \'enabled\' => \'1\',
        \'machine_name\' => \'portfolio\',
        \'block_title\' => \'<none>\',
        \'view_mode\' => \'full\',
        \'node_link\' => \'0\',
        \'comment_link\' => \'0\',
        \'translation_fallback\' => \'0\',
      ),
      \'name\' => \'admin\',
      \'picture\' => \'0\',
      \'data\' => \'a:1:{s:7:"contact";i:1;}\',
      \'path\' => FALSE,
      \'menu\' => NULL,
      \'node_export_drupal_version\' => \'7\',
    ),
)',
);
  return $node_export;
}
