<?php

class FileHandler
{
    private $location;
    public $rootPath;
    public function __construct(string $location, $rootPath = '/var/www/html')
    {
        try {

            if (!file_exists($rootPath . $location) && !is_dir($rootPath . $location))
                throw new Exception('Path either does not exist or your path is not a directory.');
            $this->rootPath = $rootPath;
            $this->location = $rootPath . $location;
        } catch (Exception $e) {

            throw new Exception($e->getMessage());
        }
    }


    public function retrieveContent()
    {
        $contents = scandir($this->location);

        $contents = $content = array_diff($contents, array('.', '..'));
        $contentInfo = array();

        foreach ($contents as $content) {
            $contInfo = array(
                'type' => '',
                'fullPath' => '',
                'name' => '',
                'ext' => ''
            );
            $contInfo['fullPath'] = join(DIRECTORY_SEPARATOR, array($this->location, $content));
            $contInfo['name'] = $content;
            if (is_dir($contInfo['fullPath'])) {
                $contInfo['type'] = 'dir';
            } else if (is_file($contInfo['fullPath'])) {
                $contInfo['type'] = 'file';
            }

            $contInfo['ext'] = pathinfo($content, PATHINFO_EXTENSION);

            array_push($contentInfo, $contInfo);
        }

        return $contentInfo;
    }

    public function buildRows()
    {
        foreach ($this->retrieveContent() as $i) {
            $target = $i['fullPath'];


            if ($i['type'] == 'dir') {
                echo '<tr data-src="' . $target . '" data-location="' . $target . '" draggable="true"><td><div class="stuff-items" data-type="dir" class="open-row">
                <div class="arrow closed-folder"></div><div class="narrow">';
                echo '<a href="index.php?target=' . $target .  '&view=folder" class="folder-icon">';
                echo '</a></div><div>';
                echo '<a href="index.php?target=' . $target . '&view=folder">';
                echo $i['name']  . '</a>' . '</div></div></td></tr>';
                // folder_view($target . '/' . $i);
            }
            //check for pdf
            elseif ($i['ext'] == 'pdf') {
                echo '<tr data-src="' . $target . '" draggable="true"><td><div class="stuff-items"><div class="arrow"></div><div class="narrow" >';
                echo '<a href="' . $target . '" target="_blank">';
                echo '<img src="/policy-code/images/pdf-icon.png" class="folder" title="View PDF"></a>';
                echo '</div><div>';
                echo '<a href="' . $target .  '?target=' . $target .  '" target="_blank">';
                echo $i['name']  . '</a>';
                echo '</div></div></td></tr>';
            }

            //test for webarchive
            elseif ($i['ext'] == 'webarchive') {
                echo '<tr data-src="' . $target . '" draggable="true"><td><div class="stuff-items"><div class="arrow"></div><div class="narrow" >';
                echo '<a href="' . $target . '" download>';
                echo '<img src="/policy-code/images/file.png" class="folder" title="Download Web Archive"></a>';
                echo '</div><div>';
                echo '<a href="' . $target . '" download>';
                echo $i['name']  . ' <span class="download">- (Download)</span></a>';
                echo '</div></div></td></tr>';
            }

            //test for pages, numbers, xls
            elseif ($i['ext'] == 'pages'  || $i['ext']  == 'numbers' || $i['ext'] == 'xls') {
                echo '<tr data-src="' . $target . '" draggable="true"><td><div class="stuff-items"><div class="arrow"></div><div class="narrow" >';
                echo '<a href="' . $target . '" download>';
                echo '<img src="/policy-code/images/file.png" class="folder" title="Download File"></a>';
                echo '</div><div>';
                echo '<a href="' . $target . '" download>';
                echo $i['name']  . ' <span class="download">- (Download)</span></a>';
                echo '</div></div></td></tr>';
            }

            //test for image files and build appropriate anchor
            elseif ($i['ext'] == 'png' || $i['ext'] == 'jpg') {
                echo '<tr data-src="' . $target . '" draggable="true"><td><div class="stuff-items"><div class="arrow"></div><div class="narrow">';
                echo '<a href="' . $target . '" target="_blank">';
                echo '<img src="/policy-code/images/image-icon.png" class="folder" title="View Image"></a>';
                echo '</div><div>';
                echo '<a href="' . $target . '?target=' . $target  . '" target="_blank">';
                echo $i['name']  . '</a>';
                echo '</div></div></td></tr>';
            }
            //test for php files and list everything but .php
            elseif ($i['ext'] != 'php') {
                echo '<tr data-src="' . $target . '" draggable="true"><td><div class="stuff-items"><div class="arrow"></div><div class="narrow" >';
                echo '<a href="index.php?target=' . $target . '&view=file' . '">' . '<img src="/policy-code/images/file.png" class="folder"></a></div><div>';
                echo '<a href="index.php?target=' . $target . '&view=file' . '">' . $i['name'] . '</a></div></div></td></tr>' . "\n\n";
            }
        }
    }
}


// $handler = new FileHandler('/stuff/');
// $content = $handler->retrieveContent();
// echo json_encode($content);
// print_r($content);
