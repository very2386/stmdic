<div class="modal fade bs-example-modal-lg" id="modalMedia" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form name="media_upl_form" id="media_upl_form" action="/do/edit/cm" method="post" enctype="multipart/form-data">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 id="media_title" class="modal-title">媒體庫</h4>
      </div>
      <div id="media_content" class="modal-body">
        <div class="media_cont" id="media_list">
          <div class="loading"><img src="/back/assets/images/loading.gif" /></div>
        </div>
        <div style="clear:both"></div>
      </div>
      <div id="media_upload" class="modal-body" style="background:#f1f1f1; border-top:#ccc solid 1px">
        <div class="row">
          <label class="col-xs-3">圖片名稱</label>
          <div class="col-xs-9"><input type="text" class="form-control" name="name" value="" placeholder="請輸入圖片名稱" /></div>
        </div>
        <div>
          <input type="file" name="picfile" class="form-control" aria-label="上傳圖片">
        </div>
      </div>
      <div class="modal-footer">
        <input type="submit" name="goUpl" value="上傳圖片" class="btn btn-primary pull-left" />
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="lang" value="{{session('lang')}}">
        <input type="hidden" name="position" value="media">
        <input type="hidden" name="type" id="modalMedia_type" value="image">
        <input type="hidden" name="obj" id="modalMedia_obj" value="{{csrf_token()}}">
        <input type="hidden" name="objsn" id="modalMedia_objsn" value="{{request('id')}}">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
    </form>
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->