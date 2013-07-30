<?php
   $action = $_REQUEST['action'];
	switch($action){
	 case 'insert':
	 add_filter("the_content", "insertsubjects");
	 break;
	 case 'update':
	 add_filter("the_content", "updatesubjects");
	 break;
	 case 'showdata':
	 add_filter("the_content","fetchall");
	 break;
	 case 'delete':
	 add_filter("the_content","deletesubject");
	 break;
	 case 'del':
	 add_filter("the_content","deletepaper");
	 break;
	 case 'edit':
	 add_filter("the_content","edit");
	 break;
	 case 'newpaper':
	 add_filter("the_content", "newpaper");
	 break;
	 case 'paperview':
	 add_filter("the_content", "viewpapers");
	 break;
	 case 'paperupdate':
	 add_filter("the_content", "updatepaper");
	 break;
	 case 'paperedit':
	 add_filter("the_content", "editpaper");
	 break;
	 case 'papersave':
	 add_filter("the_content", "savepaper");
	 break;
	 case 'delcomb':
	 add_filter("the_content", "deletecombination");
	 break;
	 case 'addcomb':
	 add_filter("the_content", "addcombination");
	 break;
	 case 'addpaper':
	 add_filter("the_content", "displaycombinationpapers");
	 break;
	 case 'combsubject':
	 add_filter("the_content", "othercombinationsubjects");
	 break;
	 }
function insertsubjects(){
	global $wpdb;
	 $table1=$wpdb->prefix."subject";

	$title = $_POST['title'];
	$level = $_POST['level'];
	$cat = $_POST['category'];
	$desc = $_POST['description'];
	
	$newdata = array(
	'sub_title' => $title,
	'level' => $level,
	'category' => $cat,
	'sub_desc' => $desc
	);
	$query1=$wpdb->insert($table1,$newdata);
	$wpdb->query($query1);
	if(!$query1){ return 'subject not created!'.$wpdb->print_error();
	}else{
		return 'subject created successfully!';	
		}
	}// close function insertsubjects
function subjectform(){ 
	?>
	<table align="center" bordercolor="#00FF00" border="2" width="600" bgcolor="#FFFFFF">
	<tr><td> <form action="?action=insert" method="POST" >
	Subject Title:<label> <input type="text" name="title" size="20" /></label> </td>
    <td>Category:<input type="radio" name="category" value="Science">Science
    		<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="category" value="Arts"/>Arts</p>
	</td></tr>
	<tr><td>Please add a Description:<textarea name="descritption" rows="5" cols="30" ></textarea>
 	</td><td> Level:<input type="radio" name="level" value="A">
    Advanced<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="radio" name="level" value="O"/>Ordinary</p></td></tr>
  <tr><td><input type="submit" value="Submit"/></p> </form></td></tr></table>

<?php
}	
function newcombination(){
	global $wpdb;
	echo "<table>";?>
    <tr><td>Combination Name:<form action="?action=addcomb" method="post">
    <input type="text" name="combname" value="eg: PEM/A"/></td>
    <td></td></tr>
    <tr><td> Description: <textarea name="combdescription" cols="6" rows="3"></textarea></td>
    <td> A combination must atleast have a Subject:
	<?php
	$table1=$wpdb->prefix."subject";
	$result = $wpdb->get_results("SELECT * FROM $table1 WHERE level='A' ");
	echo "<select name='subject'>";
	foreach($result as $row){
	$subjects = $row->sub_title;
	$subid = $row->sub_id;?>
    <option value='<?php echo $subjects;?>'> <?php echo $subjects; echo '</option>';}?> 
	</td></tr><tr><td><input type="hidden" value="<?php  echo $subid; ?>" name="subid"/>
    <input type='submit' value="Add"></form> </td></tr></table>		
	<?php 
	}	

function deletecombination(){
	global $wpdb;
	$table2=$wpdb->prefix."combination";
	$combid = $_REQUEST['id'];
	$result = $wpdb->query("DELETE FROM $table2 WHERE comb_id = $combid");
	if(!$result){ return 'data not deleted'.$wpdb->print_error().mysql_error();
	}else{
		echo 'data deleted';	
		}
	} // close function for deleting subjects
function addcombination(){
	global $wpdb;
	$table2 = $wpdb->prefix.'combination';
	$subid = $_POST['subid'];
	$combname = $_POST['combname'];
	$subject = $_POST['subject'];
	$combdesc = $_POST['combdescription'];
	
	$combdata = array(
	'comb_name' =>$combname,
	'subject' =>$subject,
	'sub_id' => $subid,
	'comb_desc' =>$combdesc
	);
	$query =$wpdb->insert($table2,$combdata);
	if(!$query){return 'couldnt becreated';}
	}
	
function othercombinationsubjects(){
	global $wpdb;
	$table2 = $wpdb->prefix.'combination';
	$subname = $_POST['subname'];
	$subid = $_POST['subid'];
	$combname = $_POST['combname'];
	$combdesc = $_POST['combdecription'];
	$combdata = array(
	'comb_name' =>$combname,
	'subject' =>$subname,
	'sub_id' => $subid,
	'comb_desc' =>$combdescription
	);
	$query =$wpdb->insert($table2,$combdata);
	if(!$query){return 'subjects not created';}
	else{ return 'subjects added';}
	}
function displaycombinationpapers(){ 	
	global $wpdb;
	$id= $_REQUEST['id'];
	$table1=$wpdb->prefix."subject";
	$table2=$wpdb->prefix."combination";
	$result1 = $wpdb->get_results("SELECT * FROM $table2 WHERE comb_id=$id;");
	$result2 = $wpdb->get_results("SELECT * FROM $table1 WHERE level='A' ");
	echo "<table>";
	foreach($result1 as $row){ $comb = $row->comb_name; $descript = $row->comb_desc;}
	echo "Add papers for this combination: ".$comb;
	echo "<tr><td>Available Subjects</td><td>";
	echo "<form action=?action=combsubject method='post'><select name='subname'>";
	foreach($result2 as $row){
		$subname =$row->sub_title; 
		$subid =$row->sub_id;
		echo "<option value= $subname>$subname</option>";}?>
		</td></tr><tr><td>
        <input name="subid" type="hidden" value="<?php echo $subid; ?>"/>
        <input name="combname" type="hidden" value="<?php echo $comb;?>"/>
        <input name="combdescript" type="hidden" value="<?php  echo $descript;?>"/>
        </td></tr><tr><td><input type="submit" value="Add" /></form></td></tr></table>
	<?php }
function displaycombinations(){
	global $wpdb;
	$table2=$wpdb->prefix."combination";
	$result = $wpdb->get_results("SELECT * FROM $table2 ORDER BY comb_name;");
	echo "<table >";
	echo "<tr><th>CombId</th><th>Combination</th><th>Subject</th><th>SubjectId</th>";
	echo "<th>AddPapers</th><th>Delete</th></tr>";
	foreach($result as $row){  $sub_id = $row->sub_id; $combid= $row->comb_id;
	//$id = $row->subid; $title = $row->subtitle; $num =$row->numpapers; $category = $row->category; $level= $row->level;
	echo "<tr><td>".$combid."</td><td>".$row->comb_name."</td><td>".$row->subject."</td>";
	echo "<td>".$row->sub_id."</td>";
	echo "<td><a href = '?action=addpaper&id=$combid '>AddPaper</a></td>";
	echo "<td><a href = '?action=delcomb&id=$combid ' onclick='javascript:return(confirm_delete())' title='Delete'>Delete</a></td></tr>";
	}
	echo "</table>";
			}
function updatesubjects(){
	global $wpdb;
	 $table1=$wpdb->prefix."subject";
	$sub_id = $_REQUEST['id'];
	
	$newtitle = $_POST['title'];
	$newlevel = $_POST['level'];
	$newcat = $_POST['category'];
	$newdesc = $_POST['description'];

	$subarray = array(
	'sub_title' =>$newtitle,
	'level' =>$newlevel,
	'category' =>$newcat,
	'sub_desc' =>$newdesc
	);
	$subwhere = array(
	'sub_id'=>$sub_id);
	$querysub =$wpdb->update($table1,$subarray,$subwhere);
	if(!$querysub){ return 'subject not updated!'.$wpdb->print_error().mysql_error();
	}else{
		return 'the subject was updated successfully!';	
		}
	}// close function updatesubjects	
		
function deletepaper(){
	global $wpdb;
	$table3=$wpdb->prefix."paper";
	$id = $_REQUEST['id'];
	$result = $wpdb->query("DELETE FROM $table3 WHERE paper_id = $id");
	if(!$result){ return 'data not deleted'.$wpdb->print_error().mysql_error();
	}else{
		echo 'data deleted';	
		}
	} // close function for deleting paper
function savepaper(){
	global $wpdb;
	$table3=$wpdb->prefix.'paper';
	$paper = $_POST['paper'];
	$paperdesc = $_POST['description'];
	$sub_id = $_POST['sub_id'];
	
	$paperdata = array(
	'paper_title' =>$paper,
	'paper_desc'=>$paperdesc,
	'subjectid' => $sub_id
	);
	$querry=$wpdb->insert($table3,$paperdata);
	if(!$querry){return 'Paper couldnt be added';}
	}
	
function deletesubject(){
	global $wpdb;
	$table1=$wpdb->prefix."subject";
	$id = $_REQUEST['id'];
	$result = $wpdb->query("DELETE FROM $table1 WHERE sub_id = $id");
	if(!$result){ return 'data not deleted'.$wpdb->print_error().mysql_error();
	}else{
		echo 'data deleted';	
		}
	} // close function for deleting subjects
	
function viewpapers(){
	global $wpdb;
	$sub_id = $_REQUEST['id'];
	$table1=$wpdb->prefix."subject";
	$table3=$wpdb->prefix."paper";
	$result1 = $wpdb->get_results("SELECT * FROM $table1 WHERE sub_id=$sub_id".mysql_error());
	$result3 = $wpdb->get_results("SELECT * FROM $table3 WHERE subjectid=$sub_id".mysql_error());
	echo '<table><tr><th>paper</th><th>description</th><th>Edit</th><th>Delete</th></tr>';		
	foreach($result1 as $row){ 
		$title= $row->sub_title;
		echo 'Papers under '.$title;
		$description=$row->sub_desc;
	foreach($result3 as $row){ 
	$paper = $row->paper_title;
	$paper_id = $row->paper_id;
	$desc = $row->paper_desc;
	echo '<tr><td>'.$paper.'</td><td>'.$desc.'</td>';
	echo "<td width='60'><a href='?action=paperedit&id=$paper_id'>Edit</a></td>";
	echo "<td><a href='?action=del&id=$paper_id'>Delete</a></td></tr>";
	} }echo '</table>';
		}
function updatepaper(){
	global $wpdb;
	 $table3=$wpdb->prefix."paper";
	$id = $_POST['paperid'];
	$newpapertitle = $_POST['paper'];
	$newpaperdesc = $_POST['description'];
	$newdata = array( 
	'paper_title'=> $newpapertitle,
	'paper_desc' => $newpaperdesc
	);
	$where = array(
	'paper_id' => $id);
	$query2=$wpdb->update($table3,$newdata,$where);
	//$query1 ="INSERT INTO $table1(subid,subtitle,numpapers,level,category,subdesc) 
	//VALUES('',)";

	if(!$query2){ return 'subject paper not updated!'.$wpdb->print_error().mysql_error();
	}else{
		return 'the subject paper was updated successfully!';	
		}
	}// close function updatepaper	
		
function insertpaper(){
	global $wpdb;
	$sub_id = $_POST['sub_id'];
	$table1=$wpdb->prefix."subject";
	$table3=$wpdb->prefix."paper";
	$result = $wpdb->get_results("SELECT * FROM $table1 WHERE sub_id=$sub_id".mysql_error());
	foreach($result as $row){ 
		$title= $row->sub_title;
		$description=$row->subdesc;
		}
	$paper = $_POST['paper'];
	$description = $_POST['description'];
	$sub_id = $_POST['sub_id'];
	$paperdata = array(
	'paper_title' => $paper,
	'paper_desc' => $description,
	'subjectid' => $sub_id
	);
	$query1 =$wpdb->insert($table3,$paperdata);	
	$wpdb->query($query1);
	if(!$query1){ 
		echo 'One '.$title.' paper not inserted'.$wpdb->print_error();
		}else{
		echo 'paper was added succesfully';
		}
	}// close function insertpaper

function editpaper(){
	global $wpdb;
	$table3=$wpdb->prefix."paper";
	$id = $_REQUEST['id'];
	echo 'Edit this paper';
	$array_n = $wpdb->get_row("SELECT * FROM $table3 WHERE paper_id=$id",ARRAY_N);
		$id= $array_n[0];		
		?>
        <form action="?action=paperupdate" method="post">
        <table><input type="hidden" name="paperid" value="<?php echo $id;?>"/>
        <tr><td>Paper Name: <input type="text" size="20" value="<?php echo $array_n[1];?>" name="paper"/> </td></tr>
        <tr><td>Add a Description of this paper: <textarea cols="10" rows="5" value="<?php echo $array_n[2];;?>" name="description"> 
        </textarea></td></tr>
        <tr><td><input type="submit" value="UpdatePaper" /> </td></tr></table></form>
		 <?php
		 } // close function editpapers()

function newpaper(){
	global $wpdb;
	$table1=$wpdb->prefix."subject";
	$sub_id = $_REQUEST['id'];
	$array_n = $wpdb->get_row("SELECT * FROM $table1 WHERE sub_id=$sub_id", ARRAY_N); 
		$title= $row->sub_title;
		echo 'Add a paper for this subject '.$array_n[1];		
		?>
        <form action="?action=papersave" method="post">
        <table><tr><td>Paper Name: <input type="text" size="20" value="paper one" name="paper"/> </td></tr>
        <tr><td>Add a Description of this paper: <textarea cols="10" rows="5" name="description"> </textarea></td></tr>
        <input type="hidden" name="sub_id" value="<?php echo $sub_id;?>" />
        <tr><td><input type="submit" value="AddPaper" /> </td></tr></table></form>
		 <?php
		 } // close function newpapers()

function createcombinations(){
	global $wpdb;
	$table1=$wpdb->prefix."subject";
	$result = $wpdb->get_results("SELECT * FROM $table1 WHERE level='A' ");
		 ?><table><tr><th> Check Subject(s)</th><th>Subjects</th></tr>
		<tr><td width="10"> <form action="?action=addcomb" method="get"> 
		<?php foreach($result as $row){$title =$row->sub_title; ?>
		<input type="checkbox" name="$title"/> </td><td><?php  echo $title;}?> </td></tr>
        <tr><td><input type="submit" value="AddCombination" /></td></tr></table></form>
			<?php	}
function edit(){
	global $wpdb;
	$table1=$wpdb->prefix."subject";
	$id = $_REQUEST['id'];
	$result = $wpdb->get_results("SELECT * FROM $table1 WHERE sub_id= $id");
	foreach($result as $row){ 
		$title= $row->sub_title;
		$description=$row->sub_desc;
		}
	       /*if(!$result){ return 'data not retrieved'.$wpdb->print_error().mysql_error();
		   }else{\
		   eturn 'data retrived';
		   }*/
		   ?>
	<table>
    <tr><td>Update a Subject</td><td></td>
	<tr><td> <form action="?action=update&id=<?php echo $id;?>" method="POST" >
	Subject Title:<input type="text" name="title" size="20" value= "<?php echo $title;?>" /></td>
    <td>Category:<input type="radio" name="category" value="Science">Science
    		<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="category" value="Arts"/>Arts</p> </td> </tr>
	<tr><td>Please add a Description:<textarea name="descritption" rows="5" cols="30" ></textarea>
 	</td><td> Level:<input type="radio" name="level" value="A">
    Advanced<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="radio" name="level" value="O"/>Ordinary</p></td></tr>
 	<tr><td><input type="submit" value="Submit"/></p> </form></td></tr></table>
       
   	<?php
	} 	
function fetchall(){
	global $wpdb;
	$table1=$wpdb->prefix."subject";
	$result = $wpdb->get_results("SELECT * FROM $table1;");
	echo "<table>";
	echo "<tr><th>Title</th><th>Description</th><th>Category</th><th>Level</th>";
	echo "<th>Edit</th><th>AddPapers</th><th>ViewPapers</th><th>Delete</th></tr>";
	foreach($result as $row){  $sub_id = $row->sub_id; 
	//$id = $row->subid; $title = $row->subtitle; $num =$row->numpapers; $category = $row->category; $level= $row->level;
	echo "<tr><td>".$row->sub_title."</td><td>".$row->sub_desc."</td>";
	echo "<td>".$row->category."</td><td>".$row->level."</td>";
	echo "<td><a href = '?action=edit&id=$sub_id'>Edit</a></td>";
	echo "<td align='center'><a href = '?action=newpaper&id=$sub_id'>AddPaper</a></td>";
	echo "<td><a href = '?action=paperview&id=$sub_id'>ViewPapers</a></td>";
	echo "<td><a href = '?action=delete&id=$sub_id'>Delete</a></td></tr>";
	}
	echo "</table>";
			}			
function createtables(){
	global $wpdb;
	$table1=$wpdb->prefix."subject";
	$CreateTable1="CREATE TABLE IF NOT EXISTS $table1(
	sub_id int(3) NOT NULL AUTO_INCREMENT,
	sub_title varchar(30) NOT NULL,
	level varchar(10) NOT NULL,
	category varchar(10) NOT NULL,
	sub_desc varchar(100) NOT NULL,
	UNIQUE KEY id (sub_id)
	);";
	
	$table2=$wpdb->prefix."combination";
	$CreateTable2="CREATE TABLE IF NOT EXISTS $table2(
	comb_id int(3) NOT NULL AUTO_INCREMENT,
	comb_name varchar(10) NOT NULL,
	subject varchar(30) NOT NULL,
	sub_id int(3) NOT NULL,
	comb_desc varchar(100),
	UNIQUE KEY id (comb_id)
	);";
	
	global $wpdb;
	$table3=$wpdb->prefix."paper";
	$CreateTable3="CREATE TABLE IF NOT EXISTS $table3(
	paper_id int(3) NOT NULL AUTO_INCREMENT,
	paper_title varchar(30) NOT NULL,
	paper_desc varchar(100) NOT NULL,
	subjectid int(3) NOT NULL,
	UNIQUE KEY id (paper_id)
	);";
	
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $CreateTable1 ); 
	dbDelta( $CreateTable2 );
	dbDelta( $CreateTable3 );
		}	// close function createtables
      // THE END
		?> 
