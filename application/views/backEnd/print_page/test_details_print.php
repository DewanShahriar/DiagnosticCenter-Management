<!DOCTYPE html>
<html lang="eng">
<head>
	<title>ABC Diagnostic Center</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width initial-scale=1.0" >
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<style>
		table{
			color: #000;
			font-size: 16px;
			text-align: center;
			border-collapse: collapse;
			width: 100%;}

				td{
			border:1px solid #000;
			padding: none
		 
		}
        table th{
            border:1px solid #000;
        }
		@media print {

		      table {  
		      max-height: 100%;
		      overflow: hidden;
		      page-break-after: always;
		             }
                      
	</style>
	<body>
	<div style="text-align: center;">
	 
		<h1 style="margin:5px 0 ;">ABC Diagonostic Center</h2>
		  <label for="fname">Address:</label>
          <input type="text" style="border:none;border-bottom:1px solid #000;"><br>

           <label for="fname">Phone:</label>
          <input type="text" style="border:none;border-bottom:1px solid #000; " name="phone"><br><br>
	  
    </div>
    <div class="col-md-12">
        <div class="col-md-6">
            <center style="margin-top: 0px;margin-bottom: 15px;">
                 <span style="border-bottom: 2px solid #00c0ef;text-align: center;font-size: 20px;color: #46808e;"><?php echo $this->lang->line('test_info'); ?></span>
            </center>
            <ul>
                 <li class=""><b><?php echo $this->lang->line('invoice_number'); ?></b><a class="pull-right"><?php echo $test->invoice_number;?></a>
                </li>
                <li class=""><b><?php echo $this->lang->line('issue_date'); ?></b><a class="pull-right"><?php echo date('d M Y', strtotime($test->issue_date));?></a>
                </li>
                <li class=""><b><?php echo $this->lang->line('referred_by'); ?></b><a class="pull-right"><?php echo $test->firstname. ' '. $test->lastname;?></a>
                </li>
                
                <li class=""><b><?php echo $this->lang->line('insert_time'); ?></b><a class="pull-right"><?php echo date('d M Y h:s A', strtotime($test->insert_time));?></a>
                </li>
                
            </ul>
        </div>
        <div class="col-md-6">
            <center style="margin-top: 0px;margin-bottom: 15px;">
                 <span style="border-bottom: 2px solid #00c0ef;text-align: center;font-size: 20px;color: #46808e;"><?php echo $this->lang->line('patient_info'); ?></span>
            </center>
            <ul>
                <li class=""><b><?php echo $this->lang->line('patient_name'); ?></b><a class="pull-right"><?php echo $test->patient_name;?></a>
                </li>
                <li class=""><b><?php echo $this->lang->line('patient_phone'); ?></b><a class="pull-right"><?php echo $test->patient_phone;?></a>
                </li>
                <li class=""><b><?php echo $this->lang->line('father_name'); ?></b><a class="pull-right"><?php echo $test->father_name;?></a>
                </li>
                <li class=""><b><?php echo $this->lang->line('mother_name'); ?></b><a class="pull-right"><?php echo $test->mother_name;?></a>
                </li>
                <li class=""><b><?php echo $this->lang->line('patient_nid'); ?></b><a class="pull-right"><?php echo $test->patient_nid;?></a>
                </li>
                <li class=""><b><?php echo $this->lang->line('birth_date'); ?></b><a class="pull-right"><?php echo date('d M Y', strtotime($test->birth_date));?></a>
                </li>
                <li class=""><b><?php echo $this->lang->line('address'); ?></b><a class="pull-right"><?php echo $test->address;?></a>
                </li>
            </ul>
        </div>
                        
    </div>

    <div>
    	<table>
            <thead>
                
    		<tr style="  font-weight: bold;font-size: 20px;">
    			<th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                <th style="width: 45%;"><?php echo $this->lang->line('test_name'); ?></th>
                <th style="width: 20%;"><?php echo $this->lang->line('report_publish_date'); ?></th>
                <th style="width: 15%;"><?php echo $this->lang->line('referrer_fee'); ?></th>
                <th style="width: 15%;"><?php echo $this->lang->line('price'); ?></th>
    		</tr>
            </thead>

            <tbody>
                <?php
                    $total = 0;
                        foreach ($test_details as $key => $value) {
                            $total += $value->test_bill; ?>
                    <tr>
                        <td> <?php echo ++$key; ?></td>
                        <td> <?php echo $value->test_name ; ?> </td>
                        <td> <?php echo date('d M Y', strtotime($value->report_publish_date )); ?> </td>
                        <td> <?php echo $value->referrer_fee; ?> </td>
                        <td style="text-align: right; padding-right: 20px;"> <?php echo number_format($value->test_bill, 2) ; ?> </td>
                         
                    </tr>
                    <?php
                        }
                        ?>
                    <tr>
                        <td colspan="4" style="text-align: right; font-size: 20px; font-weight: bold;padding-right: 20px;"> <?php echo $this->lang->line('total');?></td>
                        <td style="text-align: right; padding-right: 20px;font-size: 20px;"> <strong> <?php echo number_format($total, 2) ; ?> </strong></td>
                        
                         
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: right; font-size: 20px; font-weight: bold;padding-right: 20px;"> <?php echo $this->lang->line('discount_amount');?></td>
                        <td style="text-align: right; padding-right: 20px;font-size: 20px;"> <strong> <?php echo number_format($test->discount_amount, 2) ; ?> </strong></td>  
                         
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: right; font-size: 20px; font-weight: bold;padding-right: 20px;"> <?php echo $this->lang->line('payable');?></td>
                        <td style="text-align: right; padding-right: 20px;font-size: 20px;"> <strong> <?php echo number_format(($total - $test->discount_amount), 2) ; ?> </strong></td>  
                         
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: right; font-size: 20px; font-weight: bold;padding-right: 20px;"> <?php echo $this->lang->line('paid_amount');?></td>
                        <td style="text-align: right; padding-right: 20px;font-size: 20px;"> <strong> <?php echo number_format($paid_amount, 2) ; ?> </strong></td>  
                         
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: right; font-size: 20px; font-weight: bold;padding-right: 20px;"> <?php echo $this->lang->line('due');?></td>
                        <td style="text-align: right; padding-right: 20px;font-size: 20px;"> <strong> <?php echo number_format(($total- $test->discount_amount - $paid_amount), 2) ; ?> </strong></td>  
                         
                    </tr>
                
            </tbody>

    	</table>
    </div>



