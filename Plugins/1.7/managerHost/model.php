<?php

class Usermantan extends User
{
    var $name = 'User';
	
	function getPage($page=1,$limit=15,$conditions=array(),$order=array('created' => 'desc'))
    {
       $array= array(
                        'limit' => $limit,
                        'page' => $page,
                        'order' => $order,
                        'conditions' => $conditions

                    );
       return $this -> find('all', $array);             
    }
    
	function checkLogin($email,$pass)
	{
		$pass = md5($pass);
		return $this->find('first',array('conditions' => array('email'=>$email,'pass'=>$pass)));
	}
	
	function checkUseGiftCode($code,$user_id)
	{
		$user= $this->find('first',array('conditions' => array('_id'=> new MongoId($user_id))));
		if($user && in_array($code,$user['User']['giftCode'])){
			return true;
		}
		return false;
	}
	
	function addOrderGiftActive($email,$gift)
	{
		$user= $this->find('first',array('conditions' => array('email'=> $email)));
		if($user && !in_array($gift,$user['User']['giftCode'])){
			array_push($user['User']['giftCode'],$gift);
			$this->save($user);
		}
	}
	
	
	function saveUserAdmin($data)
	{
		$save['User']['id']= $data['id'];
		$save['User']['name']= $data['name'];
		$save['User']['phone']= $data['phone'];
		$save['User']['address']= $data['address'];
		
		$save['User']['numberCMT']= $data['numberCMT'];
		$save['User']['dateCMT']= $data['dateCMT'];
		$save['User']['addressCMT']= $data['addressCMT'];
		
		$save['User']['coin']= (int) $data['coin'];
		$save['User']['percent']= (double) $data['percent'];
		$save['User']['status']= $data['status'];
		
		if(isset($data['pass']) && mb_strlen($data['pass'])>=6){
			$save['User']['pass']= md5($data['pass']);
		}
		
		$this->save($save);
	}
	
	function saveUser($data)
	{
		$save['User']['name']= $data['name'];
		$save['User']['phone']= $data['phone'];
		$save['User']['address']= $data['address'];
		
		$save['User']['numberCMT']= $data['numberCMT'];
		$save['User']['dateCMT']= $data['dateCMT'];
		$save['User']['addressCMT']= $data['addressCMT'];
		
		if(isset($_SESSION['infoUser']['User']['id'])){
			$save['User']['id']= $_SESSION['infoUser']['User']['id'];
		}else{
			$save['User']['giftCode']= array();
			$save['User']['email']= $data['email'];
			$save['User']['coin']= 0;
			$save['User']['percent']= 0.05;
			$save['User']['status']= 1;
		}
		
		if(isset($data['pass']) && mb_strlen($data['pass'])>=6){
			$save['User']['pass']= md5($data['pass']);
		}
		
		$this->save($save);
	}
	
	function getUserFields($fields=array(),$order=array()){
		return $this->find('all',array('fields' => $fields, 'order'=>$order));
	}
	
	function getUserBy($key,$value)
	{
		return $this->find('first',array('conditions' => array($key=>$value)));
	}
	
	function getUser($id)
    {
    	$id= new MongoId($id);
	    return $this->find('first',array('conditions' => array('_id'=>$id)));
    }
    
    function updateCoin($id,$coin)
    {
	    $id= new MongoId($id);
	    $this->updateAll(array('$inc' => array('coin'=>$coin)), array('_id'=>$id));
    }
}
class Revenue extends AppModel
{
	var $name = 'Revenue';

	function getPage($page,$limit,$conditions,$order= array('created' => 'desc'))
    {
       $array= array(
                        'limit' => $limit,
                        'page' => $page,
                        'order' => $order,
                        'conditions' => $conditions

                    );
       return $this -> find('all', $array);             
    }
    
    function addOrderRevenue($referral,$order_id,$product_id,$product_name,$timeUsed,$priceTotal,$reward)
    {
	    $save['Revenue']['referral']= $referral;
	    $save['Revenue']['order_id']= $order_id;
	    $save['Revenue']['product_id']= $product_id;
	    $save['Revenue']['product_name']= $product_name;
	    $save['Revenue']['timeUsed']= $timeUsed;
	    $save['Revenue']['priceTotal']= $priceTotal;
	    $save['Revenue']['reward']= $reward;
	    
	    $this->save($save);
    }
}
class Product extends AppModel
{
	var $name = 'Product';

	function getPage($page,$limit,$conditions,$order= array('created' => 'desc'))
    {
       $array= array(
                        'limit' => $limit,
                        'page' => $page,
                        'order' => $order,
                        'conditions' => $conditions

                    );
       return $this -> find('all', $array);             
    }
    
    function saveProduct($data)
    {
	    $save['Product']['title']= $data['title'];
		$save['Product']['priceInstall']= (int)$data['priceInstall'];
		$save['Product']['priceMainten']= (int)$data['priceMainten'];
		$save['Product']['priceTransfer']= (int)$data['priceTransfer'];
		$save['Product']['typeService']= (int)$data['typeService'];
		$save['Product']['priceVat']= (int)$data['priceVat'];

		
		$save['Product']['info']= $data['info'];
		
		if(isset($data['id']) && $data['id']!=''){
			$save['Product']['id']= $data['id'];
		}
		
		$this->save($save);
    }
    
    function getProduct($id)
    {
    	$id= new MongoId($id);
	    return $this->find('first',array('conditions' => array('_id'=>$id)));
    }
}
class Gift extends AppModel
{
    var $name = 'Gift';
	
	function getPage($page,$limit,$conditions,$order= array('created' => 'desc'))
    {
       $array= array(
                        'limit' => $limit,
                        'page' => $page,
                        'order' => $order,
                        'conditions' => $conditions,
                    );
       return $this -> find('all', $array);             
    }
	
	function saveGift($data)
    {
    	$save['Gift']['status']= $data['status'];
	    $save['Gift']['code']= $data['code'];
	    $save['Gift']['product_id']= $data['product_id'];
	    $save['Gift']['type']= $data['type'];
		$save['Gift']['value']= (int)$data['value'];
		$save['Gift']['vat']= (int)$data['vat'];
		$save['Gift']['number']= (int)$data['number'];
		$save['Gift']['timeStart']= strtotime($data['timeStart'].' 0:0:0');
		$save['Gift']['timeEnd']= strtotime($data['timeEnd'].' 23:59:59');
		
		
		if(isset($data['id']) && $data['id']!=''){
			$save['Gift']['id']= $data['id'];
		}else{
			$save['Gift']['numberOrder']= 0;
		}
		
		$this->save($save);
    }
    
    function getGift($id)
    {
    	$id= new MongoId($id);
	    return $this->find('first',array('conditions' => array('_id'=>$id)));
    }
	
	function getGiftCode($code='',$product_id='')
    {
	    return $this->find('first',array('conditions' => array('code'=>$code,'product_id'=>$product_id)));
    }
	
	function addOrderGift($code='',$product_id='')
	{
		$this->updateAll(array('$inc' => array('numberOrder'=>1)), array('code'=>$code,'product_id'=>$product_id));
	}
	
	function addOrderGiftActive($code='',$product_id='')
	{
		$this->updateAll(array('$inc' => array('numberOrderActive'=>1)), array('code'=>$code,'product_id'=>$product_id));
	}
}
class Order extends AppModel
{
	var $name = 'Order';
	
	function getPage($page,$limit,$conditions,$order= array('created' => 'desc'))
    {
       $array= array(
                        'limit' => $limit,
                        'page' => $page,
                        'order' => $order,
                        'conditions' => $conditions,
                    );
       return $this -> find('all', $array);             
    }
	
	function saveOrder($listOrder=array(),$infoUser=array(),$data=array(),$referral='',$total=0,$codeGift='')
	{
		$save['Order']['listOrder']= $listOrder;
		$save['Order']['user_id']= $infoUser['User']['id'];
		$save['Order']['user_email']= $infoUser['User']['email'];
		$save['Order']['referral']= $referral;
		
		$save['Order']['infoOrder']['name']= $data['name'];
		$save['Order']['infoOrder']['email']= $data['email'];
		$save['Order']['infoOrder']['notification']= $data['notification'];
		$save['Order']['infoOrder']['phone']= $data['phone'];
		$save['Order']['infoOrder']['address']= $data['address'];
		$save['Order']['infoOrder']['pay']= $data['pay'];
		$save['Order']['infoOrder']['totalOrder']= $total;
		$save['Order']['infoOrder']['codeGift']= $codeGift;
		$save['Order']['infoOrder']['priceDiscount']= 0;
		
		
		$save['Order']['payStatus']= 0;
		$save['Order']['processStatus']= 0;
		
		$this->save($save);
		
		return $this->getLastInsertId();
	}
	
	function getOrder($id)
    {
    	$id= new MongoId($id);
	    return $this->find('first',array('conditions' => array('_id'=>$id)));
    }
}
class Service extends AppModel
{
	var $name = 'Service';
	
	function getPage($page,$limit,$conditions,$order= array('created' => 'desc'))
    {
       $array= array(
                        'limit' => $limit,
                        'page' => $page,
                        'order' => $order,
                        'conditions' => $conditions,
                    );
       return $this -> find('all', $array);             
    }
	
	function saveService($data)
	{
		$save['Service']['info']= trim($data['info']);
	    $save['Service']['status']= (int) $data['status'];
		$save['Service']['timeStart']= strtotime($data['timeStart'].' 0:0:0');
		$save['Service']['timeEnd']= strtotime($data['timeEnd'].' 23:59:59');
		$save['Service']['priceMainten']= (int) $data['priceMainten'];
		$save['Service']['priceTotal']= (int) $data['priceTotal'];
		
		$save['Service']['gift']= trim($data['gift']);
		$save['Service']['product_id']= trim($data['product_id']);
		$save['Service']['product_name']= trim($data['product_name']);
		$save['Service']['typeService']= (int) $data['typeService'];
		
		$save['Service']['urlPanel']= trim($data['urlPanel']);
		$save['Service']['account']= trim($data['account']);
		$save['Service']['pass']= trim($data['pass']);
		
	    $save['Service']['user_email']= trim($data['user_email']);
	    $save['Service']['name']= $data['name'];
		$save['Service']['emailManager']= trim($data['email']);
		$save['Service']['notification']= $data['notification'];
		$save['Service']['phone']= trim($data['phone']);
		$save['Service']['address']= $data['address'];
		
		if(isset($data['id']) && $data['id']!=''){
			$save['Service']['id']= $data['id'];
		}
		
		$this->save($save);
	}
	
	function getService($id)
    {
    	$id= new MongoId($id);
	    return $this->find('first',array('conditions' => array('_id'=>$id)));
    }
}
?>