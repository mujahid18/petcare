<?php
session_start();
include "config.php";
if(isset($_POST['savefoto'])) 
{
	$allowed_filetypes = array('.jpg','.jpeg','.png','.gif');
	$max_filesize = 10485760;
	$upload_path = 'images/';
	$filename = $_FILES['pilihFoto']['name'];
	$ext = substr($filename, strpos($filename,'.'), strlen($filename)-1);

	if(!in_array($ext,$allowed_filetypes))
	  die('<script>window.alert("File yang diunggah tidak diizinkan. Tipe file harus .jpg/.jpeg/.png"); window.location="index.php?menu=upload";</script>');
	  //echo '<script language="javascript">window.location="account_page.php?action="uploadfoto"</script>';

	if(filesize($_FILES['pilihFoto']['tmp_name']) > $max_filesize)
	  die('<script>window.alert("File yang diunggah terlalu besar, maksimal 1MB;</script>');

	if(!is_writable($upload_path))
	  die('You cannot upload to the specified directory, please CHMOD it to 777.');

	if(move_uploaded_file($_FILES['pilihFoto']['tmp_name'],$upload_path . $filename)) 
	{
	   $query = "UPDATE customer SET foto='".$filename."' WHERE username='".$_SESSION['username']."'"; 
	   
	   mysqli_query($conn,$query);

	   echo '<script>window.alert("Unggah foto berhasil!");</script>';
	   echo '<script language="javascript">window.location="index.php?"</script>';
	} 
	else 
	{
		echo '<script>window.alert("Terjadi kesalahan saat mengupload foto, silahkan coba lagi.");</script>';
	}
}
?>