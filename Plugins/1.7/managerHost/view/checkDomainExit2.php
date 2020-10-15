<?php
	 $content = file_get_contents("http://whois.matbao.vn/rss/mantanservices.com/0");  
	
    $x = new SimpleXmlElement($content);  
    echo $x->channel->title . '<br>';
    echo $x->channel->status . '<br>';    
    foreach($x->channel->item as $entry) {  
        echo $entry->title .': '. $entry->description.'<br>';  
    }   
?>