<?php
require_once('class/user_login.php');
$login = new user_login();
$data_users = $login->users_list();
$tbody='';
while(list(,$data_user)=each($data_users)){
	$css_status='';
	
	switch($data_user['status_name']){
		case 'Active':
			$css_status='success';
		break;
		case 'Pending':
			$css_status='default';
		break;
		case 'Inactive':
			$css_status='danger';
		break;
		default:
			$css_status='default';
		break;
	}
	
	$tbody.='					<tr id="user_row_'.$data_user['login_id'].'">
                                    <td>
                                        <img id="img_profile_'.$data_user['login_id'].'" src="/login/img/profile_'.$data_user['profile_id'].'.jpg" alt="">
                                        <a id="full_name_'.$data_user['login_id'].'" href="#" class="user-link">'.$data_user['firstName'].' '.$data_user['lastName'].'</a>
                                        <span id="profile_name_'.$data_user['login_id'].'" class="user-subhead" >'.$data_user['profile_name'].'</span>
                                    </td>
                                    <td>'.str_replace('-','/',$data_user['created_date']).'</td>
                                    <td class="text-center">
                                        <span id="status_name_'.$data_user['login_id'].'" class="label label-'.$css_status.'">'.$data_user['status_name'].'</span>
                                    </td>
                                    <td>
                                        <a id="user_mail_'.$data_user['login_id'].'" href="#">'.$data_user['email'].'</a>
                                    </td>
                                    <td style="width: 20%;">
                                        <a href="" class="table-link"  data-toggle="modal" data-target="#myModal">
                                            <span class="fa-stack" onclick="javascript:loadDatauser(this);" data-custom_01="'.$data_user['login_id'].'" data-custom_02="'.$data_user['firstName'].'" data-custom_03="'.$data_user['lastName'].'" data-custom_04="'.$data_user['profile_id'].'" data-custom_05="'.$data_user['email'].'" data-custom_06="'.$data_user['status_id'].'">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </a>
                                        <a href="#" class="table-link danger" data-toggle="modal" data-target="#myModal_2">
                                            <span class="fa-stack" onclick="javascript:loadDatauser_2(this);" data-custom_01="'.$data_user['login_id'].'" data-custom_02="'.$data_user['firstName'].'" data-custom_03="'.$data_user['lastName'].'" data-custom_04="'.$data_user['profile_id'].'" data-custom_05="'.$data_user['email'].'" data-custom_06="'.$data_user['status_id'].'">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </a>
                                    </td>
                                </tr>';
}

?>
<!DOCTYPE html>
<html>
	<head>
		<script src="js/jquery-1.10.2.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" id="bootstrap-css">
		<link rel="stylesheet" type="text/css" href="css/user_list.css">
		<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
		
	</head>
<body>
<div class="container bootstrap snippet">
    <div class="row">
        <div class="col-lg-12">
            <div class="main-box no-header clearfix">
                <div class="main-box-body clearfix">
                    <div class="table-responsive">
                        <table class="table user-list">
                            <thead>
                                <tr>
                                <th><span>User</span></th>
                                <th><span>Created</span></th>
                                <th class="text-center"><span>Status</span></th>
                                <th><span>Email</span></th>
                                <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?=$tbody?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit User</h4>
      </div>
      <div class="modal-body" style="height:250px;">
			<div class="col-md-6">
				<input id="firstName" name="firstName" placeholder="First Name" type="text" class="form-control" autofocus>
			</div>
			<div class="col-md-6">
				<input id="lastName" name="lastName" placeholder="Last Name" type="text" class="form-control"><br>
			</div>
			<div class="col-md-6">	
				<?=$login->selectProfiles()?>
			</div>
			<div class="col-md-6">	
				<?=$login->selectStatus()?>
				<br>
			</div>
			<div class="col-md-8">
				<input id="email" name="email" placeholder="Email address" type="text" class="form-control" value=" " ><br>
			</div>
			<div class="col-md-8">
				<input id="password" name="password" placeholder="Password" type="password" class="form-control"><br>
			</div>
				<input id="login_id" name="login_id" type="hidden" type="text" value=" " >
				
			
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="update_user();">Save changes</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="myModal_2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Delete User</h4>
      </div>
      <div class="modal-body" >
			
			Are you sure to delete account: <span style="color:#blue;" id="email_delete"></span>
			<input id="login_id_delete" name="login_id_delete" type="hidden" type="text" value=" " >	
			
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" onclick="delete_user();">DELETE</button>
      </div>
    </div>
  </div>
</div>
<script>
	function loadDatauser(elem){		
		var login_id = $(elem).attr("data-custom_01");
		var firstName = $(elem).attr("data-custom_02");
		var lastName = $(elem).attr("data-custom_03");
		var profile = $(elem).attr("data-custom_04");
		var email = $(elem).attr("data-custom_05");
		var status = $(elem).attr("data-custom_06");		
		
		$("#firstName").attr("value",firstName);
		$("#lastName").attr("value",lastName);
		$("#email").attr("value",email);
		$("#login_id").attr("value",login_id);
		$("#profile").val(profile).change();
		$("#status").val(status).change();		
	}
	
	function update_user(){
		firstName=$("#firstName").val();		
		lastName=$("#lastName").val();		
		email=$("#email").val();
		
		profile=$("#profile").val();
		profileName=$("#profile option:selected" ).text();
		
		
		status=$("#status").val();
		statusName=$("#status option:selected" ).text();
		
		
		CssStatus='default';
		
		if(statusName == 'Active'){		
			CssStatus='success';
		} else if (statusName == 'Pending'){
			CssStatus='default';
		} else if (statusName == 'Inactive'){
			CssStatus='danger';
		}
		
		login_id = $("#login_id").val();
		
		$.ajax({
    		type: "POST",
			url: "update_user.php",
			data: {login_id: login_id, firstName: firstName, lastName: lastName, email: email, profile: profile, status:status},
        	success: function(msg){
				alert(msg);
					$("#myModal").modal('hide'); 
					
					
					$("#img_profile_"+login_id).attr("src","/login/img/profile_"+profile+".jpg");
					$("#full_name_"+login_id).html(firstName+" "+lastName);
					$("#profile_name_"+login_id).html(profileName);
					$("#status_name_"+login_id).html(statusName);
					$("#status_name_"+login_id).removeClass().addClass("label label-"+CssStatus);
					
					$("#user_mail_"+login_id).html(email);
					
					
					
			}
		
      	});
	}
	
	
	function loadDatauser_2(elem){		
		var login_id = $(elem).attr("data-custom_01");		
		var email = $(elem).attr("data-custom_05");
		
		$("#email_delete").html(email);
		$("#login_id_delete").attr("value",login_id);		
		
	}
	
	function delete_user(){
		var login_id = $("#login_id_delete").val();
		
		$.ajax({
    		type: "POST",
			url: "delete_user.php",
			data: {login_id: login_id},
        	success: function(msg){
				alert(msg);
					$("#myModal_2").modal('hide'); 
					
					$("#user_row_"+login_id).remove();
					
			}
		
      	});
	}
	
	
</script>
</body>
</html>