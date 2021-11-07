<?php 
  function convert_sqldate_input_date($sql_date){
      $input_date = str_replace(" ","T","$sql_date");
      return $input_date;
  }

  wp_enqueue_media(); // inserts dynamic JS code for media
 


 	if (isset($_GET['id'])) {
 		$id = $_GET['id'];

  	global $wpdb;
	
		// $event_data = $wpdb->get_row(
		// 	"SELECT * FROM 01_iws_tbl_events WHERE event_id = 72", ARRAY_A
		// );
    $event_data =$wpdb->get_row(
			$wpdb->prepare("SELECT * FROM 01_iws_tbl_events WHERE event_id =  %d", $id, ARRAY_A)
		);
    echo $event_data->event_name;
    echo test();
		echo "<pre>";
		print_r($event_data);
		echo "</pre>";
    $default_image = site_url() .'/wp-content/uploads/default-1.png';
    echo $default_image;

		}
  else {
    echo '<h2>To edit events go to List Events sub-page list.</h2>';
    return;
  }
 ?>
 <div>
   <h1>EDIT EVENT <?php echo $id ?></h1>

 <?php 
//  echo convert_sqldate_input_date( $event_data->event_start_date);
 wp_enqueue_media(); // inserts dynamic JS code for media
?>

<div class="" id="event-enter-form">
  <form class="" method="" action="" id="frm-edit-event">
     <label class="" for="event_id">
    <h2 class=""><?php echo $event_data->event_id ?> </h2></label>
    <div class="">
      <input type="hidden" value="<?php echo $event_data->event_id ?>" id="event-id" />
    </div>
    <label class="" for="event_name">
    <h2 class="">Event Name:</h2></label>
    <div class="">
      <input type="text" value="<?php echo $event_data->event_name ?>" class="" placeholder="Event name..." id="event-name" />
     
    </div>
    <label class="" for="event-start-date">
    <h2 class="text-xl mt-4 mb-4 font-bold">Start Date:</h2></label>
    <div class="">
      <input type="datetime-local" value="<?php echo convert_sqldate_input_date($event_data->event_start_date) ?>" class="text-xl" placeholder="Start date..." name="event-start-date" id="event-start-date" />
    </div>
    <label class="" for="event-end-date">
    <h2 class="text-xl mt-4 mb-4 font-bold">End Date:</h2></label>
    <div class="">
      <input type="datetime-local" value="<?php echo convert_sqldate_input_date($event_data->event_end_date) ?>"  class="text-xl" placeholder="end date..." name="event-end-date" id="event-end-date" />
    </div>
    <label class="" for="event-image">
    <h2 class="">Event Image:</h2></label>
    <div class="upload">
      <input type="button" value="Upload Image"  class=""  name="txt_image" id="txt_image">
      <img src="<?php echo $event_data->event_image ?>" style="height:44px;width:44px;border:0" id="event_image" />
      <input type="hidden" name="event_cover_image" id="event_cover_image" />
    </div>
    <div >
     <button id="btnSubmit"  type="button">Update Event</button>
     <button id="btnCancel"  type="button">CANCEL</button>
    </div>
    <div id="output"></div>
	</form>
</div>

<script>
 
  const eventId = document.getElementById('event-id');
  const eventName = document.getElementById('event-name');
  const eventStart = document.getElementById('event-start-date');
  const eventEnd = document.getElementById('event-end-date');
  const btnSubmit = document.getElementById('btnSubmit');
  const btnCancel = document.getElementById('btnCancel');
  const btnImage = document.getElementById('txt_image');
  const eventImage = document.getElementById('event_image');
  const eventCoverImage = document.getElementById('event_cover_image');
  if (!eventImage) {
    console.log(eventImage)
    eventImage = "<?php echo $event_data->event_image ?>"
  }
  
  
  btnImage.addEventListener('click', handleImage)
  
  let imageUrl = '<?php echo $event_data->event_image ?>';

  function handleImage(e){
    var image = wp.media({
			title: "Upload Event Image",
			multiple: false
		}).open().on("select", function(e){

			var uploaded_image = image.state().get("selection").first();
		
			var image_data = uploaded_image.toJSON();
      console.log('image_data',image_data); 
      if (image_data.url){
        imageUrl = image_data.url;
        console.log('IMAGE URL',imageUrl);
      } else {
          imageUrl = image_data.url;
          console.log('IMAGE URL',imageUrl);
      }
     

			eventImage.setAttribute("src", image_data.url);
			eventCoverImage.setAttribute("value",image_data.url);
     
   })
  }
  btnCancel.addEventListener('click', ()=> {
    window.location =  siteObj.adminUrl + 'page=event-management-list-event'
  })
  btnSubmit.addEventListener('click', handleSubmit)

  function handleSubmit(e){
  
    const nonceValue = '<?php  echo wp_create_nonce('wp_rest'); ?>'; // ! must be wp_rest
    // console.log("form nonceValue via PHP: " + nonceValue);

     // Use HTML FormData object enable the endpoint to get POST data
    const formData = new FormData();
    formData.append('_wpnonce', nonceValue); 
    formData.append('eventId',eventId.value);
    formData.append('eventName', eventName.value);
    formData.append('eventStartDate', eventStart.value);
    formData.append('eventEndDate', eventEnd.value); // to demonstrate additional hidden fields
    formData.append('imageUrl', imageUrl);
    console.log(formData)
    
    const siteUrl = siteObj.siteUrl;
    const adminUrl = siteObj.adminUrl;
    console.log('siteUrl', siteUrl)
    console.log('adminUrl', adminUrl)
    fetch(siteUrl + '/wp-json/iws-eventsdb/v1/edit-event', {
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






