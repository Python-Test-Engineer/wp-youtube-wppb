<?php 

 	if (isset($_GET['id'])) {
 		$id = $_GET['id'];

  	global $wpdb;
	
		// $event_data = $wpdb->get_row(
		// 	"SELECT * FROM 01_iws_tbl_events WHERE event_id = 72", ARRAY_A
		// );
    $event_data =$wpdb->get_row(
			$wpdb->prepare("SELECT * FROM 01_iws_tbl_events WHERE event_id =  %d", $id, ARRAY_A)
		);
    // echo $event_data->event_name;
    // echo test();
		// echo "<pre>";
		// print_r($event_data);
		// echo "</pre>";
    

		}
  else {
    echo '<h2>To edit events go to List Events sub-page list.</h2>';
    return;
  }
 ?>
 <div>
   <h1>DELETE EVENT <?php echo $id ?></h1>



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
    <div>
     <button id="btnDelete"  type="button">DELETE THIS EVENT?</button>
     <button id="btnCancel"  type="button">CANCEL</button>
    </div>
    <div id="output"></div>
	</form>
</div>

<script>
 
  const eventId = document.getElementById('event-id');

  const btnDelete = document.getElementById('btnDelete');
  const btnCancel = document.getElementById('btnCancel');

  btnDelete.addEventListener('click', handleDelete)
  btnCancel.addEventListener('click', ()=> {
    window.location = siteObj.adminUrl + 'page=event-management-list-event'
  })

  function handleDelete(e){
  
    const nonceValue = '<?php  echo wp_create_nonce('wp_rest'); ?>'; // ! must be wp_rest
    // console.log("form nonceValue via PHP: " + nonceValue);

     // Use HTML FormData object enable the endpoint to get POST data
    const formData = new FormData();
    formData.append('_wpnonce', nonceValue); 
    formData.append('eventId', eventId.value);
   
    console.log(formData)
    
    const siteUrl = siteObj.siteUrl;
    console.log('siteUrl', siteUrl)
    fetch(siteUrl + '/wp-json/iws-eventsdb/v1/delete-event', {
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






