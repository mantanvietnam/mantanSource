<?php

class Hotel extends AppModel {

    var $name = 'Hotel';

    function saveHotel($name, $manager,$idStaff, $city, $district, $address, $phone, $email, $website, $typeHotel, $furniture, $local, $images, $id, $price,$info,$coordinates,$coordinates_x,$coordinates_y, $yahoo, $skype,$linkCamera,$imageDefault,$priceHour,$priceNight,$link360) {
        $today = getdate();
        $data['Hotel']['name'] = $name;
        $data['Hotel']['manager'] = $manager;
        $data['Hotel']['idStaff'] = $idStaff;
        $data['Hotel']['city'] = $city;
        $data['Hotel']['district'] = $district;
        $data['Hotel']['address'] = $address;
        $data['Hotel']['phone'] = $phone;
        $data['Hotel']['email'] = $email;
        $data['Hotel']['website'] = $website;
        $data['Hotel']['typeHotel'] = $typeHotel;
        $data['Hotel']['furniture'] = $furniture;
        $data['Hotel']['local'] = $local;
        $data['Hotel']['image'] = $images;
        $data['Hotel']['id'] = $id;
        $data['Hotel']['info'] = $info;
        $data['Hotel']['coordinates'] = $coordinates;
        $data['Hotel']['coordinates_x'] = (double) $coordinates_x;
        $data['Hotel']['coordinates_y'] = (double) $coordinates_y;
        $data['Hotel']['yahoo'] = $yahoo;
        $data['Hotel']['skype'] = $skype;
        $data['Hotel']['price'] = (int) $price;
        $data['Hotel']['linkCamera'] = $linkCamera;
        $data['Hotel']['imageDefault'] = (!empty($imageDefault))? $imageDefault:'/app/Plugin/mantanHotel/view/manager/images/logo.png';
        $data['Hotel']['priceHour'] = (int)$priceHour;
        $data['Hotel']['priceNight'] = (int)$priceNight;
        $data['Hotel']['link360'] = $link360;
        
        if($id==''){
            $data['Hotel']['best'] = 0;
            $data['Hotel']['view'] = 0;
            $data['Hotel']['point'] = 0;
        }
        $listSlug = array();
        $number = 0;
        $slug = createSlugMantan(trim($name));
        $slugStart = $slug;
        do {
            $number++;
            $listSlug = $this->find('all', array('conditions' => array('slug' => $slug)));
            if (count($listSlug) > 0 && $listSlug[0]['Hotel']['id'] != $id) {
                $slug = $slugStart . '-' . $number;
            }
        } while (count($listSlug) > 0 && $listSlug[0]['Hotel']['id'] != $id);

        $data['Hotel']['slug'] = $slug;

        $this->save($data);
        return $data;
    }

    function getAllByManager($idStaff) {
        $array = array(
            'order' => array('created' => 'desc'),
            'conditions' => array(
//                'manager' => $idManager,
                'idStaff' => $idStaff,
                )
        );
        //debug ($array);
        return $this->find('all', $array);
    }
    
    function getAllHotelLogin($listHotel)
    {
        $dk= array();
        foreach ($listHotel as $hotel){
            if(!empty($hotel)){
                $dk['$or'][]= $hotel;
            }
        }
        
        $array = array(
            'order' => array('created' => 'desc'),
            'conditions' => $dk,
            'fields' => array('name'=>1)
        );
        return $this->find('all', $array);
    }

    function getHotel($id='',$field= array()) {
        if($id!=''){
            $id = new MongoId($id);
            $dk = array('_id' => $id);
            $return = $this->find('first', array('conditions' => $dk,'fields' => $field));
            return $return;
        }
        return null;
    }

    function getPage($page = 1, $limit = null, $conditions = array(), $order = array('created' => 'desc', 'name' => 'asc'), $field= array()) {
        $array = array(
            'limit' => $limit,
            'page' => $page,
            'order' => $order,
            'conditions' => $conditions,
            'fields' => $field
        );
        return $this->find('all', $array);
    }
    function getPageAdmin($page = 1, $limit = 15, $conditions = array(), $order = array('created' => 'desc', 'name' => 'asc'), $field= array()) {
        $array = array(
            'limit' => $limit,
            'page' => $page,
            'order' => $order,
            'conditions' => $conditions,
            'fields' => $field
        );
        return $this->find('all', $array);
    }

    function getHotelSlug($slug) {
        $dk = array('slug' => $slug);
        $return = $this->find('first', array('conditions' => $dk));
        return $return;
    }

    function updateView($id) {
        $id = new MongoId($id);
        $dk = array('_id' => $id);
        $product['$inc']['view'] = 1;
        $this->updateAll($product, $dk);
    }

    function getOtherData($limit = 5, $conditions) {
        $return = $this->find('all', array('conditions' => $conditions,
            'order' => array('created' => 'DESC'),
            'limit' => $limit
        ));
        return $return;
    }
    function voteHotel($idHotel,$idvote,$star)
    {
        $hotel=$this->getHotel($idHotel);
        if (isset($hotel['Hotel']['vote']['point']))
        {
            $hotel['Hotel']['vote']['point']=($hotel['Hotel']['vote']['count']*$hotel['Hotel']['vote']['point']+$star)/($hotel['Hotel']['vote']['count']+1);
            $hotel['Hotel']['vote']['count']++;
        }
        else
        {
            $hotel['Hotel']['vote']['point']=(int)$star;
            $hotel['Hotel']['vote']['count']=1;   
        }
        if (isset($hotel['Hotel']['vote']['detail'][$idvote]))
        {
            $hotel['Hotel']['vote']['detail'][$idvote]['point']=($hotel['Hotel']['vote']['count']*$hotel['Hotel']['vote']['point']+$star)/($hotel['Hotel']['vote']['count']+1);
            $hotel['Hotel']['vote']['detail'][$idvote]['count']++;
        }
        else
        {
            $hotel['Hotel']['vote']['detail'][$idvote]['point']=(int)$star;
            $hotel['Hotel']['vote']['detail'][$idvote]['count']=1;   
        }
        $this->save($hotel);
        return $hotel;
    }

    function getAround($latGPS=null,$longGPS=null,$radius=null,$fields=null,$conditions=array(),$order=array(),$limit=null)
    {
        if($radius){
            $latMin= $latGPS-$radius;
            $latMax= $latGPS+$radius;

            $longMin= $longGPS-$radius;
            $longMax= $longGPS+$radius;

            $conditions['coordinates_x']= array('$gte' => $latMin,'$lte' => $latMax);
            $conditions['coordinates_y']= array('$gte' => $longMin,'$lte' => $longMax);
        }

        $return = $this->find('all', array('limit' => $limit,'conditions' => $conditions, 'fields'=>$fields, 'order' => $order));

        return $return;
    }

}

?>