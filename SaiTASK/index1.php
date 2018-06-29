
<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	
	// if session is not set this will redirect to login page
	if( !isset($_SESSION['user']) ) {
		header("Location: index1.php");
		exit;
	}
	// select loggedin users detail
	$res=@mysql_query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
	$userRow=@mysql_fetch_array($res);
?>
<?php 
include('header.php');
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['userEmail']; ?></title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css" />
<style>
    /* Image Designing Propoerties */
    .thumb {
        height: 75px;
        border: 1px solid #000;
        margin: 10px 5px 0 0;
    }
</style>

<script type="text/javascript">
   
    $(function () {
        $(":file").change(function () {
            if (this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);
            }
        });
    });

    function imageIsLoaded(e) {
        $('#myImg').attr('src', e.target.result);
        $('#yourImage').attr('src', e.target.result);
    };

</script>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="http://www.codingcage.com">Upload Page</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            
          </ul>
          <ul class="nav navbar-nav navbar-right">
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
			  <span class="glyphicon glyphicon-user"></span>&nbsp;Hi' <?php echo $userRow['userEmail']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav> 
<br><br>

<br>
<br>
<br>
<br>
<br>
<br>
    <div class="container">
	 <form class="form-horizontal" method="POST">
	 <div class="control-group">
    <div class="controls">
   <input type='file' />
</br><img id="myImg" src="#" alt="your image" height=200 width=100>
    </div>
    </div>
    <div class="control-group">

    <div class="controls">
    <textarea rows="3" name="post_content" class="span6" placeholder="Whats on Your Mind"></textarea>
    </div>
    </div>
   
    <div class="control-group">
    <div class="controls">
    <button name="post" type="submit" class="btn btn-info"><i class="icon-share"></i>&nbsp;Post</button>
    </div>
    </div>
	
	<div class="control-group">
	
    <div class="controls">
 
 
    <table class="table table-bordered">

    <thead>
	
    </thead>
    <tbody>
			<?php
	$query=@mysql_query("select * from post")or die(@mysql_error());
	while($row=@mysql_fetch_array($query)){
	$id=$row['post_id'];
	?>
	
	
    <tr>
    <td><?php echo $row['content']; ?></td>
    <td width="50">
	<?php 
	$comment_query=@mysql_query("select * from comment where post_id='$id'")or die(@mysql_error());
	$count=@mysql_num_rows($comment_query);
	?>
	<a href="#<?php echo $id; ?>" data-toggle="modal"><i class="icon-comments-alt"></i>&nbsp;<span class="badge badge-info"><?php echo $count; ?></span></a>
	</td>
    <td width="40"><a class="btn btn-danger" href="delete_post.php<?php echo '?id='.$id; ?>"><i class="icon-trash"></i></a></td>
	<td><img id="myImg" src="#" alt="your image" height=200 width=100></td>
    </tr>
	
	    <!-- Modal -->
    <div id="<?php echo $id; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
    </div>
    <div class="modal-body">
	
	<!----comment -->
		 <form  method="POST">
	<input type="hidden" name="id" value="<?php echo $id; ?>">
    <textarea rows="3" name="comment_content" class="span6" placeholder="Your Comment Here"></textarea>
	<br>
	<br>
    <button name="comment" type="submit" class="btn btn-info"><i class="icon-share"></i>&nbsp;Comment</button>
	</form>
	<br>
	<br>
	
	<?php $comment=@mysql_query("select * from comment where post_id='$id'")or die(@mysql_error());
	while($comment_row=@mysql_fetch_array($comment)){ ?>

	<div class="alert alert-success"><?php echo $comment_row['content']; ?></div>
	
	<?php } ?>
	<!--- end comment -->
	
	
	
    </div>
    <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
   
    </div>
    </div>
	
	<?php  } ?>
    </tbody>
    </table>
 

    </div>
    </div>
	
    </form>

	
	


	
	
		
	
	
		
		
		</div>
		<?php
		if(isset($_POST['post'])){
		$post_content=$_POST['post_content'];
		
		
		@mysql_query("insert into post (content) values('$post_content')")or die(@mysql_error());
		header('location:index1.php');
		
		
		}
		?>
		
		
			<?php
		if(isset($_POST['comment'])){
		$comment_content=$_POST['comment_content'];
		$post_id=$_POST['id'];
		
		@mysql_query("insert into comment (content,post_id) values('$comment_content',$post_id)")or die(@mysql_error());
		header('location:index.php');
		
		
		}
		?>
</body>
</html>