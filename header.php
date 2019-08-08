<?php
//session_start();
header("Content-Type: text/html; charset=utf-8"); 
//if($_SESSION["username"] == ''){
  //header('Location: login.php');
 // exit();
//}

  ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> New Document </TITLE>
<META NAME="Generator" CONTENT="EditPlus">
<META NAME="Author" CONTENT="">
<META NAME="Keywords" CONTENT="">
<META NAME="Description" CONTENT="">
<meta charset="windows-874">

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/css_menu.css" rel="stylesheet">
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>


        
        <script>
        tinymce.init({
            selector: "textarea",theme: "modern",width: 680,height: 100,
            plugins: [
                 "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                 "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                 "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
           ],
           toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
           toolbar2: "| link unlink  | forecolor backcolor  ",
           image_advtab: false ,

           external_filemanager_path:"./filemanager/",
           filemanager_title:"Responsive Filemanager" ,
           external_plugins: { "filemanager" : "../filemanager/plugin.min.js"}
           ,relative_urls:false,
           remove_script_host:false,
           document_base_url:"http://localhost/",
           statusbar: false
         });
        </script>

<style>
.ui-datepicker-trigger{cursor:pointer}

.modal-body {
	left:10pt;
    position: relative;
    overflow-y: auto;
    max-height: 700pt;
	max-width:auto;
	height:auto;
	padding: 15px;
	margin-left:10pt;
	margin-right:10pt;
}

</style>

</head>
<body>
<div id="throbber" style="display:none; min-height:120px;"></div>
<div id="noty-holder"></div>
<div id="wrapper">
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="navbar-header">
        <ul class="nav navbar-right top-nav">
          <li style="font-size:24px;">
              <a href="index.php" class="dropdown-toggle" data-toggle="dropdown">ระบบจัดการหน้าร้าน</b></a>

          </li>
        </ul>
        </div>
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">
                <li>
                    <a href="index.php"><i class="glyphicon glyphicon-folder-open" style="padding-right:10px;"></i> <b>หน้าหลัก</b></a>
                </li>
                <li><a href="index.php"><i class="glyphicon glyphicon-globe"  style="padding-right:10px;"></i> ข้อมูลหลัก</a></li>
                    <li class="submenu"><a href="shop.index.php"><i style="padding-right:30px;"></i><i class="glyphicon glyphicon-option-vertical" style="padding-right:10px;"></i> Setup Shop</a></li>
                    <li class="submenu"><a href="foodmenu.index.php"><i style="padding-right:30px;"></i><i class="glyphicon glyphicon-option-vertical" style="padding-right:10px;"></i> รายการอาหาร</a></li>
                    <li class="submenu"><a href="foodmenu.favorite.php"><i style="padding-right:30px;"></i><i class="glyphicon glyphicon-option-vertical" style="padding-right:10px;"></i> รายการที่ชื่นชอบ</a></li>
				    <li class="submenu"><a href="table.php"><i style="padding-right:30px;"></i><i class="glyphicon glyphicon-option-vertical" style="padding-right:10px;"></i> โต๊ะ-คิว</a></li>
				    <li class="submenu"><a href="employee.index.php"><i style="padding-right:30px;"></i><i class="glyphicon glyphicon-option-vertical" style="padding-right:10px;"></i> จัดการพนักงาน</a></li>
				    <li class="submenu"><a href="cashdrawer.php"><i style="padding-right:30px;"></i><i class="glyphicon glyphicon-option-vertical" style="padding-right:10px;"></i> เงินในลิ้นชัก</a></li>
				                    
                <li><a href="#"><i class="glyphicon glyphicon-leaf"  style="padding-right:10px;"></i> รายงาน </a></li>
                    <li class="submenu"><a href="rpt.media.php"><i style="padding-right:30px;"></i><i class="glyphicon glyphicon-option-vertical" style="padding-right:10px;"></i>รายงานการขาย </a></li>
                <li><a href="logout.php"><i class="glyphicon glyphicon-log-out" style="padding-right:10px;"></i>Logout</a></li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>

<?php
date_default_timezone_set('asia/bangkok');
 ?>
