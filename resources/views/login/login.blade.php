  <p>姓名：<input type="text" id="name"></p>
  <p>密码：<input type="password" id="password"></p>
  <p><input type="submit" id="submit" value="登录"></p>
 <script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js">
</script>
<script type="text/javascript">
	$('#submit').click(function() {
		var name=$('#name').val()
		var password=$('#password').val()
		$.ajax({
			url:"<?php echo url('logindo');?>",
			data:{
				name:name,
				password:password,
			},
			type: "get",
			dataType:"json",
			success:function(res){
				if (res.status=='ok') {
					location.href='<?php echo url("show") ?>'
				}

			}
		})
	})
</script>