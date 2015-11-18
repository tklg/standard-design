// recreating jQuery :D
// because I'm not sure If i'm allowed to use jquery in cs146

(function() {
	window.NotJQuery = function(str) {
		if (str instanceof NotJQueryObject || str instanceof NotJQuery)
			return str;
		else
			return new NotJQuery(str);
	}
	window.$ = function(str) {
		return window.NotJQuery(str);
	}
	// an object to contain NotJQueryObject objects
	function NotJQuery(str) {
		//this.el = document.querySelector(str);
		try {
			// attempt to find element selected
			if (str instanceof Array) {
				console.log(str);
				this.el = [];
				for (i = 0; i < str.length; i++) {
					this.el.push(new NotJQueryObject(document.querySelector(str[i])));
				}
			} else {
				if (typeof str !== 'string') {
					newStr = str.nodeName.toLowerCase();
					if (str.id != '') newStr += '#' + str.id;
					if (str.className != '') newStr += '.' + str.className;
					str = newStr;
				}
				this.elems = document.querySelectorAll(str);
				this.el = [];
				for (i = 0; i < this.elems.length; i++) {
					this.el.push(new NotJQueryObject(this.elems[i]));
				}
			}
		} catch (e) {
			console.error("Cannot create NotJQuery from " + str);
			console.error(e.message);
		}
	}
	// a single element
	function NotJQueryObject(obj) {
		//this.el = document.querySelector(obj);
		this.el = obj;
	}
	// a workaround to allow things like $('a').all[0]
	NotJQuery.prototype.all = function() {
		return this.el;
	}

	// a method to change every object selected
	NotJQuery.prototype.html = function(str) {
	  	if (str == null) {
	    	return this.el[0].innerHTML;
	  	} else {
	  		for (i = 0; i < this.el.length; i++) {
	  			this.el[i].html(str);
	  		}
		    return this;
	  	}
	}
	// a method to change a single object
	NotJQueryObject.prototype.html = function(str) {
		if (str == null) {
	    	return this.el.innerHTML;
	  	} else {
		    this.el.innerHTML = str;
		    return this;
	  	}
	}

	NotJQuery.prototype.text = function(str) {
		if (str == null) {
			return this.el[0].innerHTML;
		} else {
			for (i = 0; i < this.el.length; i++) {
				this.el[i].innerHTML = str.replace(/&/g, "&amp;")
							        .replace(/</g, "&lt;")
							        .replace(/>/g, "&gt;")
							        .replace(/"/g, "&quot;")
							        .replace(/'/g, "&#039;");
			}
			return this;
		}
	}
	NotJQueryObject.prototype.text = function(str) {
		if (str == null) {
			return this.el.innerHTML;
		} else {
			this.el.innerHTML = str.replace(/&/g, "&amp;")
						        .replace(/</g, "&lt;")
						        .replace(/>/g, "&gt;")
						        .replace(/"/g, "&quot;")
						        .replace(/'/g, "&#039;");
			return this;
		}
	}
// this way of doing css gets messy eventually, fix it later 
	NotJQuery.prototype.css = function(obj, val) {
	    var str = '';
	    if (val == null) {
			for (var i in obj) {
		    	str += i + ": " + obj[i] + ";";
		    }
		    for (c = 0; i < this.el.length; c++) {
		    	this.el[c].el.style.cssText += str;
		    }
		} else {
			for (i = 0; i < this.el.length; i++) {
				this.el[i].el.style.cssText += obj + ":" + val + ";";
			}
		}
	  	return this;
	}
	NotJQueryObject.prototype.css = function(obj, val) {
	    var str = '';
	    if (val == null) {
			for (var i in obj) {
		    	str += i + ": " + obj[i] + ";";
		    }
		    this.el.style.cssText += str;
		} else {
			this.el.style.cssText += obj + ":" + val + ";";
		}
	  	return this;
	}

	NotJQuery.prototype.attr = function(attr, str) {
		for (i = 0; i < this.el.length; i++) {
	  		this.el[i].attr(attr, str);
	  	}
	  	return this;
	}
	NotJQueryObject.prototype.attr = function(attr, str) {
	  	this.el.setAttribute(attr, str);
	  	return this;
	}

	NotJQuery.prototype.on = function(event, fn) {
		for (i = 0; i < this.el.length; i++) {
			this.el[i].on(event, fn);
		}
		return this;
	}
	NotJQueryObject.prototype.on = function(event, fn) {
		this.el.addEventListener(event, fn);
		return this;
	}

	NotJQuery.prototype.off = function(event, fn) {
		for (i = 0; i < this.el.length; i++) {
			this.el[i].off(event, fn);
		}
		return this;
	}
	NotJQueryObject.prototype.off = function(event, fn) {
		this.el.removeEventListener(event, fn);
		return this;
	}

	NotJQuery.prototype.change = function(fn) {
		for (i = 0; i < this.el.length; i++) {
			this.el[i].on('change', fn);
		}
		return this;
	}
	NotJQueryObject.prototype.change = function(fn) {
		this.el.addEventListener('change', fn);
		return this;
	}

	NotJQuery.prototype.val = function(val) {
		try {
			if (val == null) {
				return this.el[0].val();
			} else {
				for (i = 0; i < this.el.length; i++) {
					this.el[i].val(val);
				}
				return this;
			}
		} catch (e) {
			console.warn("Cannot read value from a non-input element");
		}
	}
	NotJQueryObject.prototype.val = function(val) {
		try {
			if (val == null) {
				if (this.el.value == null) return '';
				else return this.el.value;
			} else {
				this.el.value = val;
				return this;
			}
		} catch (e) {
			console.warn("Cannot read value from a non-input element");
		}
	}

	NotJQuery.prototype.append = function(str) {
		for (i = 0; i < this.el.length; i++) {
			this.el[i].append(str);
		}
		return this;
	}
	NotJQueryObject.prototype.append = function(str) {
		this.el.insertAdjacentHTML('beforeend', str);
		return this;
	}

	NotJQuery.prototype.prepend = function(str) {
		for (i = 0; i < this.el.length; i++) {
			this.el[i].prepend(str);
		}
		return this;
	}
	NotJQueryObject.prototype.prepend = function(str) {
		this.el.insertAdjacentHTML('afterbegin', str);
		return this;
	}

	NotJQuery.prototype.remove = function() {
		for (i = 0; i < this.el.length; i++) {
			this.el[i].remove();
		}
	}
	NotJQueryObject.prototype.remove = function() {
		this.el.remove();
	}

	NotJQuery.prototype.empty = function() {
		for (i = 0; i < this.el.length; i++) {
			this.el[i].empty();
		}
	}
	NotJQueryObject.prototype.empty = function() {
		this.el.innerHTML = "";
	}

	NotJQuery.prototype.siblings = function() {
		return this.el[0].siblings();
	}
	NotJQueryObject.prototype.siblings = function() {
		var parent = this.el.parentElement;
		var siblings = parent.children;
		var str = this.el;
		var newStr = str.nodeName.toLowerCase();
		if (str.id != '') newStr += '#' + str.id;
		if (str.className != '') newStr += '.' + str.className;
		str = newStr;
		var newSib = [];
		for (i = 0; i < siblings.length; i++) {
			var sibStr = siblings[i].nodeName.toLowerCase();
			if (siblings[i].id != '') sibStr += '#' + siblings[i].id;
			if (siblings[i].className != '') sibStr += '.' + siblings[i].className;
			if (sibStr != str) newSib.push(sibStr);
		}
		return new NotJQuery(newSib);
	}

})();