<?php
include 'top.php';
?>
<article>        
    <h1>Blog</h1>
    <p>Welcome to our blog! Here, we just share some feedback left from different 
        users of our website. Feel free to leave us comments in our request form, 
        and you might be featured on our blog page. We encourage everyone to leave 
        comments in their native language (we will translate) so that we can 
        continue the connection between different languages. Thank you!</p>
</article>
<article class="blogPosts">
    <figure>
        <img alt="" src="images/placeholder.jpg">
        <figcaption>anna101</figcaption>
    </figure>
    <p class="postExample">Hallo! Ich heiße Anna, und ich komme aus Deutschland. Ich studiere Literatur, 
        und ich finde Übersetzung sehr wichtig, weil viele Länder besser miteinander 
        kommunizieren können, wenn sie die Sprache der andere Länder lesen können. 
        Aber viele Leute kann nur ein oder zwei Sprachen sprechen/lesen, und deshalb 
        sind Übersetzer sehr wichtig. Wir brauchen immer Leute, die andere Sprachen 
        können, damit wir alle miteinander sprechen können. Ich bin so froh, dass 
        Translating Burlington Übersetzungen macht, und wir können für spezifische 
        Texten erbitten. Sie sind sehr gut, die Übersetzungen sind realistisch, 
        genau und verständlich, und ich werde sie anderen Leuten empfehlen. Vielen 
        Dank für diese Webseite, sie ist sehr schön.</p>
 </article>
 <article class="blogPosts">
     <figure>
        <img alt="" src="images/placeholder.jpg">
        <figcaption>anna101</figcaption>
    </figure>
    <p class="postExampleTranslation">Hi! My name is Anna, and I’m from Germany. I study literature, and I think 
        translation is very important. Countries can communicate with each other better 
        when they can understand the languages of other countries. But a lot of people 
        can only speak/read one or two languages, and therefore translators are very 
        important. We always need more people that can speak other languages, so that 
        we can all speak with each other. I’m very happy that Translation Burlington 
        makes translations, and we can request specific texts to be translated. They’re 
        really good, the translations are very realistic, exact, and understandable, 
        and I will definitely recommend them to other people. Thank you so much for 
        making this website, it’s amazing!</p>
    <!-- add more for more posts -->
</article>
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
$firstName = ""; // first name input box

$lastName = ""; // last name input box

$blogPost = ""; // text box addition comments about anything 

//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//
// SECTION: 1d form error flags
//
// Initialize Error Flags one for each form element we validate 
// in the order they appear in section 1c. 
$firstNameERROR = false; // error flag for first name variable

$lastNameERROR = false; //error flag for last name variable

$blogPostERROR = false; //error flag for the comments box at the bottom of the page

// NEED TO CLEAN ALL THESE VARIABLES AND MAKE SECURITY FOR THEM -- BUTTONS HAVE BEEN MADE NEED TO GO THROUGH REST OF PROCESS!!
////%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// 
// SECTION: 1e misc variables
//
// create array to hold error messages filled (if any) in 2d displayed in 3c.
$errorMsg = array();
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

 // cleansing the comments section with htmlentities
    $blogPost = htmlentities($_POST["txtBlogPost"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $blogPost;

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
  // verifying that the comments box is just alpha numeric characters
  if ($blogPost != "") {
    if (!verifyAlphaNum($comments)) {
     $errorMsg[] = "Your comments appear to have extra characters that are not allowed.";
     $blogPostERROR = true;
  }
}

//if its the first time coming to the form or there are errors we are going 
// to display the form.
    if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) {  // closing of if marked with: end body submit
        print '<h2>Thanks For Posting on Our Blog!</h2>';
       // if (!$mailed){
       //     print "not ";
       // } 
       // print 'been sent:</p>';
       // print '<p>To: ' . $email . '</p>';        
} else {
   
        print '<h2>Share Something With Us!</h2>';
        print '<p class="form-heading">Post on Our Blog! Share Your Opinions!</p>';
        //############################
        //
        // SECTION 3b Error Messages
        //
        // display any error messages before we print out the form
        
        if ($errorMsg){
            print '<div id="errors">' . PHP_EOL;
            print '<h2>Your blog post has the following mistakes that need to be fixed.</h2>' . PHP_EOL;
            print '<ol>' . PHP_EOL;
            
            foreach ($errorMsg as $err) {
                print '<li>' . $err . '</li>' . PHP_EOL;
            }
            
            print '</ol>' . PHP_EOL;
            print '</div>' . PHP_EOL;
        }
}
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

<article class='blogPosting'>
       
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
   <!-- #################### COMMENT BOX HERE ######################## -->
                <fieldset class="blogPostBox">
                      <p>
                          <label class ="required" for="txtBlogPost">Blog It!</label>
                          <textarea <?php if ($blogPostERROR) print 'class="mistakes"'; ?> 
                              id="txtBlogPost"
                              name="txtBlogPost"
                              onfocus="this.select()"
                              tabindex="200"><?php print $blogPost; ?></textarea>
                      </p>
                </fieldset>
     <!-- ######################## SUBMIT BUTTON HERE ######################## --> 
     
            <fieldset class="buttons">
                <legend></legend>
                <input class="button" id="btnSubmit" name="btnSubmit" tabindex="210" type="submit" value="Register" >
            </fieldset> <!-- ends buttons -->
                    </form>
</article>
<?php
include ('footer.php');
?>  

</body>
</html>
