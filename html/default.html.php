<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>Data Migrate</title>

    <!-- Bootstrap -->
    <link href="html/public/bootstrap-v3/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
	<div class="container">
		<div class="row" style="text-align:center;border-bottom:2px solid grey;margin-bottom:20px;">
			<h3>数据移植</h3>
		</div>
		<div class="row" style="text-align:left;border-bottom:2px solid grey;margin-bottom:20px;">
			<div style="margin-bottom:15px;">
			<a href="index.php?exec=check" class="btn btn-primary">先检测唯一字段</a>
			<a href="index.php?exec=update" class="btn btn-primary">修改列</a>
			<a href="index.php?exec=viewlog" class="btn btn-primary">查看今天LOG</a>
			</div>
		</div>
		<!-- 导入信息 -->
		<div class="row">
			<div class="col-md-5">
				<h5>基本信息</h5>
				<table class="table table-striped">
					<tr>
						<td>总行数</td>
						<td><?php echo $highestRow;?></td>
					</tr>
					<tr>
						<td>总列数</td>
						<td><?php echo $highestColumnIndex;?></td>
					</tr>
					<?php if($cols_array){ ?>
							<tr class="success">
								<td>Column ID</td>
								<td>Column Title</td>
							</tr>
					<?php	foreach($cols_array as $k=>$v){	?>
							<tr>
								<td><?php echo $k; ?></td>
								<td><?php echo $v; ?></td>
							</tr>
					<?php 
						}
					}
					?>
				</table>
			</div>
			<div class="col-md-7">
			<?php 
		
			if($showpage == 'default'){ ?>
				
			<?php }else if($showpage == 'update'){ ?>
				<?php if($logfile){ ?>
					<div style="margin-bottom:15px;"><a href="<?php echo $logfile;?>"><?php echo $logfile; ?></a></div>
				<?php } ?>
				<form action="index.php?exec=update" method="post">
				<!--
				  <div class="form-group">
					<label for="exampleInputEmail1">Email address</label>
					<input type="text" class="form-control" id="email" name="email" placeholder="Email">
				  </div>
				  -->
				  <div class="form-group">
					<label for="exampleInputEmail1">修改列Title</label>
					<input type="text" class="form-control" id="tablecolumn" name="tablecolumn" placeholder="列名">
				  </div>
				   <div class="form-group">
					<label for="exampleInputEmail1">列名序号</label>
					<input type="text" class="form-control" id="tablecolumn_id" name="tablecolumn_id" placeholder="列序号" value="">
				  </div>
				  <!--
				  <div class="form-group">
					<label for="exampleInputEmail1">唯一列名Title</label>
					<input type="text" class="form-control" id="tablecolumn_base" name="tablecolumn_base" placeholder="列名">
				  </div>
				   <div class="form-group">
					<label for="exampleInputEmail1">唯一列名序号</label>
					<input type="text" class="form-control" id="tablecolumn_id" name="tablecolumn_base_id" placeholder="列序号" value="">
				  </div>
				  -->
				  <div class="form-group">
					<label for="exampleInputEmail1">修改表名</label>
					<input type="text" class="form-control" id="tablename" name="tablename" placeholder="表名" >
				  </div>
				  <div class="form-group">
					<label for="exampleInputEmail1">修改字段名</label>
					<input type="text" class="form-control" id="fieldname" name="fieldname" placeholder="字段名" >
				  </div>
				  <!--
				  <div class="checkbox">
					<label>
					  <input type="checkbox"> Check me out
					</label>
				  </div>
				  -->
				  <input type="hidden" name="exec" value="update" />
				  <button type="submit" class="btn btn-default">EXECUTE</button>
				</form>
			<?php }else if($showpage == 'check'){ ?>
				<?php if($logfile){ ?>
					<div style="margin-bottom:15px;"><a href="<?php echo $logfile;?>"><?php echo $logfile; ?></a></div>
				<?php } ?>
				<form action="index.php?exec=check" method="post">
				  <div class="form-group">
					<label for="exampleInputEmail1">检测列名</label>
					<input type="text" class="form-control" id="email" name="tablecolumn" placeholder="列名" value="<?php echo $check_table_column;?>">
				  </div>
				  <div class="form-group">
					<label for="exampleInputEmail1">检测列名序号</label>
					<input type="text" class="form-control" id="email" name="tablecolumn_id" placeholder="列序号" value="<?php echo $check_table_column_id;?>">
				  </div>
				  <div class="form-group">
					<label for="exampleInputEmail1">表名</label>
					<input type="text" class="form-control" id="tablename" name="tablename" placeholder="表名" value="<?php echo $check_table;?>">
				  </div>
				  <div class="form-group">
					<label for="exampleInputEmail1">字段名</label>
					<input type="text" class="form-control" id="fieldname" name="fieldname" placeholder="字段名" value="<?php echo $check_field;?>">
				  </div>
				  
				  <input type="hidden" name="exec" value="check" />
				  <button type="submit" class="btn btn-default">Check</button>
				</form>
			<?php } ?>
			</div>
		</div>
		<!-- end 导入信息 -->
		  
	</div>
  </body>
    <script src="html/public/bootstrap-v3/js/jquery.min.1.12.4.js"></script>
    <script src="html/public/bootstrap-v3/js/bootstrap.min.js"></script>
</html>