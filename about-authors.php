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
    
        print '<table class="aboutAuthorTable">';
        print '<thead class="aboutAuthorHeaders">';
        foreach ($headers as $header){
            print '<tr class="tableAuthorHeadingRow">';
            print '<th>' .$header[0].'</th>';
            print '<th>' .$header[1].'</th>';       
            print '<th>' .$header[2].'</th>';
            print '</tr>';
        }
        print '</thead>';
    foreach ($aboutAuthors as $authorData) {
        print '<tr>';
        foreach($authorData as $field) {
            print '<td>';
            print $field;
            print '</td>';
        }
        print '</tr>';
    }
    print '</table>';
    
    include ('footer.php')
    ?>
    
</article>
