Description
-----------
This module provides functionality to create a single page website.
It allows you to automatically create a single page from a menu. 
The module will render all the content from the links 
that are configured in the menu.It will then override the menu links 
so that they refer to an anchor instead of a new page.

Installation
------------
To install this module, do the following:

1. Extract the tar ball that you downloaded from Drupal.org.

2. Upload the entire directory and all its contents to your modules directory.

Configuration
-------------
To enable and configure this module do the following:

1. Go to Admin -> Modules, and enable Module Filter.

2. Go to Admin -> Configuration -> System -> Single Page Site Settings, and make
   any necessary configuration changes. 
   
   a) Choose the menu which you want to create a single page for
   b) Define the class/id of the menu wrapper
   c) Define the class(es) of the menu items that should 
      implement the single page navigation.
      (Maybe you don't want all the menu items to be overwritten by an anchor, 
	   eg. contact form on separate page.)
