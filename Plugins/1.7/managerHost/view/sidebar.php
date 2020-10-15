<div class="col-sm-3 col-sm-offset-1">
	<h4 class="badge">E-mail</h4>
	<p><a href=""><?php echo $contactSite['Option']['value']['email'];?></a></p>
	<h4 class="badge">Phone</h4>
	<p><?php echo $contactSite['Option']['value']['fone'];?></p>
	<h4 class="badge">On the Web</h4>
	<ul>
		<li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $urlNow;?>">Facebook</a></li>
		<li><a href="https://twitter.com/home?status=<?php echo $urlNow;?>">Twitter</a></li>
		<li><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $urlNow;?>&title=Mới biết được tin này, quá sock">Linked In</a></li>
		<li><a href="https://plus.google.com/share?url=<?php echo $urlNow;?>">Google Plus</a></li>
	</ul>
</div>