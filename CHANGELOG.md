 # 0.7.3 (6-12-2024)

 > All notable changes to be documented here.

 ### BUG FIX

 - LinkBuilder.php was not routing to Model Files correctly.

# 0.7.2 (6-11-2024)

 ## [Unreleased]

 [ ] Make a drop down to view amount of items per page.

 [ ] Put built routing into classes and functions.

 [ ] Incorporate **searchable vs. searchable by admin** feature.

 [ ] Fix auth.inc.php broken edit mode link.

 [ ] Figure out dropdown form parameter in Model template files.

 [ ] Turn link builder into a class.

 [ ] Come up with an easy generic *scalable* routing system.

 [ ] Route to index file if no welcome.phtml.

 [ ] Incorporate the display feature of model files to only display table columns chosen.

 [ ] Back link on some pages is needed or unneccessary to be fixed accordingly.

 [ ] Flagging system with back up of deleted db entries, to be cron jobbed to delete fully. 

 [ ] A way to organize relationships between the models.

 [ ] User authentication for admin portal.

 [ ] Support for added plugins and modules.

 [ ] Batch files for easy site building.

 > [!NOTE]
 > Any help toward building batch files into languages for other OS' would be appreciated, and linked to.

 [ ] Clear documentation with a list of all practical-to-list classes and methods.

 ## [Released]
 
 ### Added

 - Moved sample site to be included admin portal and now site has a welcome page.

 - More options to model files.

 - Admin routing.

 - Admin portal finished.

 - Link builder created for auto navigation of viewing and adding db objects. It uses the model files to know which links to display.

 ### Changed

 - Changes to autoloader to implement plugins.

 - One set of pages for all CRUD actions.

 - More bug fixes to search when no rows in database.

 - Working on OAuth github plugin, so users can be implemented from the start.

 ### Deprecated
 
 ~~[x] An .htaccess file with routing configured to have pretty URLs for any model file created.~~
 
 # 0.7.1 (6-10-2024)

 ### Changed

 - Minor bug fixes throughout, made view templates more generic.

 # 0.7.0 (6-9-2024)

 ## [Released]

 [x] Research screen reader accessibilty and incorporate.

 [x] Fix a bug when nothing in database.

 [x] More search and browse functions.

 [x] URL Parameter Helper.

 [x] Error handling and logging.

 [x] Security Features.

 [x] Custom 404 and other status response code pages.

 ### Added

 - NPC Objects for testing purposes.

 - URL Params Helper in Framework/Helpers/UrlParamsHelper.php

 - Error logging added to each potential error with database queries/connections.

 - Custom http status code error pages. (Included 404 and 500).

 - Browse by table column feature with custom user friendly names.

 ### Changed
 
 - Framework\DAL\VanillaCupcakeDAL.php added a try/catch error statement in getFieldNamesFunction

 - www\MyObject\addMyObject.phtml Fixed search form not appearing bug. (Used `<?php` instead of `<?=`).

 - Bug Fix with Search Feature. Added an if statement for search only to appear if database has something.

 - Admin portal to go through many changes.

 - Changes to www/MyObject Templates.

 * Added tablename to post values for scalability.

 * Minor changes to update and add save pages.

 - Search feature has sort by relevancy. Search feature should be complete and free of bugs.

 - Fixed search and view all so error messages no longer display if nothing in database.

 ### Deprecated

 - Many methods unused in Framework\DAL\VanillaCupcakeDAL.php Check Framework\DAL\VanillaDAL.md for specific deprecated methods.

 # 0.6.2 (6-7-2024)

 ### Added 

 - ViewsCRUD.md in the www/MyObject directory - This goes through the process of adding classes and methods to make your own files for CRUD operations.

 - ModelFilesGuide.md in the Models directory - This goes through the process of making model files so the View files for CRUD operations work.

 ### Changed

 - Minor changes to most if not all the files in the www/MyObject directory. 

 - Placed post values of www/MyObject/MyObjectAdded.phtml into a loop to update the table for any column names that are posted.

 - [Admin Portal](https://demo.phpcupcake.shop/admin_portal) now has browse by table functionality. As well as small functional changes.

# 0.6.1 (6-6-2024)

### Changed

 - The Framework/DAL/VanillaDAL.md file.

 - Comments and notes added to the Framework/DAL/VanillaCupcakeDAL.php file.

### Deprecated

 - Deprecated databaseSeeIfTable and getTableColumns in Framework/DAL/VanillaCupcakeDAL.php file.

# 0.6 (6-4-2024)

## [Released]

> [!NOTE]

> These will go through many changes until v1.

 [x] An .htaccess file with routing configured to have pretty URLs for any model file created.

 [ ] A data access layer called the VanillaCupcakeDAL performs read/write/delete (CRUD) operations, and search functions, and organizes information into paged results.

 [x] Model template files to quickly build and perform operations on database tables.

 [x] Built-in functions for quickly building view files for all CRUD operations.

 [ ] Clear separation of code amongst roles in the development process.

 [x] Edit Mode interface for users, (user interface plugin to be available with release), to quickly edit the site on the same site interface with special permissions.

 [x] Special helper classes to quickly build icons and forms.

 [x] Search functions to search specific tables and columns, or the whole site.

 [x] Makes use of an auto-loader without any need for dependencies. (Yet should still be compatible.)
