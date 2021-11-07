<?php 
 wp_enqueue_media(); // inserts dynamic JS code for media
 $default_image = site_url() .'/wp-content/uploads/default-1.png';
 echo $default_image;

?>

<div class="" id="event-enter-form">
  <form class="" method="" action="" id="frm-create-event">
  
    <label class="" for="dd_event_name">
    <h2 class="">Event Name:</h2></label>
    <div class="">
      <input type="text"  class="" placeholder="Event name..." id="event-name" />
     
    </div>
    <label class="" for="event-start-date">
    <h2 class="text-xl mt-4 mb-4 font-bold">Start Date:</h2></label>
    <div class="">
      <input type="datetime-local" value="2021-10-01T13:09" class="text-xl" placeholder="Start date..." name="event-start-date" id="event-start-date" />
    </div>
    <label class="" for="event-end-date">
    <h2 class="text-xl mt-4 mb-4 font-bold">End Date:</h2></label>
    <div class="">
      <input type="datetime-local" value="2021-11-22T18:45"  class="text-xl" placeholder="end date..." name="event-end-date" id="event-end-date" />
    </div>
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

  const eventName = document.getElementById('event-name');
  const eventStart = document.getElementById('event-start-date');
  const eventEnd = document.getElementById('event-end-date');
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
</script>

