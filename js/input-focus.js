function hideFormText(){
	var _inputs = document.getElementsByTagName('input');
	var _value = [];
	if (_inputs) {
		for (var i = 0; i < _inputs.length; i++) {
			if (_inputs[i].type == 'text' || _inputs[i].type == 'password') {
				_inputs[i].index = i;
				_value[i] = _inputs[i].value;
				_inputs[i].onfocus = function(){
					if (this.value == _value[this.index])
						this.value = '';
				}
				_inputs[i].onblur = function(){
					if (this.value == '')
						this.value = _value[this.index];
				}
			}
		}
	}
}

if (window.addEventListener) 
	window.addEventListener("load", hideFormText, false);
else
	if (window.attachEvent) 
		window.attachEvent("onload", hideFormText);

/* clear textarea */
function clearContents(element) {
  element.value = '';
}