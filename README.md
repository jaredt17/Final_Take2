
Hisser!
=============================================================
A basic Twitter clone in PHP and MySQLi

-Run "setup.php" to setup database and tables

List of Files (so far)
==============================================================
setup.php| This file is used for creation of the databases we need like users, comments, profileimg, followers



_______________________________________________________________
database.php| Establishes a connection the database using mysqli


______________________________________________________________
config.php| Contains all of the database information like host, username, password, database name


______________________________________________________________
index.php| This is the landing page for all users. You start here and login or sign up through the respective forms. Once logged in your session is created
holding your session information like Session['userid'] etc.



______________________________________________________________
login.php| Used to "log in" a user, aka set their session variables to active 
Also verifies your password using password_verify. 
Passes you to your profile page which is also your personal homepage.


______________________________________________________________
signup.php| Enters your information into a database. Uses light javascript form verification and encrypts your password. Pushes you to the login form.



______________________________________________________________
logout.php| Destroys/unsets the session and gives you a nice logout message. 
Returns you to the landing page or index.php



______________________________________________________________
error.php| At any time if you encounter an error, you should be redirected to this page. This can be done using $_Session['message']. Will push you back to index.php.




______________________________________________________________
accountSettings.php| Here you can delete your account or change your password in the respective form. Pushes you back to index.php if you delete your account, otherwise you are sent back to your profile page. 


______________________________________________________________
profile.php| This is your personal homepage. Your page will be located at profile.php?id=XX. If you are on your own page, you can add comments to the database, change your profile picture, and see a custom feed showing your posts and any users posts that you follow in descending order by date. 

______________________________________________________________
user.php| This is the main class where we create a constructor for a user. Each user will have their own userid that is tracked whenever you go to a new page. This is how we know what content to report to the screen. user.php also contains all of our primary functions like showing all users, retrieving your feed, or another member's posts. 


______________________________________________________________
addComment.php| This handles the sql for adding comments to the database. 



______________________________________________________________
newPassword.php| Handles the sql for updating your password in the database.


______________________________________________________________
deleteAcc.php| Handles the sql for account deletion. Was a bit weird because we have to delete the comments, then the followers associated with the account before we could delete the account itself. 


______________________________________________________________
followuser.php| Handles the sql for following and unfollowing users. 
 

______________________________________________________________
fileUpload.php| Allows users to upload images no larger than 1mb or 1048580 bytes. So far we have only implemented jpg images. More image types will be supported soon. Converts your image to uploads/'userid'.jpg



_______________________________________________________________
search.php| Allows us to search the database for either users or comments. Will show profile images along with the results. Made use of the LIKE clause in mysqli for this file. 




______________________________________________________________
like.php| Adds likes to the comments in our database using sql. Is called in user.php multiple times!

==============================================================