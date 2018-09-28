api = 2
core = 7.x

; Modules
projects[admin_menu][subdir] = "contrib"
projects[admin_menu][version] = "3.0-rc5"

projects[ctools][subdir] = "contrib"
projects[ctools][version] = "1.6"

projects[context][subdir] = "contrib"
projects[context][version] = "3.6"

projects[features][subdir] = "contrib"
projects[features][version] = "2.3"

projects[jquery_update][subdir] = "contrib"
projects[jquery_update][version] = "2.5"

projects[libraries][subdir] = "contrib"
projects[libraries][version] = "2.2"

projects[nodeblock][subdir] = "contrib"
projects[nodeblock][version] = "1.6"

projects[node_export][subdir] = "contrib"
projects[node_export][version] = "3.0"

projects[strongarm][subdir] = "contrib"
projects[strongarm][version] = "2.0"

projects[uuid][subdir] = "contrib"
projects[uuid][version] = "1.0-alpha6"

projects[template_field][subdir] = "contrib"
projects[template_field][patch][] = "http://www.drupal.org/files/issues/add-features-export-support-2425245-1.patch"
projects[template_field][patch][] = "http://www.drupal.org/files/issues/strict_warning_message-2424945-1.patch"
projects[template_field][version] = "1.0-beta6"

; Libraries
; Please fill the following out. Type may be one of get, git, bzr or svn,
; and url is the url of the download.

libraries[mustache][download][type] = "get"
libraries[mustache][download][url] = "https://github.com/bobthecow/mustache.php/archive/v1.1.0.zip"
libraries[mustache][directory_name] = "mustache"
libraries[mustache][type] = "library"
