<?php
function getHotelAroundAPI($input)
{
    $return= array('code'=>1);

    $dataSend= $input['request']->data;
    $modelHotel = new Hotel();

    // 100km tương đương 0.9 độ
    $fields= array('name','address','phone','coordinates');
    $data= $modelHotel->getAround($dataSend['lat'],$dataSend['long'],$dataSend['radius'],$fields);

    $return= array('code'=>0,'data'=>$data);
    

    echo json_encode($return);
} 
?>