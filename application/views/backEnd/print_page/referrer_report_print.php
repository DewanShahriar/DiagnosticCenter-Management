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
        			<th style="width: 5%"><?php echo $this->lang->line('sl'); ?></th>
                    <th style="width: 15%"><?php echo $this->lang->line('issue_date'); ?></th>
                   
                    <th style="width: 20%"><?php echo $this->lang->line('invoice_number'); ?></th>
                    
                    <th style="width: 30%"><?php echo $this->lang->line('referred_by'); ?></th>
                    <th style="width: 15%"><?php echo $this->lang->line('total_bill'); ?></th>
                    <th style="width: 15%"><?php echo $this->lang->line('referrer_fee'); ?></th>
                    
                    
        		</tr>
                </thead>

                <tbody>
                    <?php
                        $sl = 1;
                        $grand_total = 0;
                        $referrer_total = 0;
                            foreach ($referrer_report_list as $key => $value) {
                                $grand_total += ($value->total_amount - $value->discount_amount);
                                $referrer_total += $value->referrer_fee;?>
                        <tr>
                            <td> <?php echo $sl++; ?> </td>
                            
                            <td> <?= date('d M Y',strtotime($value->issue_date)); ?> </td>
                            <td> <?= $value->invoice_number; ?> </td>
                            <td> <?= $value->firstname.' '.$value->lastname; ?> </td>
                            <td style="text-align: right; padding-right: 20px;"> <?= number_format($value->total_amount - $value->discount_amount, 2); ?> </td>
                            <td style="text-align: right; padding-right: 20px;"> <?= number_format($value->referrer_fee, 2); ?> </td>
                            
                        </tr>
                        <?php
                            }
                            ?>
                        <tr>
                            <td colspan="4" style="text-align: right; font-size: 20px; font-weight: bold;"> <?php echo $this->lang->line('total');?></td>
                            <td style="text-align: right; padding-right: 20px;font-size: 20px;"> <strong> <?php echo number_format($grand_total, 2) ; ?> </strong></td>
                            <td style="text-align: right; padding-right: 20px;font-size: 20px;"> <strong> <?php echo number_format($referrer_total, 2) ; ?> </strong></td>  
                             
                        </tr>
                </tbody>

        	</table>
        </div>



