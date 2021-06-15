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
                <th style="width: 40%;"><?php echo $this->lang->line('test_name'); ?></th>
                <th style="width: 25%;"><?php echo $this->lang->line('test_category'); ?></th>
                <th style="width: 15%;"><?php echo $this->lang->line('price'); ?></th>
                <th style="width: 15%;"><?php echo $this->lang->line('referral_commission'); ?></th>
                
                
    		</tr>
            </thead>

            <tbody>
                <?php 
                    $sl = 1;
                    foreach ($test_name_list as $value) {
                        ?>
                <tr>
                    <td> <?php echo $sl++ ; ?> </td>
                    <td> <?php echo $value->test_name; ?> </td>
                    <td> <?php echo $value->category_name; ?> </td>
                    <td> <?php echo $value->price; ?> </td>
                    <td> <?php echo $value->referral_commission; ?> </td>
                    
                    
                </tr>
                <?php
                    }
                    ?>
            </tbody>

    	</table>
    </div>



