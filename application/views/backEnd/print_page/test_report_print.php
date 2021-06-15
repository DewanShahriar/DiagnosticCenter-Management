<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Table page</title>
		<style>
			table{
				width: 100%;
				border-collapse: collapse;
			}
			table tr th, table tr td{
               text-align: center;
               border:1px solid #000;
               padding: 5px;
			}
            .table_one tr td{
               text-align: left;
               border:none;
			}
			.table_two tr td{
				text-align: left;
				border:none;
			}
			.table_one .txt_width{
				width: 40px;
			}
			.table_two .txt_width{
				width: 80px;
				text-align: right;
			}
			.dot_width{
				width: 10px;
			}
		</style>
	</head>
	<body>
		<div style="width:100%;text-align:right;padding-top:120px;">
			Print Date: <?php echo date('d M Y h:i A');?>
		</div>
		<hr>
		<div style="width: 100%;">
			<div style="width: 60%;float:left">
				<table class="table_one">
					<tbody>
						<tr>
							<td class="txt_width">Name</td>
							<td class="dot_width">:</td>
							<td><?php echo $patient_details->patient_name;?></td>
						</tr>
						<tr>
							<td class="txt_width">Phone</td>
							<td class="dot_width">:</td>
							<td><?php echo $patient_details->patient_phone;?></td>
						</tr>
						<tr>
							<td class="txt_width">Father</td>
							<td class="dot_width">:</td>
							<td><?php echo $patient_details->father_name;?></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div style="width: 40%;float:right;">
				<table class="table_two">
					<tbody>
						<tr>
							<td class="txt_width">ID</td>
							<td class="dot_width">:</td>
							<td><?php echo $test_invoice;?></td>
						</tr>
						<tr>
							<td class="txt_width">Gender</td>
							<td>:</td>
							<td><?php echo $patient_details->gender;?></td>
						</tr>
						<tr>
							<td class="txt_width">Age</td>
							<td>:</td>
							<td><?php echo (date('Y') - date('Y',strtotime($patient_details->birth_date)));?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<hr style="background-color:#000;">
		<div style="width:100%;text-align: center;font-size:32px;padding-top:15px; padding-bottom:20px;font-weight: bold;">
			<?php echo $test_name.' REPORT';?>
		</div>
		<div style="width:100%;">
			<?php echo $test_details_report;?>
		</div>
		<div style="width:100%;">
			<div style="width:50%;float:left;">
				<p style="font-size:18px;border-bottom: 1px solid #000;display: inline-block; margin-top:40px;margin-bottom:0px;">Checked By</p>
				<p>Dr.Abdul Kashem <br>
				Sr.Asst.Professor <br>
				Dhaka Medical College</p>
			</div>
			<div style="width:50%;float:right; text-align: right;">
				<p style="font-size:18px;border-bottom: 1px solid #000;display: inline-block; margin-top:40px;margin-bottom:0px;">Authorised By</p>
				<p>Dr.Abdul Kashem <br>
				Sr.Asst.Professor <br>
				Dhaka Medical College</p>
			</div>
			
		</div>
		
	</body>
</html>