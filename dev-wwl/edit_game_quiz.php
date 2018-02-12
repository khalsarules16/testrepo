<?php 
include 'dbConfig.php';
$page_title = "Edit Quiz";
$page_description = "Edit Quiz Game";
include("header.php"); 
$select="select * from game where id='".$_REQUEST['id']."'";
$gamers=mysqli_query($DBcon,$select) or die("Cannot Execute Query".mysqli_error($dbcon));
$gamerow=mysqli_fetch_array($gamers);
 if($gamerow['Publish']=="Yes")
{
    ?>
    <script>
    alert("Sorry This Game is Live You will not able to edit this game");
    document.location="game-draft-publish.php";
    </script>
    <?php
}
?>
			<!--==Game Creation: 2048 Page==-->
			<div class="game-creation">
				<div class="game-2048">
					<div class="row">
						<div class="col-sm-3">
                        <a href="addquiz_new.php?id=<?php echo $_REQUEST['id']?>">Edit Quiz</a>
							<div class="gameGraphic">
								<div class="gIconPreview">
									
                                    <?php if($gamerow['Game_Image']!=""){
                                            ?>
                                            <img width="82px" id="iconimage" src="<?php echo $gamerow['Game_Image']?>"><br /><br />
                                            <?php
                                        }
                                        else
                                        {?>
                                        
                                            <img src="assets/img/dcimage-1.png" id="iconimage" alt="Game Image">
                                        <?php
                                        }?>
									<label>
										Upload Icon
										<input type="file" name="gameicon" id="gameicon">
									</label>
								</div>
							</div>
						</div>
                        <script>
                                document.getElementById("gameicon").onchange = function () {
                                var reader = new FileReader();
                            
                                reader.onload = function (e) {
                                    // get loaded data and render thumbnail.
                                    document.getElementById("iconimage").src = e.target.result;
                                };
                            
                                // read the image file as a data URL.
                                reader.readAsDataURL(this.files[0]);
                            };
                                </script>
						<div class="col-sm-3">
							<div class="gameInfo">
								<div class="giHead">
									<h3>Game Info <span class="more-info" data-toggle="popover" data-trigger="hover" data-content="Some content will be here">?</span></h3>
									<h2>Quiz</h2>
								</div>
								<div class="giTitle">
									<input type="text" id="game_name" name="game_name" value="<?php echo $gamerow['name']?>" placeholder="Game Title">
									<textarea name="game_desc" id="game_desc" placeholder="Description"><?php echo $gamerow['game_desc']?></textarea>
								</div>
								<div class="giValue">
									<h3>Game Value</h3>
									<input type="text" id="game_value" name="game_value" value="<?php echo $gamerow['win_credit']?>" placeholder="Input your Value">
								</div>
								<div class="giCost">
									<h3>Cost to Play</h3>
									<input type="text" id="credit_cost" name="credit_cost" value="<?php echo $gamerow['credit_cost']?>" placeholder="Input your Value">
								</div>
								<div class="giDepends">
									<h3>Game Depends on</h3>
									<select id="winner_option" name="winner_option" onchange="optionchange()">
										<option <?php if($gamerow['winner_option']=="3") echo "selected";?> value="3">Both</option>
										<option <?php if($gamerow['winner_option']=="1") echo "selected";?> value="1">Duration Based</option>
										<option <?php if($gamerow['winner_option']=="2") echo "selected";?> value="2">Min Credit Based</option>
									</select>
								</div>
							</div>
						</div>
                        <script>
                        function optionchange()
                        {
                            var val=document.getElementById("winner_option").value;
                            if(val==1)
                            {
                                document.getElementById("min_creditdiv").style.display="none";
                                document.getElementById("game_duration").style.display="block";
                            }
                            else if(val==2)
                            {
                                document.getElementById("min_creditdiv").style.display="block";
                                document.getElementById("game_duration").style.display="none";
                            }
                            else
                            {
                                document.getElementById("min_creditdiv").style.display="block";
                                document.getElementById("game_duration").style.display="block";
                            }
                        }
                        </script>
						<div class="col-sm-6">
							<div class="gameInfoOther">
								<div class="giRule">
									<h3>Games Rules <span class="more-info" data-toggle="popover" data-trigger="hover" data-content="Some content will be here">?</span></h3>
									<div class="girCheckbox">
										<div class="gircItem custom-tick">
											<input type="radio" id="time_limitquiz" <?php if($gamerow['Quiz_rules']==1)echo "checked";?> name="limit" value="1">
											<label>First Come First Win(Score 100%)</label>
										</div>
										<div class="gircItem custom-tick">
											<input type="radio" id="highest_answer" <?php if($gamerow['Quiz_rules']==2)echo "checked";?>  name="rule" value="2">
											<label>Most right answers</label>
										</div>
										<div class="gircItem custom-tick">
											<input type="radio" id="both" <?php if($gamerow['Quiz_rules']==3)echo "checked";?>  name="rule" value="3">
											<label> Timelimit + Most right answer</label>
										</div>   
									</div>
								</div>

								<div class="giPublish">
                                <?php //echo date("m-d-Y h:i A",time())."   ".$gamerow['End_Date'];
                                    if($gamerow['Publish_Date']=="0000-00-00 00:00:00")
                                    $pdate="";
                                    else
                                    {
                                        $pdate=date("m/d/Y",strtotime($gamerow['Publish_Date']));
                                        $ph=date("h",strtotime($gamerow['Publish_Date']));
                                         $pmin=date("i",strtotime($gamerow['Publish_Date']));
                                         $ptime=date("A",strtotime($gamerow['Publish_Date']));
                                    }
                                    ?>
									<h3>Publish Date & Time <span class="more-info" data-toggle="popover" data-trigger="hover" data-content="Some content will be here">?</span></h3>
									<input class="gPublish-date" readonly type="text" id="datepicker" value="<?php echo $pdate?>" style="width:30%;">
									: <select id="publishhour"  name="publishhour" style="width: 20%;background-color:#ff6666;">
                                    <optgroup label='HH'>
                                        <option value="12">00</option>
                                        <?php
                                        for($m=1;$m<12;$m=$m+1)
                                        {
                                            if(strlen($m)==1)$val="0".$m;
                                                else $val=$m;
                                            ?>
                                            <option <?php if($val==$ph) echo "selected";?> value="<?php echo $m?>"><?php echo $val?></option>
                                            <?php
                                        }
                                        ?>
                                        </optgroup>
                                        </select>
                                        :
                                        <select id="publishmin" name="publishmin" style="width: 20%;background-color:#ff6666;">
                                        <optgroup label='MM'>
                                        <option value="00">00</option>
                                        <?php
                                        for($m=5;$m<60;$m=$m+5)
                                        {
                                            if(strlen($m)==1)$val="0".$m;
                                            else $val=$m;
                                            ?>
                                            <option <?php if($val==$pmin) echo "selected";?> value="<?php echo $m?>"><?php echo $val?></option>
                                            <?php
                                        }
                                        ?>
                                        
                                        </optgroup>
                                        </select>
									<ul>
										<li <?php if($ptime=="AM") echo 'class="active"';?>   onclick="changetime('AM')">Am</li>
										<li <?php if($ptime=="PM") echo 'class="active"';?>  onclick="changetime('PM')">Pm</li>
                                        <input type="hidden" name="publishtime" id="publishtime" value="<?php echo $ptime?>">

									</ul>
                                    <script>
                                    function changetime(timeval)
                                    {
                                        document.getElementById("publishtime").value=timeval;
                                    }
                                    </script>
								</div>
								<div class="giDepends-item">
									<div class="duration-base in" id="game_duration" style="display:<?php if($gamerow['winner_option']=="2")echo "none";else echo "block"?>;">
										<h3>Game Duration</h3>
										<label>Day</label>
										<select id="day" name="day" style="width: 15%;">
                                        <?php
                                        for($j=0;$j<366;$j=$j+1)
                                        {
                                            if($gamerow['End_Day']==$j)$select="selected";
                                            else $select="";
                                            echo '<option value="'.$j.'"'.$select.' >'.$j.'</opion>';
                                        }
                                        ?>
                                        </select>
										<label>Hour</label>
										<select id="hour" name="hour" style="width: 15%;">
                                        <?php
                                        for($j=0;$j<24;$j=$j+1)
                                        {
                                            if($gamerow['End_Hour']==$j)$select="selected";
                                            else $select="";
                                            echo '<option value="'.$j.'"'.$select.'>'.$j.'</opion>';
                                        }
                                        ?>
                                        </select>
										<label>Minute</label>
										<select id="minute" name="minute" style="width: 15%;">
                                    <?php
                                    for($j=0;$j<60;$j=$j+1)
                                    {
                                        if($gamerow['End_Minute']==$j)$select="selected";
                                        else $select="";
                                        echo '<option value="'.$j.'"'.$select.'>'.$j.'</opion>';
                                    }
                                    ?>
                                    </select>
									</div>
									<div class="credit-base in" id="min_creditdiv" style="display:<?php if($gamerow['winner_option']=="1")echo "none";else echo "block"?>;">
										<h3>Min Credit</h3>
										<input type="text" id="min_credit" name="min_credit"  value="<?php echo $gamerow['Min_credits']?>"   placeholder="Min Credit">
									</div>
								</div>
								<div class="giCharity">
									<h3>Select your Charity <span class="more-info" data-toggle="popover" data-trigger="hover" data-content="Some content will be here">?</span></h3>
									<?PHP
                                    $game_charity="select * from user_charity where user_id='".$_SESSION['userSession']."' and game_id='".$_REQUEST['id']."'";
                                     $game_charity_rs=mysqli_query($DBcon,$game_charity) or die("Cannot Execute Query");
                                     $game_charity_row=mysqli_fetch_array($game_charity_rs);

                                    $sql = "SELECT * from charity_under_user where User_ID='".$_SESSION['userSession']."'";

                                    $result = $DBcon->query($sql);
                                    ?>
                                    <input type="hidden" name="usercharity" id="usercharity" value="<?php echo mysqli_num_rows($result);?>"/>
                                    <?php
                                       echo "<select id = 'charity_id' name='charity_id'>";
                                       echo "<optgroup label='Select Charity'>";
                                      
                                    if ($result != null) {
                                       // output data of each row
                                        while($row = $result->fetch_assoc()) {
                                            if($row['Type']=="default") $show=" - Default";
                                            else $show="";
                                            if($game_charity_row['charity_id']==$row["ID"])$selected1="selected";
                                            else $selected1="";
                                            echo "<option id='charity_id' ".$selected1." name='charity_id' value=".$row["ID"].">".$row["name"].$show."</option>";
         }
                                     
                                    } else {
                                        echo "<option id='charity_id' name='charity_id' value=''> No Charity Available</option>";
                                    }
                                      echo "</optgroup>";
                                       echo "</select>";
                                     
                                    ?>
<div ><a href="#" data-toggle='modal' data-target='#charityModal'>Add New Charity</a></div>

								</div>
                                <?php
$credits="select * from game_credit where game_id='".$_REQUEST['id']."'";
$credits_rs=mysqli_query($DBcon,$credits) or die("Cannot Execute Query");
$credits_row=mysqli_fetch_array($credits_rs);
?>
								<div class="giCredit">
									<h3>Game Credit Distribution <span class="more-info" data-toggle="popover" data-trigger="hover" data-content="Some content will be here">?</span></h3>
									<div class="gicDistribute">
										<div class="gicdCr">
										  	<span>Creator(%)</span>
										  	<input type="text" id="gicdCreator" value="<?php echo $credits_row['creator_percentage']?>" readonly>
										</div>
										<div class="gicdWi">
											<span>Winner(%)</span>
										  	<input type="text" id="gicdWinner" value="<?php echo $credits_row['winner_percentage']?>"  readonly>
										  	
										</div>
										<div class="gicdWin">
										  	<span>WinWin(%)</span>
										  	<input type="text" id="gicdWinWin" value="<?php echo $credits_row['winwin_percentage']?>"  readonly>
										</div>
										<div class="gicdCh">
										  	<span>Charity(%)</span>
										  	<input type="text" id="gicdCharity" value="<?php echo $credits_row['charity_percentage']?>">
										</div>
									</div>
								</div>
                                
                                <button class='play-btn' style="color: white;font-size: 12px;width: 50%;float:right;" onclick="done()" type="button">Submit</button>
							
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--== Footer Area==-->		
		<?php include("footer.php"); ?>
        <div class="charityModalpoup" id="charityModal-area">
      <div class="modal fade"  id="charityModal">
        <div class="modal-dialog">
          <div class="paywithdraw-Content">
            <div class="pw-header">
                  <button type="button" id="closemodal"  class="close" data-dismiss="modal">&times;</button>
                  <h2 class="modal-title">Add Charity</h2>
              </div>

              <div class="pw-form">
                <div class="efItem">
                  <label>Charity Image:</label> 
              <div class="gIconPreview">
                <img src="assets/img/dcimage-1.png" id="imagecharity" alt="Game Image">
                <input type="hidden" name="picdata" id="picdata" value="">
                <label>
                  Upload Image
                  <input type="file" name="charity_pic" id="charity_pic" value="">
                </label>
              </div>
                </div>
<script>
                                document.getElementById("charity_pic").onchange = function () {
                                var reader = new FileReader();
                            
                                reader.onload = function (e) {
                                    // get loaded data and render thumbnail.
                                    document.getElementById("imagecharity").src = e.target.result;
                                };
                            
                                // read the image file as a data URL.
                                reader.readAsDataURL(this.files[0]);
                            };
                                </script>
                <div class="efItem">
                  <label>Charity Name:</label>
                      <input type="text" style="float: none;" onkeyup="showResult(this.value,'resultmodal','modal')" name="charity_game_name" id="charity_game_name" class="tt-hint" required value=""><div id="resultmodal" style="display:none;float: right;width:65%;" class="tt-dropdown-menu">kjhkl</div>
                </div>

                <div class="efItem">
                  <label>Charity Address:</label> 
                      <input type="text" name="charity_address" id="charity_address" value="">
                </div>

                <div class="efItem">
                  <label>Charity Contact Personnel:</label>
                      <input type="text" name="charity_contact" id="charity_contact" value="">
                </div>

                <div class="efItem">
                  <label>Charity Phone:</label>
                      <input type="text" name="charity_phone" id="charity_phone" value="">
                </div>

                <div class="efItem">
                  <label>Charity Tax ID:</label>
                      <input type="text" name="charity_tax" id="charity_tax" value="">
                </div>


                <div class="efItem">
                  <label>Charity Description:</label>
                      <input type="text" name="charity_description" id="charity_description" value="">
                </div>  
                <div class="efItem">
                  <label>Non-Profit-501c3:</label>
                  <div class="custom-tick">
                        <input type="checkbox" name="charity_non-profit" id="charity_non-profit" value="1">
                      </div>
                </div>    
                <button type="submit" onclick="addcharity()">Add Charity</button>                        
              </div>

          </div>
        </div>
      </div>
    </div>
    <div id="loadermodal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            
            <h4 class="modal-title">Please Wait......</h4>
          </div>
          
             <center> <img width="50%"  src="images/loading.gif" ></center>
        </div>

      </div>
    </div>
     <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker({
      showOn: "button",
      buttonImage: "images/calendar.gif",
      buttonImageOnly: true,
      buttonText: "Select date",
      minDate: +1
    });
  } );
  
  //charity part
  function addcharity()
{
    var error=0;
 var fileInput = document.getElementById('charity_pic').value;
      if(fileInput!="")
      {
        //alert(fileInput + "  "+ fileInput.split('.').pop().toLowerCase());
        var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
        if ($.inArray(fileInput.split('.').pop().toLowerCase(), fileExtension) == -1) {
            alert("Only formats are allowed : "+fileExtension.join(', '));
            return false;
            error=1;
        }
      }
    var charity_name=document.getElementById("charity_game_name").value;
 
 var address=document.getElementById("charity_address").value;
  var description=document.getElementById("charity_description").value;
 var contact=document.getElementById("charity_contact").value;
 var phone=document.getElementById("charity_phone").value;
 var taxid=document.getElementById("charity_tax").value;
 if(document.getElementById("charity_non-profit").checked==true)

 var nonprofit="Yes";
 else
 var nonprofit="No";

 if (charity_name== ''){

       alert('Please provide charity infomation!');
 }
 else if(error==0)
 {
    
    var fdata = new FormData();
    if($("#charity_pic")[0].files.length>0)
    {
        fdata.append("file",$("#charity_pic")[0].files[0]);
    }
    else
    {
        
        fdata.append("fileold",document.getElementById("picdata").value);
    }
    
    fdata.append("action","add");
    fdata.append("charity_name",charity_name);
    fdata.append("address",address);
    fdata.append("contact",contact);
    fdata.append("phone",phone);
    fdata.append("taxid",taxid);
    fdata.append("nonprofit",nonprofit);
    fdata.append("description",description);
    
    $.ajax({
        type: "POST",
        url: "ajax_charity.php",
        //data:{action:"add",charity_name:charity_name,address:address,contact:contact,phone:phone,taxid:taxid,nonprofit:nonprofit}, 
        data:fdata,
        contentType: false,
        processData: false,
        success: function(data){
            
            var res = data.split(":");
         if(res[0]>0)
         {
            alert("Charity Added");
            var hangoutButton = document.getElementById("closemodal");
             hangoutButton.click();
            var select = document.getElementById('charity_id');
            
            $("#charity_id").append("<option value='" + res[0] + "' selected >" + charity_name + "</option>");
            
            
           
        }
         else
         {
            alert(data);
         }
         
         
         
          
        }
      }); 
    
        

 
}
    
}
</script>
<style>
        h1 {
            font-size: 20px;
            color: #111;
        }

        .content {
            width: 80%;
            margin: 0 auto;
            margin-top: 50px;
        }

        .tt-hint,
        .city {
            
            
            outline: medium none;
        }

        .tt-dropdown-menu {
            
           /*position: absolute;*/
           z-index:1;
           min-width:250px;         
            text-align: left;
            padding:5px;
            background-color: #fff;
            border: 1px solid #ccc;
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-radius: 8px 8px 8px 8px;
            font-size: 18px;
            color: #111;
           
            background-color: #F1F1F1;
        }
        

.autocomplete:hover 
{
    background: white;
padding:5px;
}
</style>
    <script>
       function showResult(a,name,no)
       {
        //alert(name);
        $('#'+name).html("");
          $.ajax({
        type: "POST",
        url: "charityname.php",
        data:{val:a,action:"search",name:name,no:no}, 
        success: function(data){
            if(data!="")
            {
                //alert(data);
                 document.getElementById(name).style.display="block";
               $('#'+name).html(data);
               showResultafterblur(a,no);
            }
            else
            {
                document.getElementById(name).style.display="none";
                if(no=="modal")
                {
                    document.getElementById("charity_address").disabled=false;
                    document.getElementById("charity_description").disabled=false;
                    document.getElementById("charity_pic").disabled=false;
                    document.getElementById("imagecharity").style.display="block";
                    document.getElementById("imagecharity").src="assets/img/dcimage-1.png";
                    
                    document.getElementById("picdata").value="";
                    document.getElementById("charity_contact").disabled=false;
                    document.getElementById("charity_phone").disabled=false;
                    document.getElementById("charity_tax").disabled=false;
                    document.getElementById("charity_non-profit").disabled=false;
                    document.getElementById("charity_address").value="";
                    document.getElementById("charity_description").value="";
                      document.getElementById("charity_contact").value="";
                      document.getElementById("charity_phone").value="";
                     document.getElementById("charity_tax").value="";
                }
               
            }
        
          
        }
      }); 
       }
       function showResultafterblur(a,no)
       {
        
        
          $.ajax({
        type: "POST",
        url: "charityname.php",
        data:{val:a,action:"check"}, 
        success: function(data){
            if((data=="") || data=="0")
            {
               // alert(no);
                
                if(no=="modal")
                {
                    document.getElementById("charity_description").disabled=false;
                    document.getElementById("charity_address").disabled=false;
                    document.getElementById("charity_contact").disabled=false;
                     document.getElementById("charity_pic").disabled=false;
                    document.getElementById("imagecharity").style.display="block";
                    document.getElementById("imagecharity").src="assets/img/dcimage-1.png";
                    document.getElementById("picdata").value="";
                    document.getElementById("charity_phone").disabled=false;
                    document.getElementById("charity_tax").disabled=false;
                    document.getElementById("charity_non-profit").disabled=false;
                    document.getElementById("charity_address").value="";
                    document.getElementById("charity_description").value="";
                      document.getElementById("charity_contact").value="";
                      document.getElementById("charity_phone").value="";
                     document.getElementById("charity_tax").value="";
                }
                
                
            }
            
        
          
        }
      }); 
      }
            
       function enterval(a,b,c,d,e,f,g,divname,no,image)
       {
        if(no=="modal")
        {
            
            document.getElementById("charity_game_name").value=a;
             document.getElementById("charity_address").value=b;
             document.getElementById("charity_contact").value=c;
             document.getElementById("charity_phone").value=d;
             document.getElementById("charity_tax").value=e;
             document.getElementById("imagecharity").src=image;
             document.getElementById("charity_description").value=g;
             document.getElementById("picdata").value=image;
             
             
             if(f="yes")
             {
                document.getElementById("charity_non-profit").checked=true;
             }
             else
             {
                document.getElementById("charity_non-profit").checked=false;
             }
              document.getElementById("charity_address").disabled=true;
              document.getElementById("charity_description").disabled=false;
              document.getElementById("charity_contact").disabled=true;
               document.getElementById("charity_pic").disabled=true;
               document.getElementById("imagecharity").style.display="block";
              document.getElementById("charity_phone").disabled=true;
              document.getElementById("charity_tax").disabled=true;
              document.getElementById("charity_non-profit").disabled=true;
            
        }
   
        
         
         document.getElementById(divname).innerHTML="";
         document.getElementById(divname).style.display="none";
       }
       function hide()
       {
       
        document.getElementById("result").style.display="none";
        document.getElementById("result").innerHTML="";
       }
    </script>
   <!-- <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
-->
    <style>
    .tableth th,td
    {
        padding:5px;
        font-size: 14px;
        text-align: center;
    }
    </style>
    <script>
        
        $( "#gicdCharity" ).change(function() {
        if(($("#gicdCharity").val()>0)&& ($("#gicdCharity").val()<41))
        {
            var sum=100;
            var creator_earnings=$("#gicdCreator").val();   
            var charity=$("#gicdCharity").val();   

                var val = ((100 - charity)/3).toFixed(2);
  
        
         $("#gicdCharity").val(charity)/2;
       $("#gicdWinner").val(val);
         $("#gicdWinWin").val(val);
          $("#gicdCreator").val(val);
            
        }
        else
        {
            alert("Please enter the value less than 40");
            document.getElementById("gicdCharity").value="";
            document.getElementById("gicdCharity").focus();
            
        }
      
  });
    function done()
    {
        $('#loadermodal').modal('show');
        $('#loadermodal').modal({backdrop: 'static', keyboard: false})  
  
    var type=3;
    var name = $.trim($('#game_name').val());
    alert(name);
    var desc = $.trim($('#game_desc').val());
   var credit_cost = $.trim($('#credit_cost').val());
   
   var game_value = $.trim($('#game_value').val());
   var win_credit = $.trim($('#game_value').val());
   var enddate=document.getElementById("datepicker").value;
   var day=document.getElementById("day").value;
   var hour=document.getElementById("hour").value;
   var minute=document.getElementById("minute").value;
   var min_credit=document.getElementById("min_credit").value;
   var winner_option=document.getElementById("winner_option").value;
   if(enddate!="")
   {
    enddate+=" "+document.getElementById("publishhour").value+" : "+document.getElementById("publishmin").value+" "+document.getElementById("publishtime").value;
    //alert(enddate);
   }
   
   if($('#time_limitquiz').prop('checked')==true)
        {
            var gamerule=1;
            
        }
        else if($('#highest_answer').prop('checked')==true)
        {
            var gamerule=2;
        }
        else
        {
           var gamerule=3; 
        }
       
       //game icon
      var imageicon = document.getElementById('gameicon').value;
      if(imageicon!="")
      {
        //alert(fileInput + "  "+ fileInput.split('.').pop().toLowerCase());
        var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
        if ($.inArray(imageicon.split('.').pop().toLowerCase(), fileExtension) == -1)
         {
            alert("Only formats are allowed : "+fileExtension.join(', '));
           // document.getElementById("imagediv2").style.display="none";
             $('#loadermodal').modal('hide');
            return false;
        }
      }
      
      
    // Check if empty of not
    //alert(winner_option+"   min credit=="+min_credit);
    if (name  === ''|| credit_cost == '' || win_credit == '' || (day =='0' && hour=="0" && minute=='0' && winner_option!=2)|| (min_credit=="" && winner_option!=1)) {
        alert('Please Fill in the name ,credit cost , Game Duration ,time limit,rules,min credit and credit value of the game.');
        //document.getElementById("imagediv2").style.display="none";
         $('#loadermodal').modal('hide');
        return false;
        }
        
        var winner=parseFloat($("#gicdWinner").val());    
      var creator_earnings=parseFloat($("#gicdCreator").val());    
      var charity=parseFloat($("#gicdCharity").val());
      var winwin=parseFloat($("#gicdWinWin").val());
      
      var charity_id = $.trim($('#charity_id').val());
     //alert(charity_id);
      var level_game = $.trim($('#level_game').val());
      
      var fileInput2 = document.getElementById('gameicon');
      var file2= fileInput2.files[0];
      
      
      
      var fdata = new FormData()
      
      
      
       
       if($("#gameicon")[0].files.length>0)
       fdata.append("file2",$("#gameicon")[0].files[0]);
       
       //alert(game_value + " "+ day + " "+hour + "  "+minute);
       fdata.append("level",level_game);
       fdata.append("type",type);
       fdata.append("name",name);
       fdata.append("credit_cost",credit_cost);
       fdata.append("win_credit",game_value);
       fdata.append("charity_id",charity_id);
       fdata.append("desc",desc);
       fdata.append("charity",charity);
       fdata.append("winner",winner);
       fdata.append("winwin",winwin);
       fdata.append("creator_earnings",creator_earnings);
       fdata.append("enddate",enddate);
       fdata.append("day",day);
       fdata.append("hour",hour);
       fdata.append("minute",minute);
       fdata.append("min_credit",min_credit);
       fdata.append("winner_option",winner_option);
       fdata.append("gamerule",gamerule);
       fdata.append("game_id",'<?php echo $_REQUEST['id']?>');
       fdata.append("publishhour",document.getElementById("publishhour").value);
       
       
       $.ajax({
        type: "POST",
        url: "update_game.php",
        data:fdata,
        contentType: false,
        processData: false,
        //{file:$("#pic")[0].files[0],level:level_game,step:step_limit,type:type,name: name,credit_cost:credit_cost,win_credit:game_value,timelimit:timelimit,charity_id:charity_id,desc:desc ,charity: charity,winner:winner,winwin:winwin,creator_earnings:creator_earnings}, 
        success: function(data){
            //alert(data);
             if(data==1)
         {
            if(enddate!="")var end=" Due to this we are not saving your Publish Date ."
            else var end="";
            alert("Game Updated! But Charity selected by you is not approved by our site admin so you are not able to make it live. "+end+" We will inform on your mail when it has been approved");
         
            //alert(val[1]);
         }
         else
         {
             alert("Game Updated");
         }
             
         
         document.location="addquiz_new.php?id=<?php echo $_REQUEST['id']?>";
             
             
         
         
         //document.getElementById("imagediv").style.display="none";
        $('#loadermodal').modal('hide');
         
         // $('#success2').html(data);
          
        }
      }); 
      
        
    }
    
    </script>



