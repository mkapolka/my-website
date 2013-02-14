<?php
include "website.php";
include "consts.php";
//Initialize the Projects file
$entries = parseProjectFile(PROJECTS_FILE);
?>

<!doctype html>
      <?php 
         printHeader();
      ?>
      <h2>Projects</h2>
      <ul class="games_big">
         <?php
            foreach ($entries as $entry)
            {
               //Big Entries
               if ($entry->big)
               {
                  ?>
                     <a href="<?php echo PROJECTS_URL . "?p=" . $entry->id; ?>">
                        <li class="dark-box big">
                           <div class="container">
                              <img src="<?php echo $entry->thumbnail; ?>"/>
                              <video>
                                 <?php
                                    foreach ($entry->videos as $video)
                                    {
                                       ?>
                                          <source src="<?php echo $video; ?>">
                                       <?php
                                    }
                                 ?>
                              </video>
                              <div class="caption-container">
                                 <div class="caption"><?php echo $entry->name ?></div>
                              </div>
                           </div>
                        </li>
                     </a>
                  <?php
               } else {
                  //small box
                  ?>
                     <a href="<?php echo PROJECTS_URL . "?p=" . $entry->id; ?>">
                        <li class="dark-box small">
                           <div class="container" style="background:url('<?php echo $entry->thumbnail; ?>');">
                              <!--<img src="<?php echo $entry->thumbnail; ?>"/>-->
                              <div class="caption-container">
                                 <div class="caption"><?php echo $entry->name; ?></div>
                              </div>
                           </div>
                        </li>
                     </a>
                  <?php
               }
            }
         ?>
      </ul>
   </div>
   <script type="text/javascript">
      $("video").map(function(index, element) {
         element.play();
      });
      $("ul.games_big li.big").hover(
         function() {
            var video = $(this).find("video");
            //video.show();
            $(this).find("img").hide();

            video[0].play();

            $(this).find(".caption").fadeOut(250);
         },
         function () {
            //$(this).find("video").hide();
            $(this).find("img").show();

            $(this).find("video")[0].pause();
            $(this).find("video")[0].currentTime = 0;

            $(this).find(".caption").fadeIn(150);
         }
      );
   </script>
<?php 
   printFooter();
?>
