<?php

class ResourceHtml
{
    public static function __callStatic($method, $args)
    {
        // Check if the method exists, and if not, call the default method
        if (method_exists(__CLASS__, $method)) {
            // If the method exists, call it
            return call_user_func_array([__CLASS__, $method], $args);
        } else {
            // If the method doesn't exist, call the default method
            return self::file($args[0], $args[1], $args[2]);
        }
    }




    static public function Directorytitle($user, $home, $baseName, $displayBack = false, $dispalyModals = false)
    {
        function backButton()
        {
            return <<<"EOL"
                <img onclick="history.back()" src="./.policy-code/images/back-icon-35.png" class="scale-with-grid" title="Go Back">
                <a href="index.php">
                <img src="./.policy-code/images/home-folder-icon-35.png" class="scale-with-grid" style="border: none;" title="Home">
                </a>
            EOL;
        }
        function modals($baseName)
        {
            return <<<"EOL"
                <div class="adding-files">
                <div class="file-button" id="file-button" title="New Text File inside $baseName">
                <img src="./.policy-code/images/new-file-icon-white.png">
                </div>
                <div class="file-button" id="folder-button" title="New Folder inside $baseName">
                <img src="./.policy-code/images/new-folder-icon.png">
                </div>
                <div class="file-button" id="upload-files-button" title="Upload Files into $baseName">
                <img src="./.policy-code/images/upload-file-icon.png"></div>
                </div>
                EOL;
        }

        $setModals = (!$dispalyModals) ? '' : modals($baseName);
        $setBack = ($displayBack) ? '' : backButton();
        echo <<<"EOL"
                <div class="title">
                    <div class="two-thirds column" style="display:flex;align-items:center;justify-content: space-around;">
                    {$setBack}
                    
                    <span class="titleText">$user $baseName</span> 
                        
                       {$setModals}
                </div>
                <div class="one-third column">
                
                
                
                EOL;
        echo '</div>
        <div class="one-third column">';

        include($_SERVER['DOCUMENT_ROOT'] . $home . '/.policy-code/modals/search.php');

        echo '</div>
        </div>';
    }

    static function empty($parent, $path, $baseName)
    {

        $htmlContent = '<tr data-empty data-type="file" data-parent="' . $parent . '" data-src="' . $path . '" draggable="true">
        <td>
        <div class="stuff-items">
        <div class="arrow"></div>
        <div class="narrow" >
        <span>
            
        </span>
        </div>
        <div>
        <span>' . $baseName . '</span>
        </div>
        </div>
        </td>
        </tr>' . "\n\n";

        return $htmlContent;
    }
    static function file($parent, $path, $baseName)
    {

        $htmlContent = '<tr data-type="file" data-parent="' . $parent . '" data-src="' . $path . '" draggable="true">
        <td>
        <div class="stuff-items">
        <div class="arrow"></div>
        <div class="narrow" >
        <a href="index.php?target=' . $path . '&view=file' . '">
        <img src="./.policy-code/images/file.png" class="folder"></a></div>
        <div>
        <a href="index.php?target=' . $path . '&view=file' . '">' . $baseName . '</a>
        </div>
        </div>
        </td>
        </tr>' . "\n\n";

        return $htmlContent;
    }
    static function txt($parent, $path, $baseName)
    {
        return self::file($parent, $path, $baseName);
    }


    static function sh($parent, $path, $baseName)
    {
        return self::file($parent, $path, $baseName);
    }
    static function directory($parent, $path, $baseName)
    {
        $htmlContent = '<tr data-type="dir" data-parent="' . $parent . '" data-src="' . $path . '" data-location="' . $path . '" draggable="true">
        <td>
        <div class="stuff-items" data-type="dir" class="open-row">
        <div class="arrow closed-folder">
        </div>
        <div class="narrow">
        <a href="index.php?target=' . $path . '&view=folder" class="folder-icon">
        </a>
        </div>
        <div>
        <a href="index.php?target=' . $path . '&view=folder">' . $baseName . '</a>
        </div>
        </div>
        </td>
        </tr>';
        return $htmlContent;
    }
    static function pdf($parent, $path, $baseName)
    {
        $target = preg_replace('/#/', '%23', $path);
        $htmlContent = '<tr data-type="file" data-parent="' . $parent . '" data-src="' . $target . '" draggable="true">
            <td>
            <div class="stuff-items">
            <div class="arrow">
            </div>
            <div class="narrow" >
            <a href="' . $target . '" target="_blank">
            <img src="./.policy-code/images/pdf-icon.png" class="folder" title="View PDF">
            </a>
            </div>
            <div>
            <a href="' . $target . '?target=' . $target . '" target="_blank">' . $baseName . '</a>
            </div>
            </div>
            </td>
            </tr>';
        return $htmlContent;
    }
    static function image($parent, $path, $baseName)
    {
        $htmlContent = '<tr data-type="file" data-parent="' . $parent . '" data-src="' . $path . '" draggable="true">
            <td>
            <div class="stuff-items">
            <div class="arrow">
            </div><div class="narrow"><a href="' . $path . '" target="_blank">
            <img src="./.policy-code/images/image-icon.png" class="folder" title="View Image">
            </a>
            </div>
            <div>
            <a href="' . $path . '?target=' . $path . '" target="_blank">' . $baseName . '</a>
            </div>
            </div>
            </td>
            </tr>';
        return $htmlContent;
    }
    static function Misc($parent, $path, $baseName)
    {
        $htmlContent = '<tr data-type="file" data-parent="' . $parent . '" data-src="' . $path . '" draggable="true">
            <td>
            <div class="stuff-items">
            <div class="arrow">
            </div>
            <div class="narrow" >
            <a href="' . $path . '" download>
            <img src="./.policy-code/images/file.png" class="folder" title="Download File">
            </a>
            </div>
            <div>
            <a href="' . $path . '" download>' . $baseName . ' <span class="download">- (Download)</span></a></div></div></td></tr>';
        return $htmlContent;
    }
    static function png($parent, $path, $baseName)
    {
        return self::image($parent, $path, $baseName);
    }
    static function gif($parent, $path, $baseName)
    {
        return self::image($parent, $path, $baseName);
    }
    static function jpeg($parent, $path, $baseName)
    {
        return self::image($parent, $path, $baseName);
    }
    static function jpg($parent, $path, $baseName)
    {
        return self::image($parent, $path, $baseName);
    }

    static function pages($parent, $path, $baseName)
    {
        return self::Misc($parent, $path, $baseName);
    }

    static function numbers($parent, $path, $baseName)
    {
        return self::Misc($parent, $path, $baseName);
    }
    static function xls($parent, $path, $baseName)
    {
        return self::Misc($parent, $path, $baseName);
    }
    static function webarchive($parent, $path, $baseName)
    {
        return self::Misc($parent, $path, $baseName);
    }
}
