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
                <ul>
                    <?php if($start_date){?>
                <li><b><?php echo $this->lang->line('start_date'); ?></b><a class="pull-right"><?php echo date('d M Y', strtotime($start_date));?></a></li>
                <?php }?>
            </ul>
                
            </div>
            <div class="col-md-6">
                <ul>
                <?php if($end_date){?>
                <li><b><?php echo $this->lang->line('end_date'); ?></b><a class="pull-right"><?php echo date('d M Y', strtotime($end_date));?></a></li>
                <?php }?>
            </ul>
                
            </div>

            
        </div>
    

        <div>
        	<table>
                <thead>
                    
        		<tr style="  font-weight: bold;font-size: 20px;">
        			<th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                    <th style="width: 10%;"><?php echo $this->lang->line('issue_date'); ?></th>

                    <th style="width: 15%;"><?php echo $this->lang->line('patient_name'); ?></th>
                    <th style="width: 10%;"><?php echo $this->lang->line('invoice_number'); ?></th>
                    <th style="width: 10%;"><?php echo $this->lang->line('referred_by'); ?></th>
                    <th style="width: 10%;"><?php echo $this->lang->line('total_amount'); ?></th>
                    <th style="width: 10%;"><?php echo $this->lang->line('discount_amount'); ?></th>
                    <th style="width: 10%;"><?php echo $this->lang->line('payable'); ?></th>
                    
                    
        		</tr>
                </thead>

                <tbody>
                    <?php
                    $grand_total = 0;
                            $discount_total = 0;
                            $payable_total = 0;
                        foreach ($tests_list as $key => $value) {
                            
                            $grand_total += $value->total_amount;
                            $discount_total += $value->discount_amount;
                            $payable_total += $value->total_amount-$value->discount_amount;
                            ?>
                    <tr>
                        <td> <?php echo ++$key; ?></td>
                        <td> <?php echo date('d M Y', strtotime($value->issue_date)); ?></td>
                        <td> <?php echo $value->patient_name ; ?> </td>
                        <td> <?php echo $value->invoice_number; ?> </td>
                        <td> <?php echo $value->firstname.' '. $value->lastname; ?> </td>
                        <td style="text-align: right; padding-right: 20px;"> <?php echo number_format((float)$value->total_amount, 2, '.', '') ; ?> </td>
                        <td style="text-align: right; padding-right: 20px;"> <?php echo number_format((float)$value->discount_amount, 2, '.', '') ; ?> </td>
                        <td style="text-align: right; padding-right: 20px;"> <?php echo number_format((float)$value->total_amount-$value->discount_amount, 2, '.', '') ; ?> </td>
                        

                         
                    </tr>
                    <?php
                        }
                        ?>
                        <tr>
                            <td colspan="5" style="text-align: right; font-size: 20px; font-weight: bold;padding-right: 20PX"> <?php echo $this->lang->line('total');?></td>
                            <td style="text-align: right; padding-right: 20px;font-size: 20px;"> <strong> <?php echo number_format($grand_total, 2) ; ?> </strong></td>
                            <td style="text-align: right; padding-right: 20px;font-size: 20px;"> <strong> <?php echo number_format($discount_total, 2) ; ?> </strong></td>   
                            <td style="text-align: right; padding-right: 20px;font-size: 20px;"> <strong> <?php echo number_format($payable_total, 2) ; ?> </strong></td>   
                             
                        </tr>
                </tbody>

        	</table>
        </div>



