var Table = function(tableId) {
	this.tableId = tableId;
	this.$table = $("#"+this.tableId);
	// this.$thead = $("#"+this.tableId + " thead");
	// this.$tbody = $("#"+this.tableId + " tbody");
	this.rows = 0;
	this.editCols = [];
	this.newLineData = [];
	this.editable = false;

	Array.prototype.contains = function(item){
	    return RegExp(item).test(this);
	};

	// PUBLIC
	this.setEditable = function(editable) {
		this.editable = editable;
	}
	
	this.isEditable = function() {
		return this.editable;
	}
	
	// PUBLIC
	this.setHead = function(headerArray) {
		var htmlStr = "<thead><tr>";
		this.cols = headerArray.length;
		htmlStr += "<th>序号</th>";
		for (var i=0;i<this.cols;i++) {
			htmlStr += "<th>"+headerArray[i]+"</th>";
		}
		// ADD NEW BUTTON
		if (this.isEditable()) {
			htmlStr += "<th colspan=3><button name='newBtn' class='btn btn-success btn-block'>新增</button></th>";
		}
		htmlStr += "</tr></thead>";
		this.$table.append(htmlStr);
		this.$table.append("<tbody></tbody>");

		this.inputWidth = $("#"+this.tableId + " thead tr th").first().width();

		// this.activeNewBtn();
		// this.activeChgBtn();
		// this.activeDelBtn();
	}

	// PUBLIC
	this.setEditCols = function(cols) {
		for (var i=0,length=cols.length;i<length;i++) {
			this.editCols.push(cols[i]);
		}
	}

	// PUBLIC
	this.setNewLineData = function(newLineData) {
		this.newLineData = newLineData;
	}

	// PUBLIC
	this.addLine = function(contentArray, name, index){
		var htmlStr = this.addLineHelper(contentArray, name, index);
		$(htmlStr).appendTo(this.$table);
	}

	this.addLineHelper = function(contentArray, name, index){
		if (!index)
			this.rows = this.rows + 1;
		else
			this.rows = index;
		var width = this.inputWidth + "px";

		var htmlStr = "<tr name='"+name+"'>";
		htmlStr += "<td>"+this.rows+"</td>";
		for (var i=0,length=contentArray.length;i<length;i++) {
            if (contentArray[i].indexOf("image")==0) {
                htmlStr += "<td><img style='width:150px' src='data:"+contentArray[i]+"' /></td>";
            }else if (this.editCols.contains(i)) {
                htmlStr += "<td><input type=text style='width:"+width+"' value='"+contentArray[i]+"' /></td>";
			}else {
				htmlStr += "<td>"+contentArray[i]+"</td>";
			}
		}
	
		if (this.isEditable()) {
			// ADD CHANGE BUTTON
			htmlStr += "<td><button name='chgBtn' class='btn btn-warning btn-block'>修改</button></td>";
			// ADD DELETE BUTTON
			htmlStr += "<td><button name='delBtn' class='btn btn-danger btn-block'>删除</button></td>";
		}
        htmlStr += "<td><button name='lookBtn' class='btn btn-warning btn-block'>查看</button></td>";
        htmlStr += "</tr>";
        return htmlStr;
	}

	this.delLine = function(tr){
		var changeNumber = false;
		var table = this;
		$("#"+this.tableId + " tbody").children().each(function(i){
			if (changeNumber) {
				var number = $(this).children().first().text();
				$(this).children().first().text(number-1);
			}

			if (table.getVal(i,0) == tr.children().first().text()) {
				$(this).remove();
				changeNumber = true;
			}
		});
		this.rows = this.rows - 1;
	}

	this.getVal = function(row, col) {
		var val = "";
		$("#"+this.tableId + " tbody").children().each(function(i){
			if (row == i) {
				val = $(this).children().eq(col).text();
			}
		});
		return val;
	}

	this.activeNewBtn = function(){
		var table = this;
		var id = "#"+this.tableId+" button[name=newBtn]";
		$(document).on("click", id, function(){
			if (table.newLineData.length == 0) {
				for (var i=0,length=table.cols;i<length;i++) {
					table.newLineData.push("");
				}
			}
			var htmlStr = table.addLineHelper(table.newLineData, "", "0");
			$(htmlStr).prependTo(table.$table);
			// table.addLine(table.newLineData);
		});
		
	}

	this.delFun = [];
	// PUBLIC
	this.setDelFun = function(delFun) {
		this.delFun = delFun;
	}
	this.activeDelBtn = function(){
		var table = this;
		var id = "#"+this.tableId+" button[name=delBtn]";
		$(document).on("click", id, function(){
            var b = confirm("确定要删除？");
            if (!b) return;
			var tr = $(this).parent().parent();
			table.delLine(tr);

			// other actions
			for (var i = 0,length=table.delFun.length; i < length; i++) {
				table.delFun[i]($(this).parent().parent());
			}
		});
	}

	this.chgFun = [];
	// PUBLIC
	this.setChgFun = function(chgFun) {
		this.chgFun = chgFun;
	}
	this.activeChgBtn = function() {
		var table = this;
		var id = "#"+this.tableId+" button[name=chgBtn]";
		$(document).on("click", id, function(){
			for (var i = 0,length=table.chgFun.length; i < length; i++) {
				table.chgFun[i]($(this).parent().parent());
			}
		});
	}
	// PUBLIC
	this.setLookFun = function(lookFun) {
		this.lookFun = lookFun;
	}
	this.activeLookBtn = function() {
		var table = this;
		var id = "#"+this.tableId+" button[name=lookBtn]";
		$(document).on("click", id, function(){
			for (var i = 0,length=table.chgFun.length; i < length; i++) {
				table.lookFun[i]($(this).parent().parent());
			}
		});
	}
    
	this.activeNewBtn();
	this.activeChgBtn();
	this.activeDelBtn();
    this.activeLookBtn();
}

// PUBLIC
Table.prototype.getLineData = function($tr) {
	var data = [];
	$tr.children().each(function(){
		if ($(this).find("button").length == 0) {
			if ($(this).find("input").length == 0) {
				data.push($(this).text());
			}
			else {
				// input
				data.push($(this).children().first().val());
			}
		}
	});
	return data;
}
