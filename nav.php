<!-- ######################    Start of Nav   ########################## -->
<nav>
    <ol>
        <?php       
        print '<li class="';
        if ($path_parts[ 'filename' ] == "index") {
            print ' activePage ';
        }
        print '">';
        print'<a href="index.php">Home</a>';  //may have to change href depending on folders
        print'</li>';
        
        print '<li class="';
        if ($path_parts[ 'filename' ] == "learn-more") {
            print ' activePage ';
        }
        print '">';
        print'<a href="learn-more.php">Learn More</a>';
        print'</li>';
        
        print '<li class="';
        if ($path_parts[ 'filename' ] == "about-authors") {
            print ' activePage ';
        }
        
        print '">';
        print'<a href="about-authors.php">About the Authors</a>';
        print'</li>';
        
        print '<li class="';
        if ($path_parts[ 'filename' ] == "sample-text") {
            print ' activePage ';
        }
        
        print '">';
        print'<a href="sample-text.php">Sample Texts</a>';
        print'</li>';
        
        print '<li class="';
        if ($path_parts[ 'filename' ] == "form") {
            print ' activePage ';
        }
        print '">';
        print'<a href="form.php">Form</a>';
        print'</li>';
        
        print '<li class="';
        if ($path_parts[ 'filename' ] == "blog") {
            print ' activePage ';
        }
        print '">';
        print'<a href="blog.php">Blog</a>';
        print'</li>';
        ?>
    </ol>
</nav>
<!-- ######################    End of Nav   ########################## -->
