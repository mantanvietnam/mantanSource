<?php
function getFurnitureAPI($input)
{
    echo json_encode(getListFurniture());
}

function getTypeHotelAPI($input)
{
    global $modelOption;
    $listData = $modelOption->getOption('HotelTypes');
    $typeHotel = (isset($listData['Option']['value']['allData'])) ? $listData['Option']['value']['allData'] : array();

    echo json_encode(array_values($typeHotel));
}

function getHotelAroundAPI($input)
{
    $return= array('code'=>1);

    $dataSend= $input['request']->data;
    $modelHotel = new Hotel();

    // 100km tương đương 0.9 độ
    $fields= array('name','address','phone','coordinates','image','typeHotel','price','priceHour','point','coordinates_x','coordinates_y','created','best');
    $listHotel= $modelHotel->getAround($dataSend['lat'],$dataSend['long'],$dataSend['radius'],$fields);
    if($listHotel){
        $today= getdate();
        foreach($listHotel as $key=>$hotel){
            if($today[0]-$hotel['Hotel']['created']->sec<=2592000){
                $listHotel[$key]['Hotel']['statusRoom']= 1;
            }else{
                $listHotel[$key]['Hotel']['statusRoom']= checkStatusRoom($hotel['Hotel']['id']);
            }
        }
    }

    $return= array('code'=>0,'data'=>$listHotel);
    

    echo json_encode($return);
} 

function getInfoHotelAPI($input)
{
	global $urlHomes;
    global $modelOption;
    global $urlNow;
    global $metaTitleMantan;
    global $metaDescriptionMantan;
    global $metaImageMantan;

    $modelHotel = new Hotel();
    $modelPromotion = new Promotion();

    $dataSend= $input['request']->data;
    $return= array();

    if (isset($dataSend['id'])) {
        $data = $modelHotel->getHotel($dataSend['id']);
        $folderHotel = $urlHomes . '/app/Plugin/mantanHotel/';
    }

    if (!empty($data)) {
        $modelHotel->updateView($data['Hotel']['id']);
        $today= getdate();
        if($today[0]-$data['Hotel']['created']->sec<=2592000){
            $data['Hotel']['statusRoom']= 1;
        }else{
            $data['Hotel']['statusRoom']= checkStatusRoom($data['Hotel']['id']);
        }

        $data['Hotel']['urlHotelDetail'] = $urlHomes . 'hotel/' . $data['Hotel']['slug'] . '.html';

        if (!isset($data['Hotel']['logo'])) {
            $data['Hotel']['logo'] = $folderHotel . 'images/no_image-100x100.jpg';
        }
        $listTypeHotel = $modelOption->getOption('HotelTypes');
        if (!empty($data['Hotel']['typeHotel'])) {
            $typeHotel = $listTypeHotel['Option']['value']['allData'][$data['Hotel']['typeHotel']];
        } else {
            $typeHotel['name'] = 'Đang cập nhật';
        }

        $data['Hotel']['typeHotel']= $typeHotel['name'];

        $conditions = array();
        $otherData = $modelHotel->getOtherData(3, $conditions);

        $modelTypeRoom = new TypeRoom();
        $page = 1;
        $limit = null;
        $conditions['idHotel'] = $data['Hotel']['id'];
        $order = array('created' => 'asc');
        $fields= null;

        $listTypeRoom = $modelTypeRoom->getPage($page, $limit, $conditions, $order);

        $today = getdate();
//        $conditions['time_start']= array('$lte' => $today[0]);
        $conditions['time_end'] = array('$gte' => $today[0]);
        $listPromotion = $modelPromotion->getPage(1, null, $conditions);

        /*
        // Lay du lieu binh chon
        $listCriteriaVote = $modelOption->getOption('criteriaVote');
        if (isset($listCriteriaVote['Option'])) {
            $modelVote = new Vote();
            $listCriteriaVote = $listCriteriaVote['Option']['value']['allData'];

            if (isset($_SESSION['infoUser']['User']['id'])) {
                foreach ($listCriteriaVote as $key => $value) {
                    $vote = $modelVote->getVote($_SESSION['infoUser']['User']['id'], $data['Hotel']['id'], $value['id']);
                    if (isset($vote['Vote']['id'])) {
                        $listCriteriaVote[$key]['show'] = 0;
                    }
                }
            }
        }
        */

        $return= array('listPromotion'=>$listPromotion,
        				'listTypeRoom'=>$listTypeRoom,
        				'otherData'=>$otherData,
        				'hotel'=>$data
        			);
    }

    echo json_encode($return);
}

function searchHotelAPI($input) {
    global $modelOption;
  
    $dataSend = arrayMap($input['request']->data);
    $modelHotel = new Hotel();

    $page = (int) $dataSend['page'];
    if ($page <= 0) $page = 1;
    $limit = (!empty($dataSend['limit']))? (int)$dataSend['limit']: null;
    $fields= array('name','address','phone','coordinates','image','typeHotel','price','priceHour','point','created','best','coordinates_x','coordinates_y');
    $order = array('created' => 'desc', 'name' => 'asc');

    $conditions = array();
    // tim theo tu khoa
    if (!empty($dataSend['nameHotel'])) {
        $key = createSlugMantan($dataSend['nameHotel']);
        $conditions['slug'] = array('$regex' => $key);
    }

    // tim theo gia
    if (!empty($dataSend['price'])) {
        $price = explode('-', $dataSend['price']);

        $priceFrom = (int) $price[0];
        $priceTo = (int) $price[1];

        $conditions['priceHour'] = array('$gte' => $priceFrom, '$lte' => $priceTo);
    }

    // tim theo thanh pho
    if (isset($dataSend['city']) && $dataSend['city'] > 0) {
        $conditions['city'] = (int) $dataSend['city'];
    }

    // tim theo quan huyen
    if (isset($dataSend['district']) && $dataSend['district'] > 0) {
        $conditions['district'] = (int) $dataSend['district'];
    }

    // tim theo điểm vote
    if (isset($dataSend['rating']) && $dataSend['rating'] > 0) {
        $conditions['point'] = array('$gte' => (int)$dataSend['rating']);
    }
    
    // tim theo vi tri
    if (isset($dataSend['loction']) && $dataSend['loction'] != '') {
        $dataSend['loction']= explode(',', $dataSend['loction']);
       
        $conditions['local'] = array('$all' => $dataSend['loction']);
    }

    // tim theo loai khach san
    if (isset($dataSend['hotelType']) && $dataSend['hotelType'] > 0) {
        $conditions['typeHotel'] = (int) $dataSend['hotelType'];
    }

    // tìm theo bán kính tọa độ
    if(!empty($dataSend['lat']) && !empty($dataSend['long']) && !empty($dataSend['radius'])){
        $latMin= $dataSend['lat']-$dataSend['radius'];
        $latMax= $dataSend['lat']+$dataSend['radius'];

        $longMin= $dataSend['long']-$dataSend['radius'];
        $longMax= $dataSend['long']+$dataSend['radius'];

        $conditions['coordinates_x']= array('$gte' => $latMin,'$lte' => $latMax);
        $conditions['coordinates_y']= array('$gte' => $longMin,'$lte' => $longMax);
    }

    // tim theo tien ich
    if (!empty($dataSend['tienIch'])) {
        $dataSend['tienIch']= explode(',', $dataSend['tienIch']);
        $tienIch= array();
        foreach($dataSend['tienIch'] as $value){
            $tienIch[]= (int) $value;
        }
       
        $conditions['furniture'] = array('$all' => $tienIch);
    }

    $listHotel = $modelHotel->getPage($page, $limit, $conditions,$order,$fields);

    if($listHotel){
        $today= getdate();
        foreach($listHotel as $key=>$hotel){
            if($today[0]-$hotel['Hotel']['created']->sec<=2592000){
                $listHotel[$key]['Hotel']['statusRoom']= 1;
            }else{
                $listHotel[$key]['Hotel']['statusRoom']= checkStatusRoom($hotel['Hotel']['id']);
            }
        }
    }

    echo json_encode($listHotel);
}

function saveGPSUserAPI($input)
{
    $dataSend = arrayMap($input['request']->data);
    if(!empty($dataSend['lat']) && !empty($dataSend['long'])){
        $_SESSION['userGPS']= array('lat'=>$dataSend['lat'],'long'=>$dataSend['long']);
        echo 1;
    }else{
        echo 0;
    }
}

function updateVoteHotelAPI($input)
{
    $dataSend = arrayMap($input['request']->data);
    $modelHotel = new Hotel();
    
    $data = $modelHotel->getHotel($dataSend['idHotel'],array('point','listVote') );

    if(!empty($data['Hotel']['listVote'])){
        $data['Hotel']['listVote'][]= (double) $dataSend['point'];
    }else{
        $data['Hotel']['listVote']= array((double) $dataSend['point']);
    }

    $number= 0;
    $total= 0;
    foreach($data['Hotel']['listVote'] as $point){
        $number++;
        $total+= $point;
    }
    $data['Hotel']['point']= round($total/$number,1);

    $save['$set']['point']= $data['Hotel']['point'];
    $save['$set']['listVote']= $data['Hotel']['listVote'];

    $dk= array('_id'=>new MongoId($dataSend['idHotel']) );
    
    if($modelHotel->updateAll($save,$dk)){
        $return = array('code'=>0);
    }else{
        $return = array('code'=>1);
    }
    
    
    echo json_encode($return);
}

function getInfoManagerAPI($input)
{
    $dataSend = arrayMap($input['request']->data);
    $modelManager = new Manager();
    $modelHotel= new Hotel();
    $modelTypeRoom = new TypeRoom();

    $data= array();
    if(!empty($dataSend['idManager'])){
        $data= $modelManager->getManager($dataSend['idManager'],array('fullname','avatar','email','phone','address','listHotel'));
        if($dataSend['getDataHotel']==1 && !empty($data['Manager']['listHotel'])){
            foreach($data['Manager']['listHotel'] as $idHotel){
                if(!empty($idHotel)){
                    $data['Manager']['dataHotel'][$idHotel]= $modelHotel->getHotel($idHotel);
                    $data['Manager']['dataHotel'][$idHotel]['Hotel']['typeRoom']= $modelTypeRoom->getAllTypeRoomHotel($idHotel);
                }
            }
        }
    }

    echo json_encode($data);
}

?>