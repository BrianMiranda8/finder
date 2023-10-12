<?php
//what to do if target is a folder
function folder_view($target)
{
    // $loop = 0;

//page header is not a function called tite_view.php
    //end of page header

    $item = scandir($target);
    // echo "<table>";
    foreach ($item as $i) {

        if ($i[0] != '.') {

            if (is_dir($target . '/' . $i)) {
                echo '<tr data-src="' . $target . '" data-location="' . $target . "/" . $i . '" draggable="true"><td><div class="stuff-items" data-type="dir"><div class="arrow closed-folder"></div><div class="narrow">';
                echo '<a href="index.php?target=' . $target . '/' . $i . '&view=folder" class="folder-icon">';
                echo '</a></div><div>';
                echo '<a href="index.php?target=' . $target . '/' . $i . '&view=folder">';
                echo $i . '</a>' . '</div></div></td></tr>' . "\n\n";
                folder_view($target . '/' . $i);
            }
            //check for pdf
            elseif (stripos($i, '.pdf') == true) {
                echo '<tr data-src="' . $target . '" draggable="true"><td><div class="stuff-items"><div class="arrow"></div><div class="narrow" >';
                echo '<a href="' . $target . '/' . $i . '" target="_blank">';
                echo '<img src="/policy-code/images/pdf-icon.png" class="folder" title="View PDF"></a>';
                echo '</div><div>';
                echo '<a href="' . $target . '/' . $i . '?target=' . $target . '/' . $i . '" target="_blank">';
                echo $i . '</a>';
                echo '</div></div></td></tr>';
            }

            //test for webarchive
            elseif (stripos($i, '.webarchive') == true) {
                echo '<tr data-src="' . $target . '" draggable="true"><td><div class="stuff-items"><div class="arrow"></div><div class="narrow" >';
                echo '<a href="' . $target . '/' . $i . '" download>';
                echo '<img src="/policy-code/images/file.png" class="folder" title="Download Web Archive"></a>';
                echo '</div><div>';
                echo '<a href="' . $target . '/' . $i . '" download>';
                echo $i . ' <span class="download">- (Download)</span></a>';
                echo '</div></div></td></tr>';
            }

            //test for pages, numbers, xls
            elseif (stripos($i, '.pages') == true || stripos($i, '.numbers') == true || stripos($i, '.xls') == true) {
                echo '<tr data-src="' . $target . '" draggable="true"><td><div class="stuff-items"><div class="arrow"></div><div class="narrow" >';
                echo '<a href="' . $target . '/' . $i . '" download>';
                echo '<img src="/policy-code/images/file.png" class="folder" title="Download File"></a>';
                echo '</div><div>';
                echo '<a href="' . $target . '/' . $i . '" download>';
                echo $i . ' <span class="download">- (Download)</span></a>';
                echo '</div></div></td></tr>';
            }

            //test for image files and build appropriate anchor
            elseif (stripos($i, '.png') == true || stripos($i, '.jpg') == true) {
                echo '<tr data-src="' . $target . '" draggable="true"><td><div class="stuff-items"><div class="arrow"></div><div class="narrow">';
                echo '<a href="' . $target . '/' . $i . '" target="_blank">';
                echo '<img src="/policy-code/images/image-icon.png" class="folder" title="View Image"></a>';
                echo '</div><div>';
                echo '<a href="' . $target . '/' . $i . '?target=' . $target . '/' . $i . '" target="_blank">';
                echo $i . '</a>';
                echo '</div></div></td></tr>';
            }
            //test for php files and list everything but .php
            elseif (strpos($i, '.php') == false) {
                echo '<tr data-src="' . $target . '" draggable="true"><td><div class="stuff-items"><div class="arrow"></div><div class="narrow" >';
                echo '<a href="index.php?target=' . $target . '/' . $i . '&view=file' . '">' . '<img src="/policy-code/images/file.png" class="folder"></a></div><div>';
                echo '<a href="index.php?target=' . $target . '/' . $i . '&view=file' . '">' . $i . '</a></div></div></td></tr>' . "\n\n";
            }
        }
    }
}
//end of folder_view function
