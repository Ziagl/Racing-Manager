<div class="page-content-wrapper">
    <div class="page-content forum">
    	<div class="row">
    		<div class="col-md-12">
    			<iframe name='iframe1' id="iframe1" src="{$forum_link}" width="100%" height="100" frameborder="no" scrolling="yes" onload='javascript:resizeIframe(this);'>
    			</iframe>
    		</div>
    	</div>
    </div>
</div>
<script language="javascript" type="text/javascript">
  function resizeIframe(obj) {
  	obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
  }
</script>
