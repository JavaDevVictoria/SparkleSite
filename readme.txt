SparkleSite v2.2
by Victoria of http://www.victoria-holland.info and JP of http://blog.jp-corner.uni.cc.
Originally released 22 December 2004.
I would like to thank Codegrrl(http://www.codegrrl.com) and Web Designer Magazine (http://www.paragon.co.uk) for their tutorials which helped me to write this script.
_______________________________________________________

INTRO:

SparkleSite is a small open-source PHP script which allows you to input and edit your weblog entries and create pages, without having to go through the hassle of coding in HTML and uploading via FTP every time you want to make an update.  A weblog (aka blog) is simply an online version of a diary, and blogging has become very popular in recent years.  The time and date is automatically added to the end of each of your blog entries, so people know exactly when you posted them.  The script even allows your website's visitors to make comments on each of your blog entries, if they wish.

This script would also be ideal for the news/updates section of a website.  There is also the ability to password-protect individual entries, so that only certain people can access them.


REQUIREMENTS:

Your server must support PHP and you must have an available MySQL database, in which your blog entries and visitor comments will be stored.  This script will not work on free servers such as Geocities, Angelfire, Freewebs etc.
If your server supports PHP but not MySQL, then you may still be able to use this script, by signing up for a free MySQL database from http://www.freesql.org/.


AT-A-GLANCE FEATURES LIST:

*Installer which automatically creates the required tables in your MySQL database.
*Shows the most recent 5 posts in descending order.
*All posts are automatically stored in an archive, so people can view older posts if they wish.
*The current date and time are automatically added to the end of each post.
*Site visitors have the ability to add comments to each of your individual blog posts.
*You (the site owner) have a password-protected admin control panel where you can instantly make new posts, and edit existing posts.
*You can delete existing entries, if you no longer want them displayed on your site.
*Your admin control panel also includes the ability for you to password-protect individual posts, if you only want you and your close friends to be able to read them.
*Next and Previous links, to enable visitors to navigate through the blog entries easily.
*Option to display summaries of the last 5 visitor comments.
*It is a small script, which only takes up a small amount of your webspace, thus making it ideal if you don't have much space.  It is not bloated, and only contains the most essential features, unlike many more complex blogging scripts.

CHANGELOG TO V2.1
The changes from v2 include:
* New skins folder, which allows you to change and customise new stylesheets for your blog.
* New configuration page within the admin control panel, which allows you to customise the blog from within the browser, without having to re-upload the config.php file.
* Improved security features.
* Option to display summaries of the last 5 visitor comments on the front page of your blog.

CHANGELOG TO V2:
The changes from v1.0 include:
* Easier to understand and better-designed admin control panel.
* The bug which prevented existing entries from being deleted has now been fixed. :-)
* A new, completely revised stylesheet is included.

INSTRUCTIONS FOR INSTALLATION AND USE:

1.  In your domain control panel, create a new MySQL database (if you don't already have one set up).  Be sure to note down the name of the database, and create a username and password with which to access the database.  
If you are a hostee on someone else's domain (ie you have a subdomain), then you will need to ask your host to carry out Step 1 for you.

2.  In the config.php file, you will need to go through and change the variables where required - especially your database information.  Open it in a text editor, such as Notepad, to do this. 

3.  On your server create a new folder named "blog" (case sensitive), and upload all the files, including the entire admin folder, into it.

4.  Point your browser to the blogsetup.php file.  (This will probably be in the format of http://www.yourdomain.com/blog/blogsetup.php .)  Two tables will be automatically created inside your MySQL database - one for storing the blog entries, and the other for storing the users' comments.  If you see an error message, you will need to recheck what you wrote in the config.php files, and repeat this step. Once the tables have been successfully set up, delete the blogsetup.php file for security purposes.

5. CHMOD the cpconfig.php file and the config.php file to 666.  This will enable you to change the variables in the config.php file from within your browser.

6.  Via your domain's control panel, you should password-protect the admin folder, so that only you can add and edit posts.  As in Step 1, if you are a hostee, you will need to ask your host to do that for you.

7.  You are now ready to log in to your admin control panel, via www.yourdomain.com/blog/admin/admincp.php, and start blogging!

8.  To make the blog show up on your homepage, just put the following line of code wherever you want it to appear on the page:
<? include('blog/index.php'); ?>  The homepage must be saved with a .php extension for it to work.  The blog will then blend into your existing site layout.


ADDITIONAL NOTES:


If you want to password-protect an individual entry, you will need to open the journal.php file in a text editor, and set a username and password which will always be used for the protected entries, and upload it to your server.  Then if you want to protect an entry, you should tick the appropriate box as you are keying in the entry, before submitting it.


DEVELOPMENT:

Anyone is welcome to take part in the development of this open-source script. The script can be modified and distributed, as long as the readme file and link remains intact.


 





