<?php include ('top.php');
?>
  
    <article class='authorBio'>
        <h1 class="authorBioH1">Author Languages and Biography</h1>
<?php

        $myFolder = 'finalproject/';

        $myFileName = 'aboutauthors';

        $fileExt = '.csv';

        $filename = $myFolder . $myFileName . $fileExt;

       

        $file=fopen($filename, "r");


            // read the header row, copy the line for each header row
            // you have.
            $headers[] = fgetcsv($file);
    
            while (!feof($file)) {
            $aboutAuthors[] = fgetcsv($file);
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
        print '<td>';
        print $authorData;
        print '</td>;
        print '</tr>';
        }
    print '</table'>;
    
    include ('footer.php')
    ?>
    
</article>
  
