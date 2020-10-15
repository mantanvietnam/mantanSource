<?php
	function ajaxStar()
	{
		if (isset($_SESSION['infoUser']))
		{
			$idUser=$_POST['idUser'];
			$idHotel=$_POST['idHotel'];
			$listId=$_POST['listId'];
			$listVote=$_POST['listVote'];
			$modelVote=new Vote();
			foreach ($listId as $key => $idvote) {
				if ($listVote[$key]>0)
				{
					$dataVote=$modelVote->getVote($idUser,$idHotel,$idvote);
					if (!isset($dataVote['Vote']['id']))
					{
						$modelVote->saveVote($idUser,$idHotel,$idvote,$listVote[$key],null);
						$modelVote->creat();
						$modelHotel=new Hotel();
						$dataHotel=$modelHotel->voteHotel($idHotel,$idvote,$listVote[$key]);
					}
				}
			}
		}
	}
?>