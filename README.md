# Nanodesk
A docker container for the Nanodesk server which makes it easier to publish nanopublications.
Currently, the server is not yet fully functional and contains several bugs that need to be fixed.
## Documentation
The container functions with a docker-compose file which also sets up the mysql database which is required for the site. For development purposes this database is currently set up without any password. When the container becomes operational this needs of course needs to be changed.

The website itself is located in the "desk" directory which is loaded into "/var/www/html/web" by the docker-compose file. This is also done for development purposes to see changes immediately, when everything is working correctly the website is ideally loaded in the Dockerfile itself. Due to several problems only the homepage is currently working correctly and all the redirect to other pages do not work. However, when reviewing the code for these other pages it seems to be fine.

To make nanopublications one needs to login with an ORCID account, otherwise no nanopublications can be made. For more information about ORCID look at https://orcid.org

### Starting the container
The container can be started by calling docker-compose up from inside the directory on your system. The homepage of the server can then be found on: "localhost:8000/web/index.php". When using "localhost:8000/web/" the index page should also be loaded automatically.

### Changes for Docker container
* $root in the "config.inc.php" is changed from "nanodesk.nl" to "." to be able to run it on a localhost for developement.
* removed the specific ORCID CLIENT_ID and CLIENT_SECRET from "config.inc.php".
* commented part of a function in "classes/head.class.php" due to the fact that "count()" raises an error and in the current state of the container this code is not yet needed.
* .htaccess is currently not included in the container due to the fact that this will cause an internal server error.

### Current problems
Problems that have been found with a small description what possibly is going wrong. These problems still need to be fixed.
#### Redirects
As mentioned before the redirects to other pages does not work. When looking at "index.php" one can see that "$GET['page']" is used to load the right page. As of now this is not working properly and therefore the redirects will not work. The page itself is initialised as "index", therefore this is working. Changing this to other pages shows that the other pages also load correctly. Thus, the problem is in "$GET['page']", the absence of the .htaccess file could possibly also contribute to this problem.

#### Login system
When logging in with an ORCID ID the redirect from ORCID back to the the server is not working. The reason for this that in "config.inc.php" a specific ORCID CLIENT_ID and CLIENT_SECRET is required, this means that the server will probably only work for that specific user. To make the servers accessible for multiple users the login system probably needs to be changed such that CLIENT_IDs and CLIENT_SECRETs are saved in an encrypted way into the database.


#### Possibly - Publishing part
Due to the previous problems other parts of the system are untested such as the important publishing part. Therefore, other problems can arise during the creation and publication of the nanopublications.
