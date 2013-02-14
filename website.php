<?php
   //Returns an array of Entry objects representing the different projects
   function parseProjectFile($url)
   {
      $handle = fopen($url, 'r');
      if (!$handle) { return null; }

      $entries = array();

      $entry = new Entry();
      $n_entries = 0;
      while ($line = fgets($handle))
      {
         if ($line == "\n")
         {
            $entries[$n_entries] = $entry;
            $n_entries++;
            $entry = new Entry();
         } else {
            $parts = explode(": ", rtrim($line));

            switch($parts[0])
            {
               case "name":
                  $entry->name = $parts[1];
               break;

               case "big":
                  $entry->big = $parts[1]=="true"?True:False;
               break;

               case "screenshots":
                  $entry->screenshots = explode(", ", $parts[1]);
               break;

               case "video":
                  $entry->videos = explode(", ", $parts[1]);
               break;

               case "description":
               case "description:":
               case "description: ":
                  $desc = "";

                  while (($subline = rtrim(fgets($handle))) != "!description_end" && $subline != "")
                  {
                     $desc = $desc . $subline;
                  }

                  $entry->description = $desc;
               break;

               case "link":
                  $link_parts = explode(" ", $parts[1], 2);
                  $link = new LinkEntry();
                  $link->href = $link_parts[0];
                  $link->description = $link_parts[1];
                  $entry->links[count($entry->links)] = $link;
               break;

               case "id":
                  $entry->id = $parts[1];
               break;

               case "thumbnail":
                  $entry->thumbnail = $parts[1];
               break;
            }
         }
      }

      if ($entry->id != "")
      {
         $entries[$n_entries] = $entry;   
      }

      fclose($handle);
      return $entries;
   }

   function printEntry($entry) {
      echo $entry->name . "<br>";
      echo "Big: " . $entry->big . "\n";

      echo "Screenshots: ";
      foreach ($entry->screenshots as $screenshot)
      {
         echo $screenshot . " ";
      }
      echo "<br>";

      echo "Videos: ";
      foreach ($entry->videos as $video)
      {
         echo $video . " ";
      }
      echo "<br>";

      echo "Links: ";
      foreach ($entry->links as $link)
      {
         echo "href: " . $link->href . " title: " . $link->description . "<br>";
      }
      echo "<br>";
   }

   //Prints the start of the document, including the <head> block as well as the start of the <body>
   function printHeader()
   {
      ?>
         <head>
            <title>Marek Kapolka</title>
            <link rel="stylesheet" href="style.css"/>

            <script type="text/javascript" src="jquery-1.4.1.min.js"></script>
         </head>

         <body>
            <h1><a class="nolink" href="<?php echo INDEX_URL; ?>">Marek Kapolka</a></h1>
            <ul class="header">
               <li><a href="mailto:marek.kapolka@gmail.com">Contact</a></li>|
               <li><a href="resume.pdf">Resume</a></li>|
               <li><a href="http://www.github.com/mkapolka">Github</a></li>
            </ul>
            <div class="main_content">
      <?php
   }

   function printFooter()
   {
?>      
   <div class="footer">(c) Marek Kapolka 2013</div>
   </body>
   </html>
<?php
   printAnalytics();
   } //printFooter()

   function printAnalytics()
   {
      ?>
      <!--Google Analytics-->
      <script type="text/javascript">

      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-38176044-1']);
      _gaq.push(['_trackPageview']);

        (function() {
         var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
         ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
         var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
         })();

       </script>
      <?php
   }

   class Entry {
      public $name;
      public $big = false;
      public $screenshots = array();
      public $videos = array();
      public $links = array();
      public $id = "";
      public $thumbnail = ""; //The image the is used for the card on the index;
      public $description;
   }

   class LinkEntry {
      public $href;
      public $description;
   }
?>
