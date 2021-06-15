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

    <div>
    	<table>
            <thead>
                
    		<tr style="  font-weight: bold;font-size: 20px;">
    			<th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                <th style="width: 45%;"><?php echo $this->lang->line('account_head'); ?></th>
                <th style="width: 30%;"><?php echo $this->lang->line('description'); ?></th>
                <th style="width: 10%;"><?php echo $this->lang->line('quantity'); ?></th>
                <th style="width: 10%;"><?php echo $this->lang->line('amount'); ?></th>
    		</tr>
            </thead>

            <tbody>
                <?php
                            $total = 0;
                                foreach ($accounts_details as $key => $value) {
                                    $total += $value->amount; ?>
                            <tr>
                                <td> <?php echo ++$key; ?></td>
                                <td> <?php echo $value->account_head ; ?> </td>
                                <td> <?php echo $value->description; ?> </td>
                                <td> <?php echo $value->quantity; ?> </td>
                                <td style="text-align: right; padding-right: 20px;"> <?php echo number_format($value->amount, 2) ; ?> </td>
                                 
                            </tr>
                            <?php
                                }
                                ?>
                            <tr>
                                <td colspan="4" style="text-align: right; font-size: 20px; font-weight: bold;padding-right: 20PX"> <?php echo $this->lang->line('total');?></td>
                                <td style="text-align: right; padding-right: 20px;font-size: 20px;"> <strong> <?php echo number_format($total, 2) ; ?> </strong></td>   
                                 
                            </tr>
                
            </tbody>

    	</table>
    </div>



