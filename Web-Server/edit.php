<?php 
include('header.php');
$user = $_SESSION['user'];
if(isset($_POST['update']) and !empty($_POST['update'])){
$ret_val = $obj->updateUser();
if($ret_val==1){
    echo '<script type="text/javascript">'; 
    echo 'alert("Record Updated Successfully");'; 
    echo 'window.location.href = "user.php";';
    echo '</script>';
}
}
?>
<div class="container-fluid bg-3 text-center">    
  <h3>CRUD Example Using PHP OOPS And PostgreSQL</h3>
  <a href="index.php" class="btn btn-primary pull-right" style='margin-top:-30px'><span class="glyphicon glyphicon-step-backward"></span>Back</a>
  <br>  
  <div class="panel panel-primary">
        <div class="panel-heading">CRUD Example Using PHP OOPS And PostgreSQL</div>
            <form class="form-horizontal" method="post">
            <div class="panel-body">             
             <div class="form-group">
               <label class="control-label col-sm-2">Name:<span style='color:red'>*</span></label>
               <div class="col-sm-5">
                  <input class="form-control" value= "<?=$user->name?>"type="text" name="name" required>
               </div>
            </div>
             <div class="form-group">
               <label class="control-label col-sm-2">Email:<span style='color:red'>*</span></label>
               <div class="col-sm-5">
                  <input class="form-control" value= "<?=$user->email?>"type="email" name="email" required>
               </div>
            </div>            
             <div class="form-group">
               <label class="control-label col-sm-2">Mobile Number:<span style='color:red'>*</span></label>
               <div class="col-sm-5">
                  <input class="form-control" value= "<?=$user->mobile_no?>"type="number" name="mobileno" required>
               </div>
            </div>
            <div class="form-group">
               <label class="control-label col-sm-2">Address:<span style='color:red'>*</span></label>
               <div class="col-sm-5">
                  <textarea rows="5" cols="5" class="form-control" name="address" required><?=$user->address?></textarea>
               </div>
               <input type="hidden" value="<?=$user->id?>" name="id">
            </div>
             <div class="form-group">
               <label class="control-label col-sm-2">  </label>
               <div class="col-sm-5">
                 <input type="submit" class="btn btn-success" name="update" value="Update">                    
                </div>
            </div> 
        </div>      
</form>
</div>
</div>  
 <?php include('footer.php');?>