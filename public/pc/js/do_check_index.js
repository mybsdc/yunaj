// 选城市
    	$('#city').change(function(){
    		var city_id = $(this).val();
    		var html = '<option value="">请选择</option>';
    		$.post(home_do_check_index, {city_id: city_id}, function(data){
    			var dataObj = JSON.parse(data); // string to obj
		    	$(dataObj.area).each(function(i){
				    html += '<option value="' + this.id + '">' + this.name + '</option>';
				});
				$('#area').html(html);
				$('#pageNum').html(dataObj.pageNum); // 共几页
				$('#isCount').html(dataObj.count); // 共几条
				if (dataObj.count === 0) { // 判断是否无数据，无数据则显示一句话
					showNull(0);
					return false;
				}
			    layui.laypage({
			        cont: 'layer-pages',
			        groups: 5, // 显示页码数
			        skin: '#0f90e7',
			        pages: dataObj.pageNum, // 总页数
			        first: '首页',
					last: '尾页',
			        jump: function(obj, first){

			            // 得到了当前页，用于向服务端请求对应数据
			            var curr = obj.curr;
			            $('#isCurrPage').html(curr);
		            	postData = {page: curr, city_id: city_id};
				        $.post(home_do_check_toPage, postData, function(data){
			                let dataObj = eval(data); // json转对象
			                /*if (dataObj.length == 0) { // 数据对象为空
			                    $('#isCurrPage').html(0);
			                    $('#pageNum').html(0);
			                } else {
			                    $('#isCurrPage').html(curr);
			                }*/
			                var html = '';
			                $(dataObj).each(function(i){
			                	html += '<tr>';
							        html += '<td class="center">' + (i + 1 + config_page_num * (curr - 1)) + '</td>';
					                html += '<td>' + this.areaName + this.xqName + '</td>';
					                html += '<td>' + this.dong + this.unit + '单元' + this.room + '</td>';
					                html += '<td style="text-align: right;">' + this.cstcode + '</td>';
					                html += '<td style="text-align: center;">' + this.cstname + '</td>';
					                html += '<td class="hidden-480" style="text-align: right;">' + this.telphone + '</td>';
					                html += '<td class="hidden-480">' + this.typeName + '</td>';
					                html += '<td class="hidden-480">' + this.brandName + '</td>';
					                html += '<td class="hidden-480">' + this.direction + '</td>';
					                html += '<td class="hidden-480 center"><a href="' + home_do_check_addLog + '?cstcode=' + this.cstcode + '"><i class="icon-plus-sign" style="color: #87b87f; font-size: 18px; cursor: pointer"></i></a></td>';
					            html += '</tr>';
			                });
			                html += '<tr style="background-color: #f5f5f5;">';
			                html += '<td></td>';
			                html += '<td colspan="10">';
				            html += '<button class="icon-cloud-download" style="background-color: #17a3ff;color: #FFF;border-style: none ;padding: 5px 10px;float: right;margin-left: 1%;cursor: pointer" id="toExcel" id="toExcel">导出数据</button>';
				            html += '</td>';
				            html += '</tr>';
			                $('#listData').html(html);
			            }, 'json'); // 必须指定json，否则前台无法识别
			        }
			    });
		   }, 'json');
    	});

    	// 选区域
    	$('#area').change(function(){
    		var area_id = $(this).val();
    		var html = '<option value="">请选择</option>';
    		$.post(home_do_check_index, {area_id: area_id}, function(data){
    			// let dataObj = eval(data); // json转对象
    			var dataObj = JSON.parse(data);
		    	$(dataObj.xq).each(function(i){
				    html += '<option value="' + this.id + '">' + this.name + '</option>';
				});
				$('#xq').html(html);

				$('#pageNum').html(dataObj.pageNum); // 共几页
				$('#isCount').html(dataObj.count); // 共几条
				if (dataObj.count === 0) { // 判断是否无数据，无数据则显示一句话
					showNull(0);
					return false;
				}
			    layui.laypage({
			        cont: 'layer-pages',
			        groups: 5, // 显示页码数
			        skin: '#0f90e7',
			        pages: dataObj.pageNum, // 总页数
			        first: '首页',
					last: '尾页',
			        jump: function(obj, first){

			            // 得到了当前页，用于向服务端请求对应数据
			            var curr = obj.curr;
			            $('#isCurrPage').html(curr);
		            	postData = {page: curr, area_id: area_id};
				        $.post(home_do_check_toPage, postData, function(data){
			                let dataObj = eval(data); // json转对象
			                /*if (dataObj.length == 0) { // 数据对象为空
			                    $('#isCurrPage').html(0);
			                    $('#pageNum').html(0);
			                    return false;
			                } else {
			                    $('#isCurrPage').html(curr);
			                }*/
			                var html = '';
			                $(dataObj).each(function(i){
			                	html += '<tr>';
							        html += '<td class="center">' + (i + 1 + config_page_num * (curr - 1)) + '</td>';
					                html += '<td>' + this.areaName + this.xqName + '</td>';
					                html += '<td>' + this.dong + this.unit + '单元' + this.room + '</td>';
					                html += '<td style="text-align: right;">' + this.cstcode + '</td>';
					                html += '<td style="text-align: center;">' + this.cstname + '</td>';
					                html += '<td class="hidden-480" style="text-align: right;">' + this.telphone + '</td>';
					                html += '<td class="hidden-480">' + this.typeName + '</td>';
					                html += '<td class="hidden-480">' + this.brandName + '</td>';
					                html += '<td class="hidden-480">' + this.direction + '</td>';
					                html += '<td class="hidden-480 center"><a href="' + home_do_check_addLog + '?cstcode=' + this.cstcode + '"><i class="icon-plus-sign" style="color: #87b87f; font-size: 18px; cursor: pointer"></i></a></td>';
					            html += '</tr>';
			                });
			                html += '<tr style="background-color: #f5f5f5;">';
			                html += '<td></td>';
			                html += '<td colspan="10">';
				            html += '<button class="icon-cloud-download" style="background-color: #17a3ff;color: #FFF;border-style: none ;padding: 5px 10px;float: right;margin-left: 1%;cursor: pointer" id="toExcel">导出数据</button>';
				            html += '</td>';
				            html += '</tr>';
			                $('#listData').html(html);
			            }, 'json'); // 必须指定json，否则前台无法识别
			        }
			    });
		   }, 'json');
    	});

    	// 选小区
    	$('#xq').change(function(){
    		var xq_id = $(this).val();
    		var html = '';
    		$.post(home_do_check_index, {xq_id: xq_id}, function(data){
    			// let dataObj = eval(data); // json转对象
    			var dataObj = JSON.parse(data);
				$('#pageNum').html(dataObj.pageNum); // 共几页
				$('#isCount').html(dataObj.count); // 共几条
				if (dataObj.count === 0) { // 判断是否无数据，无数据则显示一句话
					showNull(0);
					return false;
				}
			    layui.laypage({
			        cont: 'layer-pages',
			        groups: 5, // 显示页码数
			        skin: '#0f90e7',
			        pages: dataObj.pageNum, // 总页数
			        first: '首页',
					last: '尾页',
			        jump: function(obj, first){

			            // 得到了当前页，用于向服务端请求对应数据
			            var curr = obj.curr;
			            $('#isCurrPage').html(curr);
		            	postData = {page: curr, xq_id: xq_id};
				        $.post(home_do_check_toPage, postData, function(data){
			                let dataObj = eval(data); // json转对象
			                /*if (dataObj.length == 0) { // 数据对象为空
			                    $('#isCurrPage').html(0);
			                    $('#pageNum').html(0);
			                } else {
			                    $('#isCurrPage').html(curr);
			                }*/
			                var html = '';
			                $(dataObj).each(function(i){
			                	html += '<tr>';
							        html += '<td class="center">' + (i + 1 + config_page_num * (curr - 1)) + '</td>';
					                html += '<td>' + this.areaName + this.xqName + '</td>';
					                html += '<td>' + this.dong + this.unit + '单元' + this.room + '</td>';
					                html += '<td style="text-align: right;">' + this.cstcode + '</td>';
					                html += '<td style="text-align: center;">' + this.cstname + '</td>';
					                html += '<td class="hidden-480" style="text-align: right;">' + this.telphone + '</td>';
					                html += '<td class="hidden-480">' + this.typeName + '</td>';
					                html += '<td class="hidden-480">' + this.brandName + '</td>';
					                html += '<td class="hidden-480">' + this.direction + '</td>';
					                html += '<td class="hidden-480 center"><a href="' + home_do_check_addLog + '?cstcode=' + this.cstcode + '"><i class="icon-plus-sign" style="color: #87b87f; font-size: 18px; cursor: pointer"></i></a></td>';
					            html += '</tr>';
			                });
			                html += '<tr style="background-color: #f5f5f5;">';
			                html += '<td></td>';
			                html += '<td colspan="10">';
				            html += '<button class="icon-cloud-download" style="background-color: #17a3ff;color: #FFF;border-style: none ;padding: 5px 10px;float: right;margin-left: 1%;cursor: pointer" id="toExcel">导出数据</button>';
				            html += '</td>';
				            html += '</tr>';
			                $('#listData').html(html);
			            }, 'json'); // 必须指定json，否则前台无法识别

			        }
			    });
		   }, 'json');
    	});

    	// 选任务
    	$('#task').change(function(){
    		var task_id = $(this).val();
    		var html = '';
    		$.post(home_do_check_index, {task_id: task_id}, function(data){
    			var dataObj = JSON.parse(data);
				$('#pageNum').html(dataObj.pageNum); // 共几页
				$('#isCount').html(dataObj.count); // 共几条
				if (dataObj.count === 0) { // 判断是否无数据，无数据则显示一句话
					showNull(0);
					return false;
				}
			    layui.laypage({
			        cont: 'layer-pages',
			        groups: 5, // 显示页码数
			        skin: '#0f90e7',
			        pages: dataObj.pageNum, // 总页数
			        first: '首页',
					last: '尾页',
			        jump: function(obj, first){

			            // 得到了当前页，用于向服务端请求对应数据
			            var curr = obj.curr;
			            $('#isCurrPage').html(curr);
		            	postData = {page: curr, task_id: task_id};
				        $.post(home_do_check_toPage, postData, function(data){
				        	// console.log(data);
			                var dataObj = JSON.parse(data); // json转对象
			                /*if (dataObj.length == 0) { // 数据对象为空
			                    $('#isCurrPage').html(0);
			                    $('#pageNum').html(0);
			                } else {
			                    $('#isCurrPage').html(curr);
			                }*/
			                var html = '';
			                $(dataObj).each(function(i){
			                	html += '<tr>';
							        html += '<td class="center">' + (i + 1 + config_page_num * (curr - 1)) + '</td>';
					                html += '<td>' + this.areaName + this.xqName + '</td>';
					                html += '<td>' + this.dong + this.unit + '单元' + this.room + '</td>';
					                html += '<td style="text-align: right;">' + this.cstcode + '</td>';
					                html += '<td style="text-align: center;">' + this.cstname + '</td>';
					                html += '<td class="hidden-480" style="text-align: right;">' + this.telphone + '</td>';
					                html += '<td class="hidden-480">' + this.typeName + '</td>';
					                html += '<td class="hidden-480">' + this.brandName + '</td>';
					                html += '<td class="hidden-480">' + this.direction + '</td>';
					                html += '<td class="hidden-480 center"><a href="' + home_do_check_addLog + '?cstcode=' + this.cstcode + '"><i class="icon-plus-sign" style="color: #87b87f; font-size: 18px; cursor: pointer"></i></a></td>';
					            html += '</tr>';
			                });
			                html += '<tr style="background-color: #f5f5f5;">';
			                html += '<td></td>';
			                html += '<td colspan="10">';
				            html += '<button class="icon-cloud-download" style="background-color: #17a3ff;color: #FFF;border-style: none ;padding: 5px 10px;float: right;margin-left: 1%;cursor: pointer" id="toExcel">导出数据</button>';
				            html += '</td>';
				            html += '</tr>';
			                $('#listData').html(html);
			            }, 'json'); // 必须指定json，否则前台无法识别

			        }
			    });
		   }, 'json');
    	});