<?php

class FileHandler
{
    public $location;
    public $rootPath;
    public $fullPath;
    public $ext;
    public $name;

    public function __construct(string $location, $rootPath = '/var/www/html')
    {
        try {

            if (!file_exists($rootPath . $location) && !is_dir($rootPath . $location))
                throw new Exception('Path either does not exist or your path is not a directory.');

            $this->rootPath = $rootPath;
            $this->location = $location;
            $this->fullPath = $this->rootPath . $this->location;
            $this->name = basename($location);
            if (is_dir($this->fullPath)) {
                $this->ext = 'dir';
            } else if (is_file($this->fullPath)) {
                $this->ext = 'file';
            }
        } catch (Exception $e) {

            throw new Exception($e->getMessage());
        }
    }


    public function retrieveContent()
    {
        $contents = scandir($this->fullPath);

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

            if (is_dir($this->rootPath . $contInfo['fullPath'])) {
                $contInfo['type'] = 'dir';
            } else if (is_file($this->rootPath . $contInfo['fullPath'])) {
                $contInfo['type'] = 'file';
            }

            $contInfo['ext'] = pathinfo($content, PATHINFO_EXTENSION);

            array_push($contentInfo, $contInfo);
        }

        return $contentInfo;
    }
    public function htmlRow($type, $target, $name)
    {
        $htmlContent = '';
        if ($type == 'dir') {
            $htmlContent = '<tr data-parent="' . $this->location . '" data-src="' . $target . '" data-location="' . $target . '" draggable="true"><td><div class="stuff-items" data-type="dir" class="open-row"><div class="arrow closed-folder"></div><div class="narrow"><a href="index.php?target=' . $target .  '&view=folder" class="folder-icon"></a></div><div><a href="index.php?target=' . $target . '&view=folder">' . $name  . '</a></div></div></td></tr>';

            // echo '<tr data-parent="' . $this->location . '" data-src="' . $target . '" data-location="' . $target . '" draggable="true"><td><div class="stuff-items" data-type="dir" class="open-row">
            // <div class="arrow closed-folder"></div><div class="narrow">';
            // echo '<a href="index.php?target=' . $target .  '&view=folder" class="folder-icon">';
            // echo '</a></div><div>';
            // echo '<a href="index.php?target=' . $target . '&view=folder">';
            // echo $name  . '</a>' . '</div></div></td></tr>';
            // folder_view($target . '/' . $i);
        }
        //check for pdf
        elseif ($type == 'pdf') {
            // echo '<tr data-parent="' . $this->location . '" data-src="' . $target . '" draggable="true"><td><div class="stuff-items"><div class="arrow"></div><div class="narrow" >';
            // echo '<a href="' . $target . '" target="_blank">';
            // echo '<img src="/policy-code/images/pdf-icon.png" class="folder" title="View PDF"></a>';
            // echo '</div><div>';
            // echo '<a href="' . $target .  '?target=' . $target .  '" target="_blank">';
            // echo $name  . '</a>';
            // echo '</div></div></td></tr>';
            $htmlContent = '<tr data-parent="' . $this->location . '" data-src="' . $target . '" draggable="true"><td><div class="stuff-items"><div class="arrow"></div><div class="narrow" ><a href="' . $target . '" target="_blank"><img src="/policy-code/images/pdf-icon.png" class="folder" title="View PDF"></a></div><div><a href="' . $target .  '?target=' . $target .  '" target="_blank">' . $name  . '</a></div></div></td></tr>';
        }

        //test for webarchive
        elseif ($type == 'webarchive') {
            // echo '<tr data-parent="' . $this->location . '" data-src="' . $target . '" draggable="true"><td><div class="stuff-items"><div class="arrow"></div><div class="narrow" >';
            // echo '<a href="' . $target . '" download>';
            // echo '<img src="/policy-code/images/file.png" class="folder" title="Download Web Archive"></a>';
            // echo '</div><div>';
            // echo '<a href="' . $target . '" download>';
            // echo $name  . ' <span class="download">- (Download)</span></a>';
            // echo '</div></div></td></tr>';
            $htmlContent = '<tr data-parent="' . $this->location . '" data-src="' . $target . '" draggable="true"><td><div class="stuff-items"><div class="arrow"></div><div class="narrow" ><a href="' . $target . '" download><img src="/policy-code/images/file.png" class="folder" title="Download Web Archive"></a></div><div><a href="' . $target . '" download>' . $name  . ' <span class="download">- (Download)</span></a></div></div></td></tr>';
        }

        //test for pages, numbers, xls
        elseif ($type == 'pages'  || $type  == 'numbers' || $type == 'xls') {
            // echo '<tr data-parent="' . $this->location . '" data-src="' . $target . '" draggable="true"><td><div class="stuff-items"><div class="arrow"></div><div class="narrow" >';
            // echo '<a href="' . $target . '" download>';
            // echo '<img src="/policy-code/images/file.png" class="folder" title="Download File"></a>';
            // echo '</div><div>';
            // echo '<a href="' . $target . '" download>';
            // echo $name  . ' <span class="download">- (Download)</span></a>';
            // echo '</div></div></td></tr>';
            $htmlContent = '<tr data-parent="' . $this->location . '" data-src="' . $target . '" draggable="true"><td><div class="stuff-items"><div class="arrow"></div><div class="narrow" ><a href="' . $target . '" download><img src="/policy-code/images/file.png" class="folder" title="Download File"></a></div><div><a href="' . $target . '" download>' . $name  . ' <span class="download">- (Download)</span></a></div></div></td></tr>';
        }

        //test for image files and build appropriate anchor
        elseif ($type == 'png' || $type == 'jpg') {
            // echo '<tr data-parent="' . $this->location . '" data-src="' . $target . '" draggable="true"><td><div class="stuff-items"><div class="arrow"></div><div class="narrow">';
            // echo '<a href="' . $target . '" target="_blank">';
            // echo '<img src="/policy-code/images/image-icon.png" class="folder" title="View Image"></a>';
            // echo '</div><div>';
            // echo '<a href="' . $target . '?target=' . $target  . '" target="_blank">';
            // echo $name  . '</a>';
            // echo '</div></div></td></tr>';
            $htmlContent = '<tr data-parent="' . $this->location . '" data-src="' . $target . '" draggable="true"><td><div class="stuff-items"><div class="arrow"></div><div class="narrow"><a href="' . $target . '" target="_blank"><img src="/policy-code/images/image-icon.png" class="folder" title="View Image"></a></div><div><a href="' . $target . '?target=' . $target  . '" target="_blank">' . $name  . '</a></div></div></td></tr>';
        }
        //test for php files and list everything but .php
        elseif ($type != 'php') {
            // echo '<tr data-parent="' . $this->location . '" data-src="' . $target . '" draggable="true">
            // <td>
            // <div class="stuff-items">
            // <div class="arrow"></div>
            // <div class="narrow" >';
            // echo '<a href="index.php?target=' . $target . '&view=file' . '">' . '<img src="/policy-code/images/file.png" class="folder"></a></div><div>';
            // echo '<a href="index.php?target=' . $target . '&view=file' . '">' . $name . '</a></div></div></td></tr>' . "\n\n";
            $htmlContent = '<tr data-parent="' . $this->location . '" data-src="' . $target . '" draggable="true"><td><div class="stuff-items"><div class="arrow"></div><div class="narrow" ><a href="index.php?target=' . $target . '&view=file' . '"><img src="/policy-code/images/file.png" class="folder"></a></div><div><a href="index.php?target=' . $target . '&view=file' . '">' . $name . '</a></div></div></td></tr>' . "\n\n";
        }

        return $htmlContent;
    }
    public function buildRows()
    {
        foreach ($this->retrieveContent() as $i) {
            $target = $i['fullPath'];
            echo $this->htmlRow($i['type'], $target, $i['name']);
        }
    }
}


// $handler = new FileHandler('/stuff/');
// $content = $handler->retrieveContent();
// echo json_encode($content);
// print_r($content);
