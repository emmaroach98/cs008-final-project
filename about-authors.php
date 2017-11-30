<?php include ('top.php');
?>
  
    <article class='authorBio'>
        <h1 class="authorBioH1">Author Languages and Biography</h1>
<?php
        $myFolder = 'finalproject/';
        $myFileName = 'aboutauthors';
        $fileExt = '.csv';
        
        $filename = "aboutauthors.csv";
        //$filename = $myFolder . $myFileName . $fileExt;
       
        $file=fopen($filename, "r");
        
            // read the header row, copy the line for each header row
            // you have.
        $headers[] = fgetcsv($file);
        
        if ($file) {
            while (!feof($file)) {
                $aboutAuthors[] = fgetcsv($file);
            }
        }
        
        fclose($file);
    
    foreach ($aboutAuthors as $aboutAuthor) {
                print '<figure class="bioPhoto rounded-corners">';
                print '<img alt="Website Founders" src="images/' . $aboutAuthor[0] . '">';
                print '<figcaption>';
                print $aboutAuthor[1] . ' ' . $aboutAuthor[2];
                print '</figcaption>';
                print '</figure>';
                print '<p>' . $aboutAuthor[3] . '</p>';
            }
    
    include ('footer.php')
    ?>
    
</article>
</body>
</html>
