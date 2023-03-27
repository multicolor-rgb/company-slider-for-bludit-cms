<?php

class companyCarousel extends Plugin
{

    public function adminController()
    {



        $ds   = DIRECTORY_SEPARATOR;

        $storeFolder = PATH_UPLOADS . 'company-slider/';
        $chmod = 0755;


        if (!file_exists($storeFolder)) {

            mkdir($storeFolder, $chmod, true);
        };


        if (isset($_POST['changeURL'])) {

            foreach (glob($this->phpPath() . 'sliderlist/*.json') as $file) {
                $fileContent = file_get_contents($file);
                $oldurl = str_replace('/', '\/', $_POST['oldurl']);
                $newurl = str_replace('/', '\/', $_POST['newurl']);
                $newContent = str_replace([$oldurl, $oldurl . '/'], [$newurl, $newurl . '/'], $fileContent);
                file_put_contents($file, $newContent);
            }
            echo '<div class="alert-carcreator">done!</div>';
        }


        if (!empty($_FILES)) {

            $tempFile = $_FILES['file']['tmp_name'];
            $targetPath =    $storeFolder;

            $names = $_FILES['file']['name'];
            $noSpaceName = str_replace(' ', '-', pathinfo($_FILES['file']['name'])['filename']);
            $newName = preg_replace('/[^0-9a-zA-Z-]+/', '', $noSpaceName);

            $targetFile =  $targetPath . $newName . '.' . pathinfo($_FILES['file']['name'])['extension'];
            move_uploaded_file($tempFile, $targetFile);
        };



        if (isset($_POST['delthisimage'])) {

            $imgs = $_POST['delphoto'];

            foreach ($imgs as $items) {
                unlink(PATH_UPLOADS . 'company-slider/' . $items);
            };
        };

        if (isset($_GET['delete'])) {
            unlink($this->phpPath() . 'sliderlist/' . $_GET['delete'] . '.json');
            echo '<script>window.location.replace("' . DOMAIN_ADMIN . 'plugin/companycarousel");</script>';
        };



        if (isset($_POST['createFile'])) {
            $logoList = array();
            $logoList['logos'] = [];
            $logoList['settings'] = [];
            $logos = $_POST['image'];
            $width = $_POST['width'];
            $height = $_POST['height'];
            $logofit = $_POST['logofit'];
            $slidetoshow = $_POST['slidetoshow'];
            $slidestoscroll = $_POST['slidestoscroll'];
            $autoplay = $_POST['autoplay'];
            $autoplayspeed = $_POST['autoplayspeed'];
            $dots = $_POST['dots'];
            $fade = $_POST['fade'];
            $arrows = $_POST['arrows'];

            array_push($logoList['settings'], array('width' => $width));
            array_push($logoList['settings'], array('height' => $height));
            array_push($logoList['settings'], array('logofit' => $logofit));
            array_push($logoList['settings'], array('slidetoshow' => $slidetoshow));
            array_push($logoList['settings'], array('slidestoscroll' => $slidestoscroll));
            array_push($logoList['settings'], array('autoplay' => $autoplay));
            array_push($logoList['settings'], array('autoplayspeed' => $autoplayspeed));
            array_push($logoList['settings'], array('dots' => $dots));
            array_push($logoList['settings'], array('fade' => $fade));
            array_push($logoList['settings'], array('arrows' => $arrows));


            foreach ($logos as $key => $value) {
                array_push($logoList['logos'], $logos[$key]);
                $jser = json_encode($logoList, true);
                file_put_contents($this->phpPath() . 'sliderlist/' . @$_POST['title'] . '.json', $jser);
            };

            echo '<script>window.location.replace("' . DOMAIN_ADMIN . 'plugin/companycarousel?edit=' . $_POST['title'] . '");</script>';
        };
    }

    public function adminView()
    {



        echo '<style>@import url("' . DOMAIN_BASE . 'bl-plugins/company-slider/css/backend.css");</style>';

        echo '<div class="carCreator">';
        // Token for send forms in Bludit
        global $security;
        $tokenCSRF = $security->getTokenCSRF();

        // Current site title
        global $site;

        $title = $site->title();

        echo '<div class="carCreator">';

        if (isset($_GET['addnew']) || isset($_GET['edit'])) {
            include $this->phpPath() . 'PHP/addNew.inc.php';
        } elseif (isset($_GET['migrator'])) {
            include $this->phpPath() . 'PHP/migrate.inc.php';
        } elseif (isset($_GET['uploader'])) {
            include $this->phpPath() . 'PHP/uploader.inc.php';
        } elseif (isset($_GET['editfile'])) {
            include $this->phpPath() . 'PHP/filebrowser.inc.php';
        } elseif (isset($_GET['imagebrowser'])) {
            include $this->phpPath() . 'PHP/imagebrowser.inc.php';
        } else {
            include $this->phpPath() . 'PHP/list.inc.php';
        }

        echo '<div class="sponsor">
    <p class="lead">Buy me ☕ if you want to see new plugins :) </p>
    <a href="https://www.paypal.com/donate/?hosted_button_id=TW6PXVCTM5A72">
    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif"  />
    </a>
    </div>
    ';
        echo '</div>';
    }


    public function siteHead()
    {

        echo '<link rel="stylesheet" href="' . DOMAIN_BASE . 'bl-plugins/company-slider/css/slick.css">';
        echo '<link rel="stylesheet" href="' . DOMAIN_BASE . 'bl-plugins/company-slider/css/slick-theme.css">';
    }


    public function adminSidebar()
    {
        $pluginName = Text::lowercase(__CLASS__);
        $url = HTML_PATH_ADMIN_ROOT . 'plugin/' . $pluginName;
        $html = '<a id="current-version" class="nav-link" href="' . $url . '">👨🏻‍💼 Company Slider</a>';
        return $html;
    }



    public function pageBegin()
    {


        global $page;

        $newcontent = preg_replace_callback(
            '/\\[% company=(.*) %\\]/i',
            'runCompanyShortcode',
            $page->content()
        );


        global $page;
        $page->setField('content', $newcontent);
    }
};



function runCompanyShortcode($matches)
{

    $cars = new CompanyCarousel();

    $name = $matches[1];

    $file = file_get_contents($cars->phpPath() . 'sliderlist/' . $name . '.json');
    $js = json_decode($file, true);


    $sponsor = '';

    $sponsor .= "<div class='" . $name . "' style='width:98%;margin:0 auto;'>";


    foreach ($js['logos'] as $value) {

        $sponsor .= '<div><img src="' . $value . '" style="display:block;margin:0 auto;width:' . $js['settings'][0]['width'] . ';height:' . $js['settings'][1]['height'] . ';object-fit:' . $js['settings'][2]['logofit'] . '"/></div>';
    }


    $sponsor .= "</div>";


    $sponsor .= '<script src="' . DOMAIN_BASE . 'bl-plugins/company-slider/js/jquery-3.6.4.min.js"></script>';
    $sponsor .= '<script src="' . DOMAIN_BASE . 'bl-plugins/company-slider/js/slick.min.js"></script>';


    $sponsor .=  "
        
        <script>

         $('." . $name . "').slick({
            slidesToShow: " . $js['settings'][3]['slidetoshow'] . ",
            slidesToScroll: " . $js['settings'][4]['slidestoscroll'] . ",
            autoplay: " . $js['settings'][5]['autoplay'] . ",
            autoplaySpeed: " . $js['settings'][6]['autoplayspeed'] . ",
            dots:" . $js['settings'][7]['dots'] . ",
            fade:" . $js['settings'][8]['fade'] . "
          });

        </script>

        ";

    return $sponsor;
};

function showCompanySlider($name)
{

    $cars = new CompanyCarousel();

    $file = file_get_contents($cars->phpPath() . 'sliderlist/' . $name . '.json');
    $js = json_decode($file, true);



    echo "<div class='" . $name . " ' style='width:90%;margin:0 auto; '>";


    foreach ($js['logos'] as $value) {

        echo '<div><img src="' . $value . '" style="display:block;margin:0 auto;width:' . $js['settings'][0]['width'] . ';height:' . $js['settings'][1]['height'] . ';object-fit:' . $js['settings'][2]['logofit'] . '"/></div>';
    }


    echo "</div>";


    echo '<script src="' . DOMAIN_BASE . 'bl-plugins/company-slider/js/jquery-3.6.4.min.js"></script>';
    echo '<script src="' . DOMAIN_BASE . 'bl-plugins/company-slider/js/slick.min.js"></script>';


    echo "
    
    <script>



        $('." . $name . "').slick({
            slidesToShow: " . $js['settings'][3]['slidetoshow'] . ",
            slidesToScroll: " . $js['settings'][4]['slidestoscroll'] . ",
            autoplay: " . $js['settings'][5]['autoplay'] . ",
            autoplaySpeed: " . $js['settings'][6]['autoplayspeed'] . ",
            dots:" . $js['settings'][7]['dots'] . ",
            fade:" . $js['settings'][8]['fade'] . ",
            arrows:" . $js['settings'][9]['arrows'] . ",
            infinite: true,
            adaptiveHeight:true,

            responsive: [

                {
                    breakpoint: 480,
                    settings: {
                      slidesToShow: 1,
                      slidesToScroll: 1,
                      fade:true,
                      dots:false,
                      arrows:true,
                      infinite: true,

                    }
                  }
               
    
               
              ]
          });
 
    </script>

    ";
}

;
