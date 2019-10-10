<?php
/* Auto Sitemap for google */
add_action("init","googlesitemap");
function googlesitemap() {
 $posts = get_posts( array(
     'numberposts' => 2,
     'post_type'   => array('post'),
     'order'       => 'DESC'
 		) );
 header('Content-Type: text/xml; charset=' . get_bloginfo('charset'), true);
 header('X-Robots-Tag: index, follow', true);
 $sitemap .= '<?xml version="1.0" encoding="UTF-8"?>
 <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">
';
foreach( $posts as $post ) {
	$posttitle=$post->post_title;
	$postmetatitle=get_post_meta($post->ID, "meta_title", true);
	$keyword=get_post_meta($post->ID, 'meta_keywords', true);
	$date=$post->post_date;
   setup_postdata( $post);
   $postdate = explode( " ", $post->post_modified );
   $sitemap .= '<url>
   <loc>' . get_permalink( $post->ID ) . '</loc>
   <news:news>
   <news:publication>
    <news:name>' .$posttitle.'</news:name>
    <news:language>en</news:language>
   </news:publication>
   <news:genres>Blog</news:genres>
   <news:publication_date>'. get_the_time('Y-m-d', $post->ID) .'</news:publication_date>
   <news:title>'.$postmetatitle.'</news:title>
   <news:keywords>'.$keyword.'</news:keywords>
  </news:news>
   </url>';
 }
 $sitemap .= '</urlset>';

 $fop = fopen(ABSPATH."news-sitemap.xml",'w');
 fwrite($fop,$sitemap );
 fclose( $fop );
}
?> 

<?php
	include("include/classes/SMTPClass.php");
	include("include/classes/PHPMailer.class.php");
	include("include/classes/SMTP.class.php");

	if(isset($_POST['submit']))
	{
		if($_POST['email']!='')
			{
				$body = "<html> 
						<body><p>Hello Admin ,</p>
						<p>Your Message Details are </p><p><b>Message:</b> ".$_POST['message']."</p>
						<p>Thank You</p><p></p></body></html>";
				$body2="Done";
				$mail = new PHPMailer();
				$mail->IsSMTP(); // telling the class to use SMTP
				$mail->Host = 'smtp.gmail.com'; // SMTP server
				$mail->Port = 465;
				$mail->SMTPDebug  = 0; 
				$mail->SMTPAuth   = true;
				$mail->Username   = 'abc.abc@gmail.com';
				$mail->Password   = '123456';
				$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
				$mail->mail = $mail;
				//$mail->From = 'abc.abc@gmail.com';
				$mail->FromName = 'Contact Testing'; 
				$mail->Subject = 'Meeting ';
				$mail->AddAddress('abc.abc@gmail.com');
				$mail->MsgHTML($body);
				
				if($mail->send())
				{			
					echo 'Your Message has been sent to your registered Email-id.'; 
					//$mail->AddAddress('abc@abc.com');
					//$mail->MsgHTML($body2);
				}
				else
				{
					echo 'Error in sending email, Please try again.';
				}
			}
			else
			{
				echo "Please Enter Email ";
			}
	}
	
	
?>

<form action="" method="POST">
	<table width="" border="">
  <tr>
    <th colspan="3" align="center" >Email demo</th>
  </tr>
  <tr>
    <td colspan="2">Enter Email</td>
    <td><input type="text" name="email" required /></td>
  </tr>
  <tr>
    <td colspan="2">Enter Message</td>
    <td><textarea name="message" required></textarea></td>
  </tr>
  <tr>
    <td colspan="3" align="center"><input type="submit" name="submit" /></td>
  </tr>
</table>

</form>
