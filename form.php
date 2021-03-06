<?php
include 'top.php';
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//
// SECTION: 1 Initialize variables 
//
// SECTION: 1a. 
// We print out the post array so that we can see our form is working. 
if ($debug){ // later you can uncomment the if statement
    print '<p>Post Array:</p><pre>';
    print_r($_POST);
    print '</pre>';
}
    
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
$firstName = ""; // first name input box
$lastName = ""; // last name input box
$email = ""; //email input box
$authorOfText = ""; //author of text wanted translate input box
$nameOfText = ""; //title of text wanted translate input box
$languageTranslate = ""; //radio buttons to click for translation
$nativeLanguage = "English"; // list box native language spoke
$english = false; //     check box language spoke
$spanish = false; //    check box language spoke
$german = false; //     check box language spoke
$french = false; //     check box language spoke
$russian = false; //    check box language spoke  NONE OF THESE CHECKBOXES ARE REQUIRED
$portuguese = false; // check box language spoke
$hindi = false; //      check box language spoke
$arabic = false; //     check box language spoke
$comments = ""; // text box addition comments about anything 
  
    
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//
// SECTION: 1d form error flags
//
// Initialize Error Flags one for each form element we validate 
// in the order they appear in section 1c. 
$firstNameERROR = false; // error flag for first name variable
$lastNameERROR = false; //error flag for last name variable
$emailERROR = false;  // error flag to make sure email is valid
$authorOfTextERROR = false; //error flag to make sure name of author is valid characters
$nameOfTextERROR = false; // error flag to make sure name of text is valid characters
$languageTranslateERROR = false; // error flag for radio buttons
$nativeLanguageERROR = false; // error flag for the list box
$checkLanguageERROR = false; //error flag for the check boxes 
$totalChecked = 0; // set accumulator value to count how many checked boxes there are
$commentsERROR = false; //error flag for the comments box at the bottom of the page
// NEED TO CLEAN ALL THESE VARIABLES AND MAKE SECURITY FOR THEM -- BUTTONS HAVE BEEN MADE NEED TO GO THROUGH REST OF PROCESS!!
////%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// 
// SECTION: 1e misc variables
//
// create array to hold error messages filled (if any) in 2d displayed in 3c.
$errorMsg = array();
// array used to hold form values that will be written to a CSV file
$dataRecord = array();
// have we mailed the information to the user?
$mailed=false; 
    
 
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2 Process for when the form is submitted
//
if (isset($_POST["btnSubmit"])) {
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// SECTION: 2a Security     
    
    if (!securityCheck($thisURL)) {
        $msg = '<p>Sorry you cannot access this page. ';
        $msg.= 'Security breach detected and reported.</p>';
        die($msg);
    }
 
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2b Saitize (clean) data
    //remove any potential JavaScript or html code from users input on the 
    // form. Note it is best to follow the same order as declared in section 1c.
    
    
 //cleansing the first name text box with html entities
    $firstName = htmlentities($_POST["txtFirstName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $firstName;
  
 // Cleansing the last name text box with html entities    
    $lastName = htmlentities($_POST["txtLastName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $lastName;
  
 // cleansing the email text box with fiter_var and FILTER_SANITIZE_EMAIL  
    $email = filter_var($_POST["txtEmail"], FILTER_SANITIZE_EMAIL);   
    $dataRecord[] = $email;
  
 // cleansing the author of the text box with html entities
    $authorOfText = htmlentities($_POST["txtAuthor"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $authorOfText;
  
 // cleansing the name of text being translated text box with html entities
    $nameOfText = htmlentities($_POST["txtNameText"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $nameOfText;
    
  // cleansing the language translate radio button with html entities
    $languageTranslate = htmlentities($_POST["radLanguages"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $languageTranslate;
  
  //cleansing the native language list box with htmlentities
    $nativeLanguage = htmlentities($_POST["lstNativeLanguage"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $nativeLanguage;
   
  //checking the checkboxes to keep track of how many are pressed
    if (isset($_POST["chkEnglish"])) {
        $english = true;
        $dataRecord[] = htmlentities($_POST["chkEnglish"], ENT_QUOTES, "UTF-8");
        $totalChecked++;
    } else {
        $english = false;
        $dataRecord[] = "";
    }
    
    if (isset($_POST["chkSpanish"])) {
        $spanish = true;
        $dataRecord[] = htmlentities($_POST["chkSpanish"], ENT_QUOTES, "UTF-8");
        $totalChecked++;
    } else {
        $spanish = false;
        $dataRecord[] = "";
    }
    
    if (isset($_POST["chkGerman"])) {
        $german = true;
        $dataRecord[] = htmlentities($_POST["chkGerman"], ENT_QUOTES, "UTF-8");
        $totalChecked++;
    } else {
        $german = false;
        $dataRecord[] = "";
    }
    
    if (isset($_POST["chkFrench"])) {
        $french = true;
        $dataRecord[] = htmlentities($_POST["chkFrench"], ENT_QUOTES, "UTF-8");
        $totalChecked++;
    } else {
        $french = false;
        $dataRecord[] = "";
    }
    
    if (isset($_POST["chkRussian"])) {
        $russian = true;
        $dataRecord[] = htmlentities($_POST["chkRussian"], ENT_QUOTES, "UTF-8");
        $totalChecked++;
    } else {
        $russian = false;
        $dataRecord[] = "";
    }
    
    if (isset($_POST["chkPortuguese"])) {
        $portuguese = true;
        $dataRecord[] = htmlentities($_POST["chkPortuguese"], ENT_QUOTES, "UTF-8");
        $totalChecked++;
    } else {
        $portuguese = false;
        $dataRecord[] = "";
    }
    
    if (isset($_POST["chkHindi"])) {
        $hindi = true;
        $dataRecord[] = htmlentities($_POST["chkHindi"], ENT_QUOTES, "UTF-8");
        $totalChecked++;
    } else {
        $hindi = false;
        $dataRecord[] = "";
    }
    
    if (isset($_POST["chkArabic"])) {
        $arabic = true;
        $dataRecord[] = htmlentities($_POST["chkArabic"], ENT_QUOTES, "UTF-8");
        $totalChecked++;
    } else {
        $arabic = false;
        $dataRecord[] = "";
    }
  
 // cleansing the comments section with htmlentities
    $comments = htmlentities($_POST["txtComments"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $comments;
  
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
 if ($firstName == "") {
        $errorMsg[] = "Please enter your first name";
        $firstNameERROR = true;
    } elseif (!verifyAlphaNum($firstName)) {
        $errorMsg[] = "Your first name appears to have extra characters";
        $firstNameERROR = true;
    }  
  
//verifying user inputs last name correctly
if ($lastName == "") {
    $errorMsg[] = "Please enter your first name";
    $lastNameERROR = true;
} elseif (!verifyAlphaNum($lastName)) {
    $errorMsg[] = "Your first name appears to have extra characters";
    $lastNameERROR = true;
}
  
// verifying that the users email address in inputted correctly     
if ($email == "") {
    $errorMsg[] = 'Please enter your email address';
    $emailERROR = true;
} elseif (!verifyEmail($email)) {
    $errorMsg[] = 'Your email address appears to be incorrect.';
    $emailERROR = true;
}
  
//Making sure the name of the author is simply text and not any nonsense of javascript
if ($authorOfText == "") {
    $errorMsg[] = "Please enter the name of the Authors name";
    $authorOfTextERROR = true;
} elseif (!verifyAlphaNum($authorOfText)) {
    $errorMsg[] = "Your Author's name can only contain numbers, letters, dashes, spaces, single quotes, and periods";
    $authorOfTextERROR = true;
}
  
// making sure the name of text text box is simple text and no JavaScript
if ($nameOfText == "") {
    $errorMsg[] = "Please enter the text you'd like translated";
    $nameOfTextERROR = true;
} elseif (!verifyAlphaNum($nameOfText)) {
    $errorMsg[] = 'Your text box has illegal characters you may only use numbers, letters, dashes, spaces, single quotes, and periods';
    $nameOfTextERROR = true;
}
  // we need to make a foreach loop to validate that one of the radio buttons are pressed
    if ($languageTranslate == "" ){
        $errorMsg[] = "You need to pick a language to translate to";
        $languageTranslateERROR = true;     
    }
    
  // verifying that the comments box is just alpha numeric characters
  if ($comments != "") {
    if (!verifyAlphaNum($comments)) {
     $errorMsg[] = "Your comments appear to have extra characters that are not allowed.";
     $commentsERROR = true;
  }
}
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2d Process Form - Passed Validation
    //
    // Process for when the form passes validation (the errorMsg array is empty)
    //
    if (!$errorMsg) {
        //    print'<p>Form is valid</p>';
      
    
        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2e Save Data
        //
        //
       // $myFolder = 'data/';
    
        $myFileName = 'registration';
        
        $fileExt = '.csv';
      
        $filename = $myFileName . $fileExt;
      
      // until we know if we have a "data" folder keep this line uncommented please
      
     //   $filename = $myFolder . $myFileName . $fileExt;
      
     //   if ($debug) print PHP_EOL . '<p>filename is ' . $filename;
    
        // now we just open the file for append
        $file = fopen($filename, 'a');
    
        // write the forms informations
        fputcsv($file, $dataRecord);
    
        // close the file
        fclose($file);
    
    
        //@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2f Create message
        //
        // build a message to display on the screen in section 3a and to mail
        // to the person filling our the form (section 2g).
           
          $message = '<p style="color:blue;font-size:20px;">Thank you for joining <i><b>Burlington Translate!</i></b> You have submitted a text for our team to translate for you. You wanted the best so you came to us! Great choice! You will recieve an email from us containing all of the information that you have supplied to us.</p>';
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
 
        //@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2g Mail to user
        //
        // Process for mailing a message which contains the forms data
        // the message was built section 2f. 
        $to = $email; // the person who filled out the form
        $cc = '';
        $bcc = 'earoach@uvm.edu';
    
        $from = 'Translation Team <customer.service@BurlingtonTranslate.com>';
    
        // subject of mail should make sense in your form
        $subject = 'Translation Registration!';
        
        $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);
     
        
    } // ends if form is valid
    
}  // ends if form was submitted
       
//#####################################################################
//
// SECTION 3 Display Form
//
?>
 <article id="main">
<?php
//
//if its the first time coming to the form or there are errors we are going 
// to display the form.
    if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) {  // closing of if marked with: end body submit
        print '<p>For your records we sent you a copy of your translation request has ';
        if (!$mailed){
            print "not ";
        } 
        print 'been sent:</p>';
        print '<p>To: ' . $email . '</p>';        
} else {
   
        print '<h2>Get Translated Today!</h2>';
        print '<p class="form-heading">Enter something you would like translated.</p>';
        //############################
        //
        // SECTION 3b Error Messages
        //
        // display any error messages before we print out the form
        
        if ($errorMsg){
            print '<div id="errors">' . PHP_EOL;
            print '<h2>Your form has the following mistakes that need to be fixed.</h2>' . PHP_EOL;
            print '<ol>' . PHP_EOL;
            
            foreach ($errorMsg as $err) {
                print '<li>' . $err . '</li>' . PHP_EOL;
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
          id="frmRegister"
          method="post">
        <!-- ######################## FIRST NAME TEXT BOX ######################### -->
                <fieldset class="contact">
                    <legend>Personal Information</legend>
                    <p>
                        <label class="required text-field" for="txtFirstName">First Name</label>
                        <input autofocus
                                <?php if ($firstNameERROR) print 'class="mistake"'; ?>
                                 id="txtFirstName"
                                 maxlength="10"
                                 name="txtFirstName"
                                 onfocus="this.select()"
                                 placeholder="First Name"
                                 tabindex="100"
                                 type="text"
                                 value="<?php print $firstName; ?>"
                            >
                    </p>
        <!-- #################### LAST NAME TEXT BOX ################### -->
                     <p>
                        <label class="required text-field" for="txtLastName">Last Name</label>
                            <input
                                <?php if ($lastNameERROR) print 'class="mistake"'; ?>
                                 id="txtLastName"
                                 maxlength="15"
                                 name="txtLastName"
                                 onfocus="this.select()"
                                 placeholder="Last Name"
                                 tabindex="110"
                                 type="text"
                                 value="<?php print $lastName; ?>"
                            >
                     </p>
      <!-- #################### EMAIL TEXT BOX ###################### --> 
                    <p>
                        <label class="required text-field" for="txtEmail">Email</label>
                            <input
                                <?php if ($emailERROR) print 'class="mistake"'; ?>
                                id="txtEmail"
                                maxlength="45"
                                name="txtEmail"
                                onfocus="this.select()"
                                placeholder="Enter a valid email address"
                                tabindex="120"
                                type="text"
                                value="<?php print $email; ?>"
                            >
                    </p>
                    
                     <p>
                        <label class="required text-field" for="txtAuthorName">Author of Text</label>
                            <input
                                <?php if ($authorOfTextERROR) print 'class="mistake"'; ?>
                                id="txtAuthorName"
                                maxlength="45"
                                name="txtAuthor"
                                onfocus="this.select()"
                                placeholder="Authors Name"
                                tabindex="130"
                                type="text"
                                value="<?php print $authorOfText; ?>"
                            >
                    </p>
                    
                     <p>
                        <label class="required text-field" for="txtNameText">Name of Text</label>
                            <input
                                <?php if ($nameOfTextERROR) print 'class="mistake"'; ?>
                                id="txtNameText"
                                maxlength="45"
                                name="txtNameText"
                                onfocus="this.select()"
                                placeholder="Enter name of text to translate"
                                tabindex="140"
                                type="text"
                                value="<?php print $nameOfText; ?>"
                            >
                     </p>          
                  
                </fieldset> <!-- ends First name, Last Name, Name of Author, Name of text to translate -->
                
                
                <!-- ################# Radio buttons start here ############### -->
                <fieldset class="radio <?php if ($languageTranslateERROR) print ' mistake'; ?>">
                <legend>What Language Would You Like to Translate Your Text to?</legend>
                <p>
                    <label class="radio-field">
                        <input type="radio"
                               id="radTranslateEnglish"
                               name="radLanguages"
                               value="English"
                               tabindex="150"
                               <?php if ($languageTranslate == "English") echo ' checked="checked" '; ?>>
                        English</label>
                </p>
                <p>
                    <label class="radio-field">
                        <input type="radio"
                               id="radTranslateGerman"
                               name="radLanguages"
                               value="German"
                               tabindex="160"
                               <?php if ($languageTranslate == "German") echo ' checked="checked" '; ?>>
                        German</label>
                </p>
                
                <p>
                    <label class="radio-field">
                        <input type="radio"
                               id="radTranslateFrench"
                               name="radLanguages"
                               value="French"
                               tabindex="170"
                               <?php if ($languageTranslate == "French") echo ' checked="checked" '; ?>>
                        French</label>
                </p>
                
                <p>
                    <label class="radio-field">
                        <input type="radio"
                               id="radTranslateSpanish"
                               name="radLanguages"
                               value="Spanish"
                               tabindex="180"
                               <?php if ($languageTranslate == "Spanish") echo ' checked="checked" '; ?>>
                        Spanish</label>
                </p>
            </fieldset>
                
                <h2 class="additionalInfo"> Additional Information (* optional *) </h2> 
                      
                <!-- ######################### adding a list box ########################### -->
            <fieldset class="listbox <?php if ($nativeLanguageERROR) print ' mistake'; ?>">
                <legend>Native Language</legend>
                <p>
                <select id="lstNativeLanguages"
                    name="lstNativeLanguage"
                    tabindex="190" >
                    <option <?php if($nativeLanguage=="English") print " selected "; ?>
                        value="English">English</option>
                    
                    <option <?php if($nativeLanguage=="Spanish") print " selected "; ?>
                        value="Spanish">Spanish</option>
                    
                    <option <?php if($nativeLanguage=="German") print " selected "; ?>
                        value="German">German</option>
                    
                    <option <?php if($nativeLanguage=="French") print " selected "; ?>
                        value="French">French</option>
                    
                    <option <?php if($nativeLanguage=="Russian") print " selected "; ?>
                        value="Russian">Russian</option>
                    
                    <option <?php if($nativeLanguage=="Portuguese") print " selected "; ?>
                        value="Portuguese">Portuguese</option>
                    
                    <option <?php if($nativeLanguage=="Hindi") print " selected "; ?>
                        value="Hindi">Hindi</option>
                    
                    <option <?php if($nativeLanguage=="Arabic") print " selected "; ?>
                        value="Arabic">Arabic</option>
                </select>
            </p>
            </fieldset>
   <!-- ########################### adding check boxes ############################## -->
            <fieldset class="checkboxes <?php if ($checkLanguageERROR) print ' mistake'; ?>">
                <legend>What languages can you speak? (check all that apply):</legend>
                
                <p>
                    <label class="check-field">
                        <input <?php if($english) print " checked "; ?>
                            id="chkEnglish"
                            name="chkEnglish"
                            tabindex="200"
                            type="checkbox"
                            value="English"> English</label>
                </p>
                
                <p>
                    <label class="check-field">
                        <input <?php if ($spanish) print " checked "; ?>
                            id="chkSpansih"
                            name="chkSpanish"
                            tabindex="210"
                            type="checkbox"
                            value="Spanish">Spanish</label>
                </p>
                
                <p>
                    <label class="check-field">
                        <input <?php if ($german) print " checked "; ?>
                            id="chkGerman"
                            name="chkGerman"
                            tabindex="220"
                            type="checkbox"
                            value="German">German</label>
                </p>
                
                <p>
                    <label class="check-field">
                        <input <?php if ($french) print " checked "; ?>
                            id="chkFrench"
                            name="chkFrench"
                            tabindex="230"
                            type="checkbox"
                            value="French">French</label>
                </p>
                
                <p>
                    <label class="check-field">
                        <input <?php if ($russian) print " checked "; ?>
                            id="chkRussian"
                            name="chkRussian"
                            tabindex="240"
                            type="checkbox"
                            value="Russian">Russian</label>
                </p>
                
                <p>
                    <label class="check-field">
                        <input <?php if ($portuguese) print " checked "; ?>
                            id="chkPortuguese"
                            name="chkPortuguese"
                            tabindex="250"
                            type="checkbox"
                            value="Portuguese">Portuguese</label>
                </p>
                
                <p>
                    <label class="check-field">
                        <input <?php if ($hindi) print " checked "; ?>
                            id="chkHindi"
                            name="chkHindi"
                            tabindex="260"
                            type="checkbox"
                            value="Hindi">Hindi</label>
                </p>
                
                <p>
                    <label class="check-field">
                        <input <?php if ($arabic) print " checked "; ?>
                            id="chkArabic"
                            name="chkArabic"
                            tabindex="270"
                            type="checkbox"
                            value="Arabic">Arabic</label>
                </p>
            </fieldset>
   <!-- ######################## COMMENT BOX HERE ######################## -->
                <fieldset class="commentBox">
                      <p>
                          <label class ="required" for="txtComments">Comments</label>
                          <textarea <?php if ($commentsERROR) print 'class="mistakes"'; ?> 
                              id="txtComments"
                              name="txtComments"
                              onfocus="this.select()"
                              tabindex="300"><?php print $comments; ?></textarea>
                      </p>
                </fieldset>
     <!-- ######################## SUBMIT BUTTON HERE ######################## --> 
     
            <fieldset class="buttons">
                <legend></legend>
                <input class="button" id="btnSubmit" name="btnSubmit" tabindex="400" type="submit" value="Register" >
            </fieldset> <!-- ends buttons -->
    </form>
    
<?php   
} //end body submit
?>        
</article>

<?php include 'footer.php'; ?>

</body>
</html>
