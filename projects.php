<?php

include "consts.php";
include "website.php";

if (!isset($_GET["p"])){
   header("location: " . INDEX_URL);
}

$entries = parseProjectFile(PROJECTS_FILE);

foreach ($entries as $e)
{
   if ($e->id == $_GET["p"])
   {
      $entry = $e;
   }
}

if (!isset($entry))
{
   header("location: " . INDEX_URL);
}

?>
<!doctype html>
<html>
<head>
   <title>Ludogenesis</title>
   <link rel="stylesheet" href="style.css"/>
   <script type="text/javascript" src="jquery-1.4.1.min.js"></script>
</head>

<body>
   <h1><a class="nolink" href="index.php">Marek Kapolka</a></h1>
   <ul class="header">
      <li><a href="mailto:marek.kapolka@gmail.com">Contact</a></li>
   </ul>
   <div class="main_content">
      <h2><?echo $entry->name; ?></h2>
      <a href="<?php echo INDEX_URL; ?>"><h3>< Projects</h3></a>
      <div style="text-align: center">
         <div class="dark-box project-content image-content">
            <?php
            //Add the screenshots
            foreach ($entry->screenshots as $image)
            {
               ?>
                  <img src="<?php echo $image; ?>"/>
               <?php
            }
            ?>
         </div>
      </div>
      <div class="project-content text-content">
         <div style="text-align: center">
         <?php
         //Print download links
            foreach ($entry->links as $link)
            {
               ?>
                  <a href="<? echo $link->href; ?>"><div class="dark-box play-button"><?php echo $link->description; ?></div></a>
               <?php
            }
         ?>
         </div>
         <div class="body">
            <?php echo $entry->description; ?> 
         </div>
      </div>

   </div>
</body>
</html>
