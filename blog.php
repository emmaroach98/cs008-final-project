<?php
include 'top.php';
?>
<!-- add more for more posts -->
<!-- this area is for a user to input their own blog post --> 
<?php
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//
// SECTION: 1 Initialize variables 
//
// SECTION: 1a. 
// We print out the post array so that we can see our form is working. 
// if ($debug){ // later you can uncomment the if statement
print '<p>Post Array:</p><pre>';
print_r($_POST);
print '</pre>';
// }
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//
// SECTION: 1c form variables
//
// define security variable to be used in SECTION 2a.
$thisURL = $domain . $phpSelf;
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// 
// SECTION: 1c form variables
// 
// Initialize variables one for each form element
// in the order they appear on the form    
$firstName1 = ""; // first name input box
$lastName1 = ""; // last name input box
$email1 = ""; //email input box
$blogPost1 = ""; // text box addition comments about anything 
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//
// SECTION: 1d form error flags
//
// Initialize Error Flags one for each form element we validate 
// in the order they appear in section 1c. 
$firstName1ERROR = false; // error flag for first name variable
$lastName1ERROR = false; //error flag for last name variable
$blogPost1ERROR = false; //error flag for the comments box at the bottom of the page
$email1ERROR = false;

// NEED TO CLEAN ALL THESE VARIABLES AND MAKE SECURITY FOR THEM -- BUTTONS HAVE BEEN MADE NEED TO GO THROUGH REST OF PROCESS!!
////%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// 
// SECTION: 1e misc variables
//
// create array to hold error messages filled (if any) in 2d displayed in 3c.
$errorMsg1 = array();

$dataRecordBlog = array();

$mailed = false;
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2 Process for when the form is submitted
//
if (isset($_POST["btnSubmit"])) {
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// SECTION: 2a Security     

    if (!securityCheck($thisURL)) {
        $msg = '<p>Sorry you cannot access this page. ';
        $msg .= 'Security breach detected and reported.</p>';
        die($msg);
    }
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2b Saitize (clean) data
    //remove any potential JavaScript or html code from users input on the 
    // form. Note it is best to follow the same order as declared in section 1c.
    //cleansing the first name text box with html entities
    $firstName1 = htmlentities($_POST["txtFirstName"], ENT_QUOTES, "UTF-8");
    $dataRecordBlog[] = $firstName1;

    // Cleansing the last name text box with html entities    
    $lastName1 = htmlentities($_POST["txtLastName"], ENT_QUOTES, "UTF-8");
    $dataRecordBlog[] = $lastName1;

// cleansing the email text box with fiter_var and FILTER_SANITIZE_EMAIL  
    $email1 = filter_var($_POST["txtEmail"], FILTER_SANITIZE_EMAIL);
    $dataRecordBlog[] = $email1;

    // cleansing the comments section with htmlentities
    $blogPost1 = htmlentities($_POST["txtBlogPost"], ENT_QUOTES, "UTF-8");
    $dataRecordBlog[] = $blogPost1;

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2c Validation
    //
    // Validation section. Check each value for possible errors, empty or
    // not what we expect. You will need an IF block for each element you will
    // check (see above section 1c and 1d). The if blocks should also be in the 
    // order that the elements appear on your form so that the error messages
    // will be in the order they appear. errorMsg will be displayed on the form
    // see section 3b. The error flag ($emailERROR) will be used in section 3c. 
    //Verifing user inputs name correctly
    if ($firstName1 == "") {
        $errorMsg1[] = "Please enter your first name";
        $firstName1ERROR = true;
    } elseif (!verifyAlphaNum($firstName1)) {
        $errorMsg1[] = "Your first name appears to have extra characters";
        $firstName1ERROR = true;
    }

//verifying user inputs last name correctly
    if ($lastName1 == "") {
        $errorMsg1[] = "Please enter your last name";
        $lastName1ERROR = true;
    } elseif (!verifyAlphaNum($lastName1)) {
        $errorMsg1[] = "Your last name appears to have extra characters";
        $lastName1ERROR = true;
    }

// verifying that the users email address in inputted correctly     
    if ($email1 == "") {
        $errorMsg1[] = 'Please enter your email address';
        $email1ERROR = true;
    } elseif (!verifyEmail($email1)) {
        $errorMsg1[] = 'Your email address appears to be incorrect.';
        $email1ERROR = true;
    }

// verifying that the comments box is just alpha numeric characters
    if ($blogPost1 != "") {
        if (!verifyAlphaNum($blogPost1)) {
            $errorMsg1[] = "Your post appears to have extra characters that are not allowed";
            $blogPost1ERROR = true;
        }
    }

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2d Process Form - Passed Validation
    //
    // Process for when the form passes validation (the errorMsg array is empty)
    //

if (!$errorMsg1) {
        //    print'<p>Form is valid</p>';
        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2e Save Data
        //
        //
       // $myFolder = 'data/';

        $myFileNameOne = 'blogPosts';

        $theFileExt = '.csv';

        $newFileName = $myFileNameOne . $theFileExt;

        // now we just open the file for append
        $newFile = fopen($newFileName, 'a');

        // write the forms informations
        fputcsv($newFile, $dataRecordBlog);

        // close the file
        fclose($newFile);

// SECTION: 2f Create message
        //
        // build a message to display on the screen in section 3a and to mail
        // to the person filling our the form (section 2g).

        $message = '<p style="color:blue;font-size:20px;">Thanks for joining <i><b>Burlington Translate!</i></b> You have submitted a text for our team to translate for you. You wanted the best so you came to us! Great choice! You will recieve an email from us containing all of the information that you have supplied to us. Thanks again for using <b><i>Burlington Translate!</i></b> </p>';
        echo $message;


// THIS ABOVE IF STATEMENT IS A TEST TO SEE IF WE CAN GET RID OF ALL THE VALUES IN THE EMAIL MESSAGE       
        foreach ($_POST as $htmlName => $value) {
            $message .= '<p style="color:blue;font-size:20px;">';
            //breaks up the form names into words. for example
            // txtFirstName becomes First Name
            $camelCase = preg_split('/(?=[A-Z])/', substr($htmlName, 3));
            foreach ($camelCase as $oneWord) {
                $message .= $oneWord . ' ';
            }
            $message .= ' = ' . htmlentities($value, ENT_QUOTES, "UTF-8") . '</p>';
        }

        $message .= '<p style="color:blue;font-size:20px;">Thank you for posting on our blog! We will review your comment and post all appropriate comments soon.</p>';

        //@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2g Mail to user
        //
        // Process for mailing a message which contains the forms data
        // the message was built section 2f. 
        $to = $email1; // the person who filled out the form
        $cc = '';
        $bcc = '';

        $from = 'Translation Team <customer.service@BurlingtonTranslate.com>';

        // subject of mail should make sense in your form
        $subject = 'Translation Registration!';

        $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);
    } // ends if form is valid
}  // ends if form was submitted
// SECTION 3 Display Form
//
?>
<article id="blogPost">
<?php
//if its the first time coming to the form or there are errors we are going 
// to display the form.
if (isset($_POST["btnSubmit"]) AND empty($errorMsg1)) {  // closing of if marked with: end body submit
    print '<h2>Thank you for posting on our blog!</h2>';
    print '<p>For your records we sent you a copy of your comment has ';
    if (!$mailed) {
        print "not ";
    }
    print 'been sent:</p>';
    print '<p>To: ' . $email1 . '</p>';
} else {

    print '<h2>Share Something With Us!</h2>';
    print '<p class="form-heading">Welcome to our blog! Here, we just share some 
        feedback left from different users of our website. Feel free to leave us comments here, 
        and you might be featured on our blog page. We encourage everyone to leave 
        comments in their native language (we will translate) so that we can 
        continue the connection between different languages. Your responses will
        be reviewed and translated within 1-2 days. Thank you!</p>';
    //############################
    //
        // SECTION 3b Error Messages
    //
        // display any error messages before we print out the form

    if ($errorMsg1) {
        print '<div id="errors">' . PHP_EOL;
        print '<h2>Your blog post has the following mistakes that need to be fixed.</h2>' . PHP_EOL;
        print '<ol>' . PHP_EOL;

        foreach ($errorMsg1 as $err1) {
            print '<li>' . $err1 . '</li>' . PHP_EOL;
        }

        print '</ol>' . PHP_EOL;
        print '</div>' . PHP_EOL;
    }


    //#############################
    //
        // SECTION 3c html Form
    //
        /* Display the HTML form. not that the action is to this same page $phpSelf
      is defined in top.php
      NOTE the line:
      value="<?php print $email; ?>
      this make the form sticky by displaying either the initial default value (line ??)
      or the value they typed in (line ??)
      NOTE this line:
      <?php if($emailERROR) print 'class="mistake"' ; ?>
      this prints out a css class so that we can highlight the background etc. to
      make it stand out that a mistake happened here.
     */
    ?>

        <!-- ######################## START OF FORM BUTTONS / TEXT BOXES ############################ -->
        <form action="<?php print $phpSelf; ?>"
              id="blogPostForm"
              method="post">
            <!-- ######################## FIRST NAME TEXT BOX ######################### -->
            <fieldset class="contactInfo">
                <legend>Personal Information</legend>
                <div class="firstNameDiv">
                <p>
                    <label class="required text-field" for="txtFirstName"><span>First Name</span></label>
                    <input
    <?php if ($firstName1ERROR) print 'class="mistake"'; ?>
                        id="txtFirstName"
                        maxlength="45"
                        name="txtFirstName"
                        onfocus="this.select()"
                        placeholder="First Name"
                        tabindex="100"
                        type="text"
                        value="<?php print $firstName1; ?>"
                        >
                </p>
                </div>
                <!-- #################### LAST NAME TEXT BOX ################### -->
                <div class="lastNameDiv">
                <p>
                    <label class="required text-field" for="txtLastName"><span>Last Name</span></label>
                    <input
    <?php if ($lastName1ERROR) print 'class="mistake"'; ?>
                        id="txtLastName"
                        maxlength="45"
                        name="txtLastName"
                        onfocus="this.select()"
                        placeholder="Last Name"
                        tabindex="110"
                        type="text"
                        value="<?php print $lastName1; ?>"
                        >
                </p>
                </div>
                <!-- ######################ENTER USER EMAIL HERE AGAIN ###################### -->
                <div class="emailDiv">
                <p>
                    <label class="required text-field" for="txtEmail"><span>Email</span></label>
                    <input
    <?php if ($email1ERROR) print 'class="mistake"'; ?>
                        id="txtEmail"
                        maxlength="45"
                        name="txtEmail"
                        onfocus="this.select()"
                        placeholder="Enter a valid email address"
                        tabindex="120"
                        type="text"
                        value="<?php print $email1; ?>"
                        >
                </p>
                </div>
            <!-- #######################END THE USER EMAIL INPUT #####################3 -->
            <!-- #################### BLOG BOX HERE ######################## -->
                <p>
                    <label class ="required" for="txtBlogPost">Blog It!</label>
                    <textarea <?php if ($blogPost1ERROR) print 'class="mistake"'; ?> 
                        id="txtBlogPost"
                        name="txtBlogPost"                     
                        onfocus="this.select()"
                        tabindex="200"><?php print $blogPost1; ?>

                    </textarea>
                </p>



            <!-- ######################## SUBMIT BUTTON HERE ######################## --> 

                <legend></legend>
                <input class="button" id="btnSubmit" name="btnSubmit" tabindex="210" type="submit" value="Register" >
            </fieldset> <!-- ends buttons -->
        </form>

    </article>

<?php
$myFolder = '';
$myFileName = 'blogPosts';
$fileExt = '.csv';
        
$filename = "blogPosts.csv";
//$filename = $myFolder . $myFileName . $fileExt;
       
$file=fopen($filename, "r");
        
// read the header row, copy the line for each header row
// you have.
$headers[] = fgetcsv($file);
        
if ($file) {
    while (!feof($file)) {
        $blogPosts[] = fgetcsv($file);
    }
}
        
fclose($file);

foreach ($blogPosts as $blogPost) {
    if ($blogPost[4] != "") {
        print '<article class="blogPosts">';
        print '<figure>';
        print '<img alt="" src="images/anon_user.png">';
        print '<figcaption>' . $blogPost[0] . ' ' . $blogPost[1] . '</figcaption>';
        print '</figure>';
        print '<p class="postExample">' . $blogPost[3] . '</p>';
        print '<p class=postExampleTranslation>' . $blogPost[4] . '</p>';
        print '</article>';
    }
}   

//ends body submit
}
include ('footer.php');
?>  
</body>
</html>
