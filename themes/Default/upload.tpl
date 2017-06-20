<h1>Μεταφόρτωση νέας φωτογραφίας</h1>
<div class="content">
{include file="includes/message.tpl"}
	<!-- upload form -->
	<div class="half fleft">
		<form name="uploadImage" id="uploadImage" enctype="multipart/form-data" action='{$SCRIPT_NAME}?action=upload' method="POST">
		<input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
		<input type="file" name="memberImage" id="memberImage" />
		<input type="submit" class="button Blue" name="upload_image" id="upload_image" value="Μεταφόρτωση" /> 
		</form>
		
	</div>
	<div class="info fright">
	<p>
		<a href="photos.php">Μετάβαση στο album μου</a>
	</p>
	<ul>
		<li>Η φωτογραφία σας πρέπει να είναι το πολύ <q>5mb</q></li>
		<li>Επιτρεπόμενοι τύποι αρχείων: <q>jpeg, png</q></li>
		<li>Φωτογραφίες μεγαλύτερες απο <q>1280x1024</q> θα γίνονται αυτόματα resize</li>
	</ul>
</div>

</div>

<h1>Multi Upload</h1>
<div class="content">
	<div class="half fleft">
		<form name="multiUploadImages" id="multiUploadImages" enctype="multipart/form-data" action='{$SCRIPT_NAME}?action=multi_upload' method="POST">
		<input type="file" name="zipFile" id="zipFile" />
		<input type="submit" class="button Blue" name="multi_upload_images" id="multi_upload_images" value="Μεταφόρτωση" /> 
		</form>
		</div>
		<div class="info fright">
			<ul>
				<li>Ο uplaoder περιμένει ένα αρχείο τύπου Zip.</li>
				<li>Μέσα στο zip υπάρχει η δυνατότητα να δημιουργήσετε ένα <q>xml αρχείο</q> που θα περιέχει πληροφορίες για τις φωτογραφίες προς μεταφόρτωση.</li>
				<li>O συνδιασμός φωτογραφίας και πληροφοριών xml απαιτεί <q>ΙΔΙΟ ΟΝΟΜΑ ΑΡΧΕΙΟΥ ΦΩΤΟΓΡΑΦΙΑΣ</q></li>
			</ul>
		</div>
</div>