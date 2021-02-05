(function($) {
	$.fn.showSuggestion = function(config) {
		new showSuggestion(config, this);
	};
}(jQuery));

function showSuggestion(config, elem)
{
	this.init(config, elem);
}

showSuggestion.prototype = {
	init : function(config, elem)
	{
		this.thisElement = elem;
		this.suggestionList = config.data;
		this.attr = config["attr"];
		this.searchBy = config["searchBy"];
		this.suggFormat = config["suggFormat"] || "$0";
		this.displayFormat = config["displayFormat"] || "$0";
		this.reqKeyCodes = [13,38,40];
		this.reqArrowKeys = [38,40];
		
		elem.attr("autocomplete", "off");
		this.registerEvents();
	},
	registerEvents : function()
	{
		var _this = this;
		elem = this.thisElement;
		elem.on('keyup focus', function(e){
			_this.renderSuggestionEle($(this), e)
		});
		elem.on('blur', function(e){
			elem.val(elem.attr("display"));
			$(".showSuggestionList").remove();
		});
	},
	getRenderSuggestionElePos : function(elem, listParentDOM)
	{
		var pos = {};
		var css = "", topPos, fixedParentDiv, isFixPar;
		var offsetVal = elem.offset();
		var width = elem.outerWidth();
		var isNeedScroll = listParentDOM.outerHeight() > 190 ? true : false;
		width = (width > 400) ? width : 400;
		topPos = offsetVal.top + elem.outerHeight();
		leftPos = offsetVal.left;
		
		fixedParentDiv = elem.parents().filter(function() {
			return $(this).css('position') == 'fixed';
		});
		isFixPar = fixedParentDiv.length ? true : false;
		if(isFixPar)
		{
			topPos -= $(window).scrollTop();
			leftPos -= $(window).scrollLeft();
			css = "position: fixed; ";
		}
		css += "top : " + topPos + "px; left:"+ leftPos + "px; width: "+ width +"px; " + (!isNeedScroll ? "overflow-y: auto;" : ""); 
		return css;
	},
	renderSuggestionEle : function(elem, e)
	{
		var _this = this;
		var reqKeys = _this.reqKeyCodes;
		var selectedSuggestion = [];
		var listDOM;
		var listParentDOM = $(".showSuggestionList");
		
		if(listParentDOM.length == 0)
		{
			var fileRef = document.createElement("div");
			fileRef.setAttribute("class","showSuggestionList");
			$("body").append(fileRef.outerHTML);
			listParentDOM = $(".showSuggestionList");
		}
		if(reqKeys.indexOf(e.keyCode) == -1)
		{
			listParentDOM.addClass("hidesuggestion");
			listParentDOM.html("");
			curVal = elem.val().toLowerCase();
			
			_this.suggestionList.forEach(function(list) {
				listDOM = _this.getElemFromCurList(list, curVal);
				if(listDOM)
				{
					selectedSuggestion.push(listDOM);
				}
			});
			if(selectedSuggestion.length > 0)
			{
				listParentDOM.removeClass("hidesuggestion");
				listParentDOM.attr("style", _this.getRenderSuggestionElePos(elem, listParentDOM));
				listParentDOM.html(selectedSuggestion.join(""));
				_this.registerSuggestionEvents();
			}
		}
	},
	getElemFromCurList : function(list, curVal)
	{
		var _this = this;
		var isCurAvail = false;
		var returnString = "";
		var displayFormat = _this.displayFormat;
		var suggFormat = _this.suggFormat;
		var elem = this.thisElement;
		var isSelectedList = false;
		var flag = 0, attrVal;
		var formatWithSearchTxt = function(txt)
		{
			var returnStr = txt;
			if(txt.toLowerCase().startsWith(curVal))
			{
				isCurAvail = true;
				prefixStr = '<span class="showHighSuggestionList">' + txt.substr(0, curVal.length) + '</span>';
				suffixStr = txt.substr(curVal.length);
				returnStr = prefixStr + suffixStr;
			}
			return returnStr;
		}
		_this.searchBy.forEach(function(val, i) {
			attrVal = _this.htmlDecode(list[val]);
			displayFormat = displayFormat.replace("$"+ i, attrVal);
			suggFormat = suggFormat.replace("$"+ i, formatWithSearchTxt(attrVal));
		});
		if(isCurAvail)
		{
			var fileRef = document.createElement("div");
			_this.attr.forEach(function(val) {
				if(elem.attr("sug-" + val) == list[val])
				{
					flag++;
				}
				fileRef.setAttribute("sug-" + val, list[val]);
			});
			if(flag == _this.attr.length && flag != 0)
			{
				isSelectedList = true;
			}
			fileRef.setAttribute("class","showSuggestionListItem "+ (isSelectedList ? "showSuggestionListItemActive" : ""));
			fileRef.setAttribute("display", displayFormat);
			fileRef.innerHTML = suggFormat;
			returnString = fileRef.outerHTML;
		}
		return returnString;
	},
	registerSuggestionEvents : function()
	{
		var _this = this;
		var reqArrowKeys = _this.reqArrowKeys;
		elem = this.thisElement;
		$(".showSuggestionListItem").off('mousedown').on('mousedown', function(){
			curElem = $(this);
			_this.attr.forEach(function(val) {
				elem.attr("sug-" + val, curElem.attr("sug-" + val));
			});
			var displayVal = curElem.attr("display");
			elem.val(displayVal);
			elem.attr("display", displayVal);
			$(".showSuggestionList").addClass("hidesuggestion");
		});
		
		$(".showSuggestionListItem").off('mouseover').on('mouseover', function(){
			$(".showSuggestionListItem").removeClass("showSuggestionListItemActive");
			$(this).addClass("showSuggestionListItemActive");
		});
		
		$(".showSuggestionList").off('mouseleave').on('mouseleave', function(){
			elem.trigger("blur");
		});
		
		elem.on('keydown', function(e){
			if($(".showSuggestionListItem").length)
			{
				var activeCls = "showSuggestionListItemActive";
				var activeEle = $(".showSuggestionListItem."+activeCls);
				if(e.keyCode == 13) //enter
				{
					activeEle.trigger("mousedown");
				}
				else if(reqArrowKeys.indexOf(e.keyCode) >= 0) //arrow
				{
					if(activeEle.length > 0)
					{
						if(activeEle.prev().length && e.keyCode == 38) //up
						{
							activeEle.removeClass(activeCls);
							activeEle.prev().addClass(activeCls);
						}
						else if(activeEle.next().length && e.keyCode == 40) //down
						{
							activeEle.removeClass(activeCls);
							activeEle.next().addClass(activeCls);
						}
					}
					else if(e.keyCode == 40) //down
					{
						$(".showSuggestionListItem").first().addClass(activeCls);
					}
				}
			}
		});
	},
	htmlDecode : function(string) {
        return $("<div/>").html(string).text();
    }
}