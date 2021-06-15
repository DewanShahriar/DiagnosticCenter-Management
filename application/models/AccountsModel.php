<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
	class AccountsModel extends CI_Model{
		
	// $returnmessage can be num_rows, result_array, result
	public function isRowExist($tableName,$data, $returnmessage, $user_id = NULL){
	
		$this->db->where($data);
		if($user_id !== NULL) {
			$this->db->where('userId',$user_id);
		}
		if($returnmessage == 'num_rows'){
			return $this->db->get($tableName)->num_rows();

		}else if($returnmessage == 'result_array'){
			return $this->db->get($tableName)->result_array();

		}else{
			return $this->db->get($tableName)->result();
		}
	}

	// saveDataInTable table name , array, and return type is null or last inserted ID.
	public function saveDataInTable($tableName, $data, $returnInsertId = 'false'){
	
		$this->db->insert($tableName,$data);
		if($returnInsertId == 'true'){
			return $this->db->insert_id();

		}else{
			return -1;
		}
	}
	
	//Check Campaign Ambigus
	public function check_campaign_ambigus($start_date, $end_date){
				
		if(date_format(date_create($start_date),"Y-m-d") > date_format(date_create($end_date),"Y-m-d")){
			return -2;
		}

		$this -> db -> limit(1);
		$this -> db -> where('end_date >=', $start_date);
		$this -> db -> where('available_status', 1);
		$query = $this->db->get('create_campaign')->num_rows();

		if($query > 0){
			return -1;
		}
		return 1;
	}
	
	//End Data Exrends
	public function end_date_extends($end_date, $id){
	
		$this -> db -> limit(1);
		$this -> db -> where('start_date >=', $end_date);
		$this -> db -> where('id', $id);
		$this -> db -> where('available_status', 1);
		$query = $this->db->get('create_campaign')->num_rows();

		if($query > 0){
			return -1;
		}
		$this -> db -> limit(1);
		$this -> db -> where('end_date >=', $end_date);
		$this -> db -> where('id !=', $id);
		$this -> db -> where('available_status', 1);
		$query2 = $this->db->get('create_campaign')->num_rows();

		if($query2 > 0){
			return -1;
		}
		return 1;
	}

	//Fetch Data Pagination
	public function fetch_data_pageination($limit, $start, $table, $search=NULL, $approveStatus=NULL, $user_id =NULL) {
			
		$this->db->limit($limit, $start);

		if($approveStatus!==NULL ){
			$this->db->where('approveStatus',$approveStatus);
		}

		if($user_id !== NULL ){
			$this->db->where('userId', $user_id);
		}

		if($search !== NULL){
			$this->db->like('title',$search);
			$this->db->or_like('body',$search);
			$this->db->or_like('date',$search);
		}

		$this->db->order_by('date','desc');
		$query = $this->db->get($table);

		if ($query->num_rows() > 0) {
			
			foreach ($query->result_array() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}

	//Fatch Image
	public function fetch_images($limit=18, $start=0, $table, $search=NULL,$where_data=NULL) {
			
		$this->db->limit($limit, $start);

		if($search !== NULL){
			$this->db->like('date',$search);
			$this->db->or_like('photoCaption',$search);
		}
		if($where_data !== NULL){
			$this->db->where($where_data);
		}
		$this->db->group_by('photo');
		$this->db->order_by('date','desc');
		$query = $this->db->get($table);

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
	
	//User Category
	public function usersCategory($userId){

		$this->db->select('category.*');
		$this->db->join('category' , 'category_user.categoryId = category.id', 'left');
		$this->db->where('category_user.userId',$userId);
		return $this->db->get('category_user')->result_array();
	}
	
	//Get User
	public function get_user($user_id)
	{
		$query = $this->db->select('user.*,tbl_upozilla.*')->where('user.id',$user_id)->from('user')
			->join('tbl_upozilla','user.address = tbl_upozilla.id', 'left')
			->get();

		return $query->row();
	}

	//Update Profile Info
	public function update_pro_info($update_data, $user_id)
	{
		return $this->db->where('id',$user_id)->update('user',$update_data);
	}

	//Theme Text Update
	public function theme_text_update($name_index, $value){

		if($name_index == 'logo'){
			$result = $this->db->select('value')->where(array('id'=>6))->get('tbl_backend_theme')->row()->value;
			
			if (file_exists($result)) {
				unlink($result);
			}
	
		}elseif($name_index == 'share_banner'){
			$result = $this->db->select('value')->where(array('id'=>7))->get('tbl_backend_theme')->row()->value;
			
			if (file_exists($result)) {
				unlink($result);
			}
	
		} 

		$update_theme['value'] = $value;
		$this->db->where('name', $name_index)->update('tbl_backend_theme', $update_theme);
		return true;
	}

	//test category update
	public function update_test_category($updateData, $param2)
	{
	 
		return $this->db->where('id',$param2)->update('tbl_test_category',$updateData);
	}

	//test category delete
	public function delete_test_category($param2)
	{
		
		return $this->db->where('id',$param2)->delete('tbl_test_category'); 
	}

	//test name list
	public function test_name_list()
	{
		$this->db->select('tbl_test_name.id, tbl_test_name.test_category_id, tbl_test_name.test_name, tbl_test_name.price, tbl_test_name.referral_commission, tbl_test_name.report_format, tbl_test_category.name AS category_name')
			->from('tbl_test_name')
			->join('tbl_test_category', 'tbl_test_category.id = tbl_test_name.test_category_id', 'left')
			->order_by('tbl_test_name.insert_time', 'DESC')
			->group_by('tbl_test_name.id');

		$result = $this->db->get();

		if($result->num_rows() > 0){

			return $result->result();

		} else {

			return array();
		}
	}

	//test name update
	public function update_test_name($updateData, $param2)
	{
	 
		return $this->db->where('id',$param2)->update('tbl_test_name',$updateData);
	}

	//test name delete
	public function delete_test_name($param2)
	{
		
		return $this->db->where('id',$param2)->delete('tbl_test_name'); 
	}

	//update patient data
	public function update_patient($updateData, $param2)
	{
		if (isset($updateData['photo']) && file_exists($updateData['photo'])) {
	
			$result = $this->db->select('photo')->from('tbl_patient')->where('id',$param2)->get()->row()->photo;

			if (file_exists($result)) {
				unlink($result);
			}  
		}

		return $this->db->where('id',$param2)->update('tbl_patient',$updateData);
	}

	//Delete Testimonial
	public function delete_patient($param2)
	{
		$result = $this->db->select('photo')->from('tbl_patient')->where('id',$param2)->get()->row()->photo;

		if (file_exists($result)) {
			unlink($result);
		}   

		return $this->db->where('id',$param2)->delete('tbl_patient'); 
	}

	//autocomplete search data
	public function patient_data_search($search)
	{
		$this->db->select('tbl_patient.id, tbl_patient.patient_name, tbl_patient.patient_phone, tbl_patient.father_name, tbl_patient.mother_name, tbl_patient.patient_nid, tbl_patient.birth_date, tbl_patient.address')
			->from('tbl_patient')
			->where("LOWER(patient_name) LIKE '%$search%'")
			->or_where("patient_phone LIKE '%$search%'")
			->or_where("patient_nid LIKE '%$search%'")
			->group_by('tbl_patient.id');
		
		$result = $this->db->get();

		if($result->num_rows() > 0){

			return $result->result();

		} else {

			return array();
		}
	}

	//test list with pagination
	public function test_list($data)
	{
		$this->db->select('tbl_tests.id, tbl_tests.issue_date, tbl_tests.total_amount, tbl_tests.discount_amount, tbl_tests.invoice_number, tbl_patient.patient_name, user.firstname, user.lastname')

			->limit('20')
			->from('tbl_tests')
			->join('tbl_patient', 'tbl_patient.id = tbl_tests.patient_id', 'left')
			->join('user', 'user.id = tbl_tests.referred_by', 'left')
			->order_by('tbl_tests.insert_time', 'DESC')
			->group_by('tbl_tests.id');

		if(($data['start_date']) != ''){

			$this->db->where('tbl_tests.issue_date >=', $data['start_date']);
		}
		if(($data['end_date']) != ''){

			$this->db->where('tbl_tests.issue_date <=', $data['end_date']);
		}
		if(($data['invoice_number']) != ''){

			$this->db->where('tbl_tests.id', $data['invoice_number']);
		}
		
		$result = $this->db->get();

		if($result->num_rows() > 0){

			return $result->result();

		} else {

			return array();
		}
	}

	//test list print data
	public function tests_list($data)
	{
		$this->db->select('tbl_tests.id, tbl_tests.issue_date, tbl_tests.total_amount, tbl_tests.discount_amount, tbl_tests.invoice_number, tbl_patient.patient_name, user.firstname, user.lastname')

			
			->from('tbl_tests')
			->join('tbl_patient', 'tbl_patient.id = tbl_tests.patient_id', 'left')
			->join('user', 'user.id = tbl_tests.referred_by', 'left')
			->order_by('tbl_tests.insert_time', 'DESC')
			->group_by('tbl_tests.id');

		if(($data['start_date']) != ''){

			$this->db->where('tbl_tests.issue_date >=', $data['start_date']);
		}

		if(($data['end_date']) != ''){

			$this->db->where('tbl_tests.issue_date <=', $data['end_date']);
		}

		if(($data['invoice_number']) != ''){

			$this->db->where('tbl_tests.id', $data['invoice_number']);
		}
		
		$result = $this->db->get();

		if($result->num_rows() > 0){

			return $result->result();

		} else {

			return array();
		}
	}

	//for test view get data invidual tests
	public function get_test_data($id)
	{

		$this->db->select('tbl_tests.id, tbl_tests.issue_date, tbl_tests.total_amount, tbl_tests.discount_amount, tbl_tests.invoice_number, tbl_tests.patient_id, tbl_patient.patient_name, user.firstname, user.lastname, tbl_patient.patient_phone, tbl_patient.father_name, tbl_patient.mother_name, tbl_patient.patient_nid, tbl_patient.birth_date, tbl_patient.address, tbl_tests.insert_time')

			->from('tbl_tests')
			->join('tbl_patient', 'tbl_patient.id = tbl_tests.patient_id', 'left')
			->join('user', 'user.id = tbl_tests.referred_by', 'left')
			->where('tbl_tests.id', $id);

		$result = $this->db->get();

		if($result->num_rows() > 0){

			return $result->row();

		} else {

			return array();
		}

	}

	//invoice delete
	public function delete_tests($param2)
	{
		$invoice_number = $this->db->select('invoice_number')->where('id', $param2)->get('tbl_tests')->row()->invoice_number;
	 
		$this->db->where('id',$param2)->delete('tbl_tests');
		$this->db->where('tests_id', $param2)->delete('tbl_tests_details');
		$this->db->where('invoice_number', $invoice_number)->delete('tbl_accounts');
		$this->db->where('invoice_number', $invoice_number)->delete('tbl_accounts_details');

		if(true){
			return 1;
		} else{
			return 0;
		}

	}

	//tests details data for one invoice 
	public function get_test_details_data($id)
	{

		$this->db->select('tbl_tests_details.id, tbl_tests_details.referrer_fee, tbl_tests_details.test_bill, tbl_tests_details.report_publish_date, tbl_test_name.test_name,tbl_test_name.id AS testid, tbl_tests_details.test_report_details')

			->from('tbl_tests_details')
			->join('tbl_test_name', 'tbl_test_name.id = tbl_tests_details.tests_name_id', 'left')
			->where('tbl_tests_details.tests_id', $id)
			->group_by('tbl_tests_details.id');

		$result = $this->db->get();

		if($result->num_rows() > 0){

			return $result->result();

		} else {

			return array();
		}
		
	}

	//account head update
	public function account_head_update($updateData, $param2)
	{
	 
		return $this->db->where('id',$param2)->update('tbl_accounts_category',$updateData);
	}

	//accounts list with pagination
	public function accounts_list($limit, $start, $data)
	{
		$this->db->select('tbl_accounts.id, tbl_accounts.accounts_date, tbl_accounts.accounts_type_id, tbl_accounts.invoice_number, tbl_accounts.is_official_accounts, tbl_accounts.amount')

			->limit($limit, $start)
			->from('tbl_accounts')
			->order_by('tbl_accounts.insert_time', 'DESC')
			->group_by('tbl_accounts.id');

		if(($data['date']) != ''){

			$this->db->where('DATE(tbl_accounts.accounts_date) =', $data['date']);
		}
		
		$result = $this->db->get();

		if($result->num_rows() > 0){

			return $result->result();

		} else {

			return array();
		}
	}

	//account delete
	public function delete_accounts($param2)
	{
	 
		return $this->db->where('id',$param2)->delete('tbl_accounts');
	}

	//accounts details data for one invoice 
	public function get_accounts_details_data($invoice_number)
	{

		$this->db->select('tbl_accounts_details.id, tbl_accounts_details.quantity, tbl_accounts_details.description, tbl_accounts_details.amount, tbl_accounts_category.account_head')

			->from('tbl_accounts_details')
			->join('tbl_accounts_category', 'tbl_accounts_category.id = tbl_accounts_details.accounts_category_id', 'left')
			->where('tbl_accounts_details.invoice_number', $invoice_number)
			->group_by('tbl_accounts_details.id');

		$result = $this->db->get();

		if($result->num_rows() > 0){

			return $result->result();

		} else {

			return array();
		}
		
	}

	//test payment list with pagination
	public function test_payment_list($data)
	{
		$this->db->select('tbl_test_payment.id, tbl_test_payment.paid_date, tbl_test_payment.paid_amount, tbl_test_payment.payment_approved, tbl_patient.patient_name, tbl_patient.patient_phone, tbl_tests.invoice_number')

			->limit('20')
			->from('tbl_test_payment')
			->join('tbl_patient', 'tbl_patient.id = tbl_test_payment.patient_id', 'left')
			->join('tbl_tests', 'tbl_tests.id = tbl_test_payment.tests_id', 'left')

			->order_by('tbl_test_payment.insert_time', 'DESC')
			->group_by('tbl_test_payment.id');

		if(($data['start_date']) != ''){

			$this->db->where('tbl_test_payment.paid_date >=', $data['start_date']);
		}

		if(($data['end_date']) != ''){

			$this->db->where('tbl_test_payment.paid_date <=', $data['end_date']);
		}

		if(($data['patient_id']) != ''){

			$this->db->where('tbl_test_payment.patient_id', $data['patient_id']);
		}

		if(($data['tests_id']) != ''){

			$this->db->where('tbl_test_payment.tests_id', $data['tests_id']);
		}
		
		$result = $this->db->get();

		if($result->num_rows() > 0){

			return $result->result();

		} else {

			return array();
		}
	}

	//test payment update
	public function update_test_payment($updateData, $param2)
	{
	 
		return $this->db->where('id',$param2)->update('tbl_test_payment',$updateData);
	}

	//test payment delete
	public function delete_test_payment($param2)
	{
	 
		return $this->db->where('id',$param2)->delete('tbl_test_payment');
	}

	//test payment delete
	public function approved_test_payment($param2)
	{
	 	$approved['payment_approved'] = 1;
		return $this->db->where('id',$param2)->update('tbl_test_payment', $approved);
	}

	//get paid amount
	public function get_paid_amount($tests_id)
	{
		$this->db->select_sum('tbl_test_payment.paid_amount')

			->from('tbl_test_payment')
			->join('tbl_tests', 'tbl_test_payment.tests_id = tbl_tests.id', 'left')
			->where('tbl_test_payment.payment_approved', '1')
			->where('tbl_test_payment.tests_id', $tests_id);

			

		$result = $this->db->get();

		if($result->num_rows() > 0){

			return $result->row()->paid_amount;

		} else {

			return 0;
		}
	}

	//get referrer report 
	public function get_referrer_report($data)
	{
		$this->db->select('tbl_tests.id, tbl_tests.issue_date, tbl_tests.invoice_number, tbl_tests.total_amount, tbl_tests.discount_amount, user.firstname, user.lastname')
			->select_sum('referrer_fee')
			->from('tbl_tests')
			->join('tbl_tests_details', 'tbl_tests.id = tbl_tests_details.tests_id', 'left')
			->join('user', 'user.id = tbl_tests.referred_by', 'left')
			->order_by('tbl_tests.insert_time', 'DESC')
			->group_by('tbl_tests.id');

		if(($data['start_date']) != ''){

			$this->db->where('tbl_tests.issue_date >=', $data['start_date']);
		}

		if(($data['end_date']) != ''){

			$this->db->where('tbl_tests.issue_date <=', $data['end_date']);
		}

		if(($data['user_id']) != ''){

			$this->db->where('user.id', $data['user_id']);
		}
			

		$result = $this->db->get();

		if($result->num_rows() > 0){

			return $result->result();

		} else {

			return array();
		}
	}

	//get due report 
	public function get_due_report($data)
	{
		$this->db->select('tbl_tests.id, tbl_tests.issue_date, tbl_tests.invoice_number, tbl_tests.total_amount, tbl_tests.discount_amount, tbl_patient.patient_name, tbl_patient.patient_phone')
			->select_sum('paid_amount')
			// ->where('tbl_test_payment.payment_approved', '1')
			->from('tbl_tests')
			->join('tbl_test_payment', 'tbl_tests.id = tbl_test_payment.tests_id', 'left')
			
			->join('tbl_patient', 'tbl_patient.id = tbl_tests.patient_id', 'left')

			->order_by('tbl_tests.insert_time', 'DESC')
			->group_by('tbl_tests.id');

		if(($data['start_date']) != ''){

			$this->db->where('tbl_tests.issue_date >=', $data['start_date']);
		}

		if(($data['end_date']) != ''){

			$this->db->where('tbl_tests.issue_date <=', $data['end_date']);
		}

		if(($data['patient_id']) != ''){

			$this->db->where('tbl_tests.patient_id', $data['patient_id']);
		}
			

		$result = $this->db->get();

		if($result->num_rows() > 0){

			return $result->result();

		} else {

			return array();
		}
	}

	//get due report 
	public function get_due_report_dashboard()
	{
		$this->db->select('tbl_tests.id, tbl_tests.issue_date, tbl_tests.invoice_number, tbl_tests.total_amount, tbl_tests.discount_amount, tbl_patient.patient_name, tbl_patient.patient_phone')
			->select_sum('paid_amount')
			// ->where('tbl_test_payment.payment_approved', '1')
			->limit('20')
			->from('tbl_tests')
			->join('tbl_test_payment', 'tbl_tests.id = tbl_test_payment.tests_id', 'left')
			
			->join('tbl_patient', 'tbl_patient.id = tbl_tests.patient_id', 'left')

			->order_by('tbl_tests.insert_time', 'DESC')
			->group_by('tbl_tests.id');

		
			

		$result = $this->db->get();

		if($result->num_rows() > 0){

			return $result->result();

		} else {

			return array();
		}
	}

	public function report_to_submit_list()
	{
		$this->db->select('tbl_tests_details.id, tbl_tests_details.referrer_fee, tbl_tests_details.test_bill, tbl_tests_details.report_publish_date, tbl_tests.invoice_number, tbl_test_name.test_name, tbl_tests_details.tests_id')
			
			->limit('20')
			->from('tbl_tests_details')
			->join('tbl_test_name', 'tbl_tests_details.tests_name_id = tbl_test_name.id', 'left')
			->join('tbl_tests', 'tbl_tests_details.tests_id = tbl_tests.id', 'left')
			->where('tbl_tests_details.report_upload_time', '0000-00-00 00:00:00')
			->order_by('tbl_tests_details.insert_time', 'DESC')
			->group_by('tbl_tests_details.id');

		
			

		$result = $this->db->get();

		if($result->num_rows() > 0){

			return $result->result();

		} else {

			return array();
		}
	}

	public function patient_list_data($limit, $start, $data)
	{
		$this->db->select('tbl_patient.id, tbl_patient.patient_name, tbl_patient.patient_phone, tbl_patient.father_name, tbl_patient.mother_name, tbl_patient.patient_nid, tbl_patient.address, tbl_patient.birth_date, tbl_patient.photo')

			->limit($limit, $start)
			->from('tbl_patient')
			->order_by('tbl_patient.insert_time', 'DESC')
			->group_by('tbl_patient.id');

		if(($data['date']) != ''){

			$this->db->where('DATE(tbl_patient.insert_time) =', $data['date']);
		}
		
		$result = $this->db->get();

		if($result->num_rows() > 0){

			return $result->result();

		} else {

			return array();
		}
	}



	


}
	
?>

