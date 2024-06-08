# 0.6.2 (6-7-2024)

> All notable changes to be documented here.
> The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
> and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

 [ ] More search and browse functions.

 [ ] Research screen reader accessibilty and incorporate.

 [ ] Fix a bug when nothing in database.

 [ ] Security Features.

 [ ] URL Parameter Helper.

 [ ] A way to organize relationships between the models.

 [ ] Error handling and logging.

 [ ] Custom 404 and other status response code pages.

 [ ] Clear separation of code amongst roles in the development process.

 [ ] Support for added plugins and modules.

 [ ] Cron Jobs.

 [ ] Bash files for easy site building.

 [ ] Clear documentation with a list of all practical-to-list classes and methods.

 ### Added 

 > ViewsCRUD.md in the www/MyObject directory - This goes through the process of adding classes and methods to make your own files for CRUD operations.

 > ModelFilesGuide.md in the Models directory - This goes through the process of making model files so the View files for CRUD operations work.

 ### Changed

 > Minor changes to most if not all the files in the www/MyObject directory. 

 > Placed post values of www/MyObject/MyObjectAdded.phtml into a loop to update the table for any column names that are posted.

 > [Admin Portal](https://demo.phpcupcake.shop/admin_portal) now has browse by table functionality. As well as small functional changes.

# 0.6.1 (6-6-2024)

### Changed

> The Framework/DAL/VanillaDAL.md file.

> Comments and notes added to the Framework/DAL/VanillaCupcakeDAL.php file.

### Deprecated

> Deprecated databaseSeeIfTable and getTableColumns in Framework/DAL/VanillaCupcakeDAL.php file.

# 0.6 (6-4-2024)

### Added

> [!NOTE]

> These will go through many changes until v1.

 [ ] Separation of Views and some sort of template engine.

 [ ] An .htaccess file with routing configured to have pretty URLs for any model file created.

 [ ] A data access layer called the VanillaCupcakeDAL performs read/write/delete (CRUD) operations, and search functions, and organizes information into paged results.

 [ ] Model template files to quickly build and perform operations on database tables.

 [ ] Built-in functions for quickly building view files for all CRUD operations.

 [ ] Edit Mode interface for users, (user interface plugin to be available with release), to quickly edit the site on the same site interface with special permissions.

 [x] Special helper classes to quickly build icons and forms.

 [ ] Search functions to search specific tables and columns, or the whole site.

 [x] Makes use of an auto-loader without any need for dependencies. (Yet should still be compatible.)