<?php
$where = ['position'=>'media'];
if(request('objsn') || request('objsn') == '0') $where['objsn'] = request('objsn');
if(request('type')) $where['type'] = request('type');
$rs = \App\Cm::where($where)->get();
?>
<ul class="media_list">
@foreach($rs as $rd)
    <li>
    	<a class="img_list" onclick="insert_media('{{\App\Cm::get_pic($rd->id)}}')"><img src="{{\App\Cm::get_pic($rd->id)}}" /></a>
    </li>
@endforeach 
</ul>
