<?php
class FreebaseHomeAction extends BaseAction
{
  public function init() {
    parent::init();
    $this->addScript("jquery8.js");
    $this -> template = "FreebaseHome.tpl";
    $this->addScript("freebasehome.js");
    $this->addScript("bootstrap.js");
    
    
  }
  public function execute($request, $response)
  {
    $form = $this->setForm($request);
      $response -> form = $form;
      if(!$form->isSubmit()) return;
      if(!$form->validate()) return;
      //$query = array("id" => "/en/robert_downey_jr","name"=>NULL);
      
      $query = array(array(
                     "type" => "/celebrities/celebrity",
                     "*"=>NULL,
                     /*
                     "id"=>NULL,
                                          "name"=>NULL,
                                          "gender"=>NULL,
                                          "date_of_birth"=>NULL,
                                          "ethnicity"=>NULL,
                                          "height_meters"=>NULL,
                                          "nationality"=>NULL,
                                          "parents"=>NULL,
                                          "place_of_birth"=>NULL,
                                          "places_lived"=>array(),
                                          "profession"=>NULL,
                                          "weight_kg"=>NULL,
                                          "id"=>NULL,*/
                     
                     "type"=>"/people/person",
                     ));
       
    //$res = FreebaseHomeAction::getQueryResults($query, false, 1);
    //Logger::info(">>>>>>>>>>>>>>>>>>>>>>>>>>>", $res);
    //FreebaseHomeAction::changeToArray($res);
    $r = FreebaseHomeAction::mongoDBUtility();
    //Logger::info(">>>>>>>>>>>>>>>>>>>>>>>>>>>", $r);
    $response->data = $r;
  }
  public function changeToArray($res)
  {
    $main = array();
    $result = $res->result;    
    foreach ($result as $key => $values) {
    	$query = array(
						array(
								"type"=>NULL,
								"id"=>$values->id));
		$r = FreebaseHomeAction::getQueryResults($query, false, 1);
		$values->types = $r->messages[0]->info->result;
		//Logger::info(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>",$values);
       FreebaseHomeAction::mongoDBWrite($values);
    }
  }
public function mongoDBWrite($r)
  {
    
    //Logger::info(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>",$r);
    $m = new MongoClient();
    $db = $m->db;
    $collection = $db->myCollection;
    //$collection->remove();
    $remove_array = array("id" => $r->id);
    $collection->remove($remove_array);
    $collection->insert($r);
  }
  public function mongoDBUtility()
  {
    $m = new MongoClient();
    $db = $m->db;
    $collection = $db->myCollection;
    $ans = $collection->find();
    $data=array();
       $i=0;
       foreach($ans as $person){
              $data[$i]=$person;
              $i++;
               }
    //Logger::info("<<<<<<<<<<<<<<<<<<<<<<<<<<<<<",$data);
    return $data;
    
  }
  public static function getQueryResults($query, $cursor=true, $extended=0) {
    $query_envelope = array('query' => $query);
    if($cursor) $query_envelope['cursor'] = true;
    if($extended) $query_envelope['extended'] = true;
    $service_url = 'http://api.freebase.com/api/service/mqlread';
    $check = urlencode(json_encode($query_envelope));
    $url = $service_url . '?query=' . urlencode(json_encode($query_envelope));
    $curl = new CurlWrapper($url);
    $response = $curl->get();
    return json_decode($response);
  }
  public function setForm($request)
  {
    $form = new mForm($this, array(
                              "id" => "myform", 
                              "formType" => mForm::FORM_TYPE_HORIZONTAL, 
                      ));
    $form -> submit("submit", array(
                              "id" => "submit", 
                              "class"=> "btn btn-primary",
                              "title"=>"Submit"
                    ));
    return $form;
    
  }
}
?>