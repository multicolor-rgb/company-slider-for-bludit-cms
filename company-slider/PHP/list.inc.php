<h3>CompanySlider List item</h3>



<div class="col-md-12 py-2 px-0 mb-2">
    <a href="<?php echo DOMAIN_ADMIN. 'plugin/companycarousel?addnew'; ?>" class="btn btn-add">Add New</a>
    <a href="<?php echo DOMAIN_ADMIN. 'plugin/companycarousel?uploader'; ?>" class="btn btn-add">Uploader</a>
    <a href="<?php  echo DOMAIN_ADMIN. 'plugin/companycarousel?migrator'; ?>" class="btn btn-migrate">Migrate Domain</a>
</div>


<ul class="col-md-12 carList">

    <li class="list-item">
        <div class="title">
            Name
        </div>
        <div class="shortcode">
            Shortcode
        </div>
        <div class="list-btn">
            Edit
        </div>
    </li>


    <?php

    foreach (glob($this->phpPath() . '/sliderlist/*.json') as $item) {

        $name = pathinfo($item)['filename'];

        echo '<li class="list-item">
<div class="title">
<b>' . $name . '</b>
</div>

<div class="shortcode">

<code style="text-align:center;"> <b>Tinymce:</b> [% company=' . $name . ' %] <br> <b>Template</b> &#60;?php showCompanySlider("' . $name . '");?&#62;
</code>
</div>

<div class="list-btn">
<a href="' . DOMAIN_ADMIN. 'plugin/companycarousel?edit=' . $name . '" class="btn btn-edit">Edit</a>
<a href="' . DOMAIN_ADMIN. 'plugin/companycarousel?delete=' . $name . '" onclick="return confirm(`Are you sure you want to delete this item?`);"  class="btn btn-del">Delete</a>
</div>
</li>';
    }; ?>


</ul>