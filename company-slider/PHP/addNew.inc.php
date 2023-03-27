 <form method="post">


     <input type="hidden" id="jstokenCSRF" name="tokenCSRF" value="<?php echo $tokenCSRF; ?>">

     <h3 style="margin:0;padding:0;">Add New CompanySlider</h3>
     <input type="text" name="title" placeholder="title without spacebar" pattern="[a-zA-Z0-9]+" <?php if (isset($_GET['edit'])) {
                                                                                                        echo 'value="' . $_GET['edit'] . '"';
                                                                                                    }; ?>>

     <button class="btn btn-add addNew">Add New</button>
     <a href="<?php echo DOMAIN_ADMIN; ?>/plugin/companycarousel" class="btn btn-migrate">Back to List</a>



     <?php

        if (isset($_GET['edit'])) {

            $js = file_get_contents($this->phpPath() . 'sliderlist/' . $_GET['edit'] . '.json');
            $con = json_decode($js, true);
        };; ?>



     <div style="border:solid 1px #ddd;padding:10px;margin-top:20px;">
         <button class="btn btn-migrate showsettings"> Show/Hide Settings (input required)</button>
     </div>


     <div class="settings config">



         <p style="margin:0;padding:0">Logo width: </p>
         <input type="text" required name="width" <?php if (isset($_GET['edit'])) {
                                                        echo 'value="' . $con['settings'][0]['width'] . '"';
                                                    }; ?>>

         <p style="margin:0;padding:0">Logo height: </p>
         <input type="text" required name="height" <?php if (isset($_GET['edit'])) {
                                                        echo 'value="' . $con['settings'][1]['height'] . '"';
                                                    }; ?>>


         <p style="margin:0;padding:0">Logo fit: </p>
         <select name="logofit" required>
             <option value="contain" <?php if (isset($_GET['edit'])) {
                                            echo ($con['settings'][2]['logofit'] == 'contain' ? "selected" : '');
                                        }; ?>>contain</option>
             <option value="cover" <?php if (isset($_GET['edit'])) {
                                        echo ($con['settings'][2]['logofit'] == 'cover' ? "selected" : '');
                                    }; ?>>cover</option>
         </select>


         <p style="margin:0;padding:0">Slides to show: </p>
         <input type="text" name="slidetoshow" required placeholder="3" <?php if (isset($_GET['edit'])) {
                                                                            echo 'value="' . $con['settings'][3]['slidetoshow'] . '"';
                                                                        }; ?>>


         <p style="margin:0;padding:0">Slides to scroll: </p>
         <input type="text" required name="slidestoscroll" placeholder="1" <?php if (isset($_GET['edit'])) {
                                                                                echo 'value="' . $con['settings'][4]['slidestoscroll'] . '"';
                                                                            }; ?>>

         <p style="margin:0;padding:0">Autoplay: </p>
         <select name="autoplay" required>
             <option value="true" <?php if (isset($_GET['edit'])) {
                                        echo ($con['settings'][5]['autoplay'] == 'true' ? 'selected' : '');
                                    }; ?>>true</option>
             <option value="false" <?php if (isset($_GET['edit'])) {
                                        echo ($con['settings'][5]['autoplay'] == 'false' ? 'selected' : '');
                                    }; ?>>false</option>
         </select>


         <p style="margin:0;padding:0">Autoplay speed: </p>
         <input type="text" required name="autoplayspeed" placeholder="20000" <?php if (isset($_GET['edit'])) {
                                                                                    echo 'value="' . $con['settings'][6]['autoplayspeed'] . '"';
                                                                                }; ?>>



         <p style="margin:0;padding:0">Dots: </p>
         <select name="dots" required>
             <option value="true" <?php if (isset($_GET['edit'])) {
                                        echo ($con['settings'][7]['dots'] == 'true' ? 'selected' : '');
                                    }; ?>>true</option>
             <option value="false" <?php if (isset($_GET['edit'])) {
                                        echo ($con['settings'][7]['dots'] == 'false' ? 'selected' : '');
                                    }; ?>>false</option>
         </select>



         <p style="margin:0;padding:0">Fade:(logo faded, not carousel - great for sidebar) </p>
         <select name="fade" required>
             <option value="true" <?php if (isset($_GET['edit'])) {
                                        echo ($con['settings'][8]['fade'] == 'true' ? 'selected' : '');
                                    }; ?>>true</option>
             <option value="false" <?php if (isset($_GET['edit'])) {
                                        echo ($con['settings'][8]['fade'] == 'false' ? 'selected' : '');
                                    }; ?>>false</option>
         </select>


         <p style="margin:0;padding:0">Arrows: </p>
         <select name="arrows" required>
             <option value="true" <?php if (isset($_GET['edit'])) {
                                        echo ($con['settings'][9]['arrows'] == 'true' ? 'selected' : '');
                                    }; ?>>true</option>
             <option value="false" <?php if (isset($_GET['edit'])) {
                                        echo ($con['settings'][9]['arrows'] == 'false' ? 'selected' : '');
                                    }; ?>>false</option>
         </select>

     </div>




     <div class="imagelist" style="margin-top:10px;" id="sortable">

         <?php
            if (isset($_GET['edit'])) {

                $name = $_GET['edit'];

                $file = file_get_contents($this->phpPath(). 'sliderlist/' . $name . '.json');
                $js = json_decode($file, true);

                foreach ($js['logos'] as $value) {

                    echo '<span class="monsterspan"> 
            <button class="closeThis" onclick="event.preventDefault();this.parentElement.remove()">X</button>
            <img src="' . $value . '" >
             <input type="text" name="image[]" value = "' . $value . '" >
            </span>
             ';
                }
            }; ?>
     </div>


     <input type="submit" name="createFile" class="btn btn-migrate" value="Save CompanySlider" style="width:200px;">
 </form>




 <script>
     document.querySelectorAll('.addNew').forEach((item, index) => {

         item.addEventListener('click', (e) => {
             e.preventDefault();
             e.preventDefault();
             window.open('<?php echo DOMAIN_ADMIN . 'plugin/companycarousel?imagebrowser'; ?>', '', 'width=800,height=600');
         })

     })
 </script>


 <script>
     $(function() {
         $("#sortable").sortable();
     });
 </script>

 <script>
     document.querySelector('.config').classList.toggle('hidethis');

     document.querySelector('.showsettings').addEventListener('click', (x) => {
         x.preventDefault();
         document.querySelector('.config').classList.toggle('hidethis');
     })
 </script>