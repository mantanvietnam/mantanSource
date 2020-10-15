<?php

function managerHotelCamera($input)
{
    global $urlHomes;
    
    $modelHotel = new Hotel();
    if (checkLoginManager()) {
        $data = $modelHotel->getHotel($_SESSION['idHotel']);
        $linkCamera = (isset($data['Hotel']['linkCamera']))? $data['Hotel']['linkCamera']:'';
        
        setVariable('linkCamera', $linkCamera);
    }else {
        $modelHotel->redirect($urlHomes);
    }
}

function managerHotelDiagram() {
    $modelFloor = new Floor();
    global $urlHomes;
    if (checkLoginManager()) {
        // Lay danh sach tang
        $modelFloor = new Floor();
        $listFloor = $modelFloor->getAllByHotel($_SESSION['idHotel']);

        if (empty($listFloor)) {
            $modelFloor->redirect($urlHomes . 'managerAddFloor?redirect=managerHotelDiagram');
        }

        // Lay danh sach loai phong
        $modelTypeRoom = new TypeRoom();
        $listTypeRoom = $modelTypeRoom->getAllTypeRoomHotel($_SESSION['idHotel']);

        if (empty($listTypeRoom)) {
            $modelFloor->redirect($urlHomes . 'managerAddTypeRoom?redirect=managerHotelDiagram');
        }

        $array = array();
        foreach ($listTypeRoom as $typeRoom) {
            $array[$typeRoom['TypeRoom']['id']]['name'] = $typeRoom['TypeRoom']['roomtype'];
            $array[$typeRoom['TypeRoom']['id']]['count'] = 0;
        }
        $listTypeRoom = $array;

        // Lay danh sach phong
        $modelRoom = new Room();
        $listRooms = array();
        $totalEmpty = 0;
        $totalUse = 0;
        $totalWaiting = 0;
        $totalUnClear = 0;
        $totalKhachDoan = 0;
        
        $modelOrder = new Order();
        $today= getdate();
        $timeStart= mktime(0, 0, 0, $today['mon'], $today['mday'], $today['year']);
        $timeEnd= mktime(23, 59, 59, $today['mon'], $today['mday'], $today['year']);
        
        $conditionsOrder['idHotel'] = $_SESSION['idHotel'];
        $conditionsOrder['status'] = 1;
        $conditionsOrder['time_start']= array('$gte' => $timeStart,'$lte' => $timeEnd);
        
        foreach ($listFloor as $floor) {
            $listRooms[$floor['Floor']['id']] = array();
            foreach ($floor['Floor']['listRooms'] as $idRoom) {
                $dataRoom = $modelRoom->getRoomUse($idRoom);

                if ($dataRoom) {
                    $listTypeRoom[$dataRoom['Room']['typeRoom']]['count'] ++;
                    if (isset($dataRoom['Room']['clear']) && $dataRoom['Room']['clear']==FALSE) {
                        $totalUnClear++;
                    }elseif (!empty($dataRoom['Room']['checkin'])) {
                        $totalUse++;
                    }else {
                        $totalEmpty++;
                    }
                    if (isset($dataRoom['Room']['checkin']['khachDoan']) && $dataRoom['Room']['checkin']['khachDoan']=='co') {
                        $totalKhachDoan++;
                    } 
                    

                    $conditionsOrder['listRooms'] = $dataRoom['Room']['id'];
                    $countWaiting= $modelOrder->find('count',array('conditions'=>$conditionsOrder));
                    
                    if($countWaiting>0){
                        $totalWaiting++;
                        $dataRoom['Room']['waiting']= true;
                    }else{
                        $dataRoom['Room']['waiting']= false;
                    }
                    
                    array_push($listRooms[$floor['Floor']['id']], $dataRoom);
                }
            }
        }

        $mess= '';
        if(isset($_GET['redirect'])){
            switch($_GET['redirect']){
                case 'managerAddRoom': $mess= 'Bạn đã đạt giới hạn tối đa số phòng';break;
            }
        }

        setVariable('listFloor', $listFloor);
        setVariable('listTypeRoom', $listTypeRoom);
        setVariable('listRooms', $listRooms);
        setVariable('totalEmpty', $totalEmpty);
        setVariable('totalUse', $totalUse);
        setVariable('totalUnClear', $totalUnClear);
        setVariable('totalWaiting', $totalWaiting);
        setVariable('totalKhachDoan', $totalKhachDoan);
        setVariable('mess', $mess);
    } else {
        $modelFloor->redirect($urlHomes);
    }
}

?>