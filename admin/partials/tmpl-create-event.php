<?php 
 wp_enqueue_media(); // inserts dynamic JS code for media
 $default_image = site_url() .'/wp-content/uploads/default-1.png';
 echo $default_image;

?>
<style>
  .error {
    color: red;
    font-family: inherit;
    font-size:16px;
   
  }
  p {
    padding:0;
    margin:0;
  }
</style>
<div class="" id="event-enter-form">
  <form class="" method="" action="" id="frm-create-event">
  
    <label class="" for="dd_event_name">
    <h2 class="">Event Name:</h2></label>
    <div class="">
      <input type="text"  class="" placeholder="Event name..." id="event-name" />
      <p id="error-name" class="error"></p>
    </div>
    <label class="" for="event-start-date">
    <h2 class="text-xl mt-4 mb-4 font-bold">Start Date:</h2></label>
    <div class="">
      <input type="datetime-local" value="" class="text-xl" placeholder="Start date..." name="event-start-date" id="event-start-date" />
       <p id="error-start-date" class="error"></p>
    </div>
    <label class="" for="event-end-date">
    <h2 class="text-xl mt-4 mb-4 font-bold">End Date:</h2></label>
    <div class="">
      <input type="datetime-local" value=""  class="text-xl" placeholder="end date..." name="event-end-date" id="event-end-date" />
       <p id="error-end-date" class="error"></p>
    </div>
    <label class="" for="event-approved"> <h2 class="text-xl mt-4 mb-4 font-bold">Approved: <input type="checkbox" class="text-xl"  name="event-approved" id="event-approved" /></h2></label>
     <div class="">
       <span id="error-approved" class="error"></span>
    </div>
    <div style="display:flex;align-items:center;gap:10px;">
    <label class="" for="event-size"> <h2 class="text-xl mt-4 mb-4  font-bold">
      <h2>Size: </h2>
    </label>
    <div id="radio-size">
      <input type="radio" name="event-size"  value="small" id="size-small"/>small
      <input type="radio" name="event-size"  value="large"  id="size-large"/>large
      </div>
    </div>
    <div class="">
       <span id="error-size" class="error"></span>
    </div>
   
    <div style="display:flex; align-items:center;gap:10px;">
     <label class="" for="event-selected">
       <h2 class="text-xl mt-4 mb-4 font-bold">Selected: </h2>
      </label>
     <select id="event-category">
       <option value="0" category>&nbsp;&nbsp;&nbsp;&nbsp;--Select--  </option>
       <option value="1">&nbsp;&nbsp;&nbsp;&nbsp;Standard</option>
       <option value="2">&nbsp;&nbsp;&nbsp;&nbsp;Premium</option>
     </select>
    </div>
    <div class="">
       <span id="error-category" class="error"></span>
    </div>
    <!-- 2021-11-22T18:45 -->
    <label class="" for="event-image">
    <h2 class="">Event Image:</h2></label>
    <div class="upload">
      <input type="button" value="Upload Image"  class=""  name="txt_image" id="txt_image">
      <img src="<?php echo esc_attr($default_image) ?>" style="height:44px;width:44px;border:0" id="event_image" />
      <input type="hidden" name="event_cover_image" id="event_cover_image" />
    </div>
    <div >
     <button id="btnSubmit"  type="button">Register Event</button>
    </div>
    <div id="output"></div>
	</form>
</div>

<script>

  const form = {
    formIsValid: false,
    nameIsValid: false,
    startIsValid: false,
    endIsValid: false,
    approvalIsValid: false,
    categoryIsValid: false,
    sizeIsValid: false
  }

  const eventName = document.getElementById('event-name');
  const errorName = document.getElementById('error-name');
  const eventStart = document.getElementById('event-start-date');
  const errorStart = document.getElementById('error-start-date');
  const eventEnd = document.getElementById('event-end-date');
  const errorEnd = document.getElementById('error-end-date');
  const eventApproved = document.getElementById('event-approved');
  const errorApproved = document.getElementById('error-approved');
  const eventCategory = document.getElementById('event-category');
  const errorCategory = document.getElementById('error-category');
  const eventSizeSmall = document.getElementById('size-small'); 
  const eventSizeLarge = document.getElementById('size-large'); 
  const errorSize = document.getElementById('error-size');
  const btnSubmit = document.getElementById('btnSubmit');
  const btnImage = document.getElementById('txt_image');
  const eventImage = document.getElementById('event_image');
  const eventCoverImage = document.getElementById('event_cover_image');
  
  
  btnImage.addEventListener('click', handleImage)
  
  let imageUrl = 'http://localhost/wp-plugins/wp-content/uploads/default-1.png';

  function handleImage(e){
    var image = wp.media({
			title: "Upload Event Image",
			multiple: false
		}).open().on("select", function(e){

			var uploaded_image = image.state().get("selection").first();
			console.log(uploaded_image.toJSON());
			var image_data = uploaded_image.toJSON();
      // console.log(image_data);
      
      imageUrl = image_data.url;
      
      console.log('IMAGE URL',imageUrl);

			eventImage.setAttribute("src", image_data.url);
			eventCoverImage.setAttribute("value",image_data.url);
     
   })
  }
    
  btnSubmit.addEventListener('click', handleSubmit)

  function handleSubmit(e){

    debugInfo('in handle submit CREATE')

    if (eventName.value == '') {
      form.nameIsValid = false;
      errorName.innerHTML = 'Please enter a name';
    } else {
       errorName.innerHTML = '';
      form.nameIsValid = true;
    }
    if (eventStart.value == '') {
      errorStart.innerHTML = 'Please enter a start date';
      form.startIsValid = false;
    } else {
      errorStart.innerHTML = '';
      form.startIsValid = true;
    }
    if (eventEnd.value == '') {
      errorEnd.innerHTML = 'Please enter an end date';
      form.endIsValid = false;
    } else {
      errorEnd.innerHTML = '';
      form.endIsValid = true;
    }
    if (!eventApproved.checked) {
      errorApproved.innerHTML = 'Please get approval';
      form.approvalIsValid = false;
    } else {
       errorApproved.innerHTML = '';
       form.approvalIsValid = true;
    }
    
    if (eventSizeSmall.checked || eventSizeLarge.checked ) {
       errorSize.innerHTML = '';
       form.sizeIsValid = true;
    } else {
      errorSize.innerHTML = 'Please select size';
      form.sizeIsValid = false;
    }
    if (eventCategory.value == 0) {
       
      errorCategory.innerHTML = 'Please select category';
      form.categoryIsValid = false;
    } else {
      errorCategory.innerHTML = '';
      form.categoryIsValid = true;
    }
    
    if (form.nameIsValid && form.startIsValid && form.endIsValid && form.approvalIsValid && form.categoryIsValid && form.sizeIsValid)  {
      const nonceValue = '<?php  echo wp_create_nonce('wp_rest'); ?>'; // ! must be wp_rest
      // console.log("form nonceValue via PHP: " + nonceValue);

      // Use HTML FormData object enable the endpoint to get POST data
      const formData = new FormData();
      formData.append('_wpnonce', nonceValue); 
      formData.append('eventName', eventName.value);
      formData.append('eventStartDate', eventStart.value);
      formData.append('eventEndDate', eventEnd.value); // to demonstrate additional hidden fields
      formData.append('imageUrl', imageUrl);
      console.log(formData)
      // const siteUrl = 'http://localhost/wp-youtube-wppb';
      const siteUrl = siteObj.siteUrl;
      console.log('siteUrl', siteUrl)
      fetch(siteUrl + '/wp-json/iws-eventsdb/v1/add-event', {
              method: 'POST', // set FETCH type GET/POST
              body: formData  // append form data
          })
          .then(function (response) {
              // console.log(response);
              return response.json(); // convert stream response to text
          })
          .then(function (data) {
              console.log(data);
              const output = document.getElementById('output');
              output.innerHTML = '<div class="">' + JSON.stringify(data) + '</div>';
          });
    }
    else {
      console.log('FORM INVALID')
    }
  }
</script>

