 <style>
   .sidebar {
     display: none !important;
   }

   .container {
     max-width: unset !important;
     width: 100% !important;
   }

   .col-lg-10 {
     all: unset;
     width: 100% !important;
   }

   .navbar{
    display: none !important;
   }
 </style>

 <?php

  $count = 0;
  foreach (glob(PATH_UPLOADS . 'company-slider/*') as $img) {

    $base = pathinfo($img)['basename'];

    echo '<a href="' . $base . '" class="photo" onclick="event.preventDefault();submitLink(' . $count . ')">
    <img src="' . $base . '" style="width:100px;height:100px;object-fit:cover;margin:10px;"></a>';
    $count++;
  }; ?>


 <script>
   document.querySelectorAll('.photo').forEach(x => {
     x.setAttribute('href', window.location.origin + '/bl-content/uploads/company-slider/' + x.getAttribute('href'))
     x.querySelector('img').setAttribute('src', window.location.origin + '/bl-content/uploads/company-slider/' + x.querySelector('img').getAttribute('src'));

   })


   function submitLink(e) {


     let linker = document.querySelectorAll('.photo img')[e].getAttribute('src');
     console.log(linker);
     let linkerNew = linker;


     window.opener.document.querySelector('.imagelist').insertAdjacentHTML('afterbegin', `
<span class="monsterspan"> 
<button class="closeThis" onclick="event.preventDefault();this.parentElement.remove()">X</button>
<img src="${linkerNew}" >
 <input type="text" name="image[]" value = "${linkerNew}" >
</span>
 
  `);



     window.close();
   }
 </script>



 </div>
 </div>
 </div>
 </body>

 </html>